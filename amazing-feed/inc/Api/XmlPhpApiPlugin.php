<?
/**
 * @package  DeepLevelPlugin
 */

namespace AF\Api;

use \AF\Api\SettingsApiPlugin;

class XmlPhpApiPlugin
{
	public $settings;
	public $output;
	public $xml;
	public $offers;


	public function __construct()
	{
		$this->settings = new SettingsApiPlugin();

		$this->output = get_option( 'amazing_feed_settings' );

		$this->xml = $this->simplexmlLoadStringNons( $this->output[ 'parse_link' ] );

		if( ! $this->xml ) return false;

		$this->offers = $this->xml->xpath('//offer[building-name[contains(.,"'. $this->output[ 'complex_name' ] .'")]]');
	}

	public function checkXml()
	{
		if( $this->xml ) return true;

		return false;
	}

	public function checkOffers()
	{
		if( $this->offers ) return true;

		return false;
	}

	public function getCronOffersCount()
	{
		return count( $this->offers );
	}


	public function simplexmlLoadStringNons( $xml, $sxclass = 'SimpleXMLElement', $nsattr = false, $flags = null )
	{
		// Validate arguments first
		if( !is_string( $sxclass ) or empty( $sxclass ) or !class_exists( $sxclass ) ) {
			trigger_error( '$sxclass must be a SimpleXMLElement or a derived class.', E_USER_WARNING );
			return false;
		}

		if(!is_string( $xml ) or empty( $xml ) ) {
			trigger_error( '$xml must be a non-empty string.', E_USER_WARNING );
			return false;
		}

		// Load XML if URL is provided as XML
		if( preg_match( '~^https?://[^\s]+$~i', $xml ) || file_exists( $xml ) ) {
			$xml = file_get_contents( $xml );
		}

		// Let's drop namespace definitions
		if( stripos( $xml, 'xmlns=' ) !== false ) {
			$xml = preg_replace( '~[\s]+xmlns=[\'"].+?[\'"]~i', null, $xml );
		}

		// I know this looks kind of funny but it changes namespaced attributes
		if(preg_match_all( '~xmlns:([a-z0-9]+)=~i', $xml, $matches ) ) {
			foreach( ( $file_namespaces = array_unique( $matches[1] ) ) as $file_namespace ) {
				$escaped_namespace = preg_quote( $file_namespace, '~');
				$xml = preg_replace( '~[\s]xmlns:'.$escaped_namespace.'=[\'].+?[\']~i', null, $xml );
				$xml = preg_replace( '~[\s]xmlns:'.$escaped_namespace.'=["].+?["]~i', null, $xml );
				$xml = preg_replace( '~([\'"\s])'.$escaped_namespace.':~i', '$1'.$file_namespace.'_', $xml );
			}
		}

		// Let's change <namespace:tag to <namespace_tag ns="namespace"
		$regexfrom = sprintf( '~<([a-z0-9]+):%s~is', !empty( $nsattr) ? '([a-z0-9]+)' : null);
		$regexto = strlen( $nsattr ) ? '<$1_$2 '.$nsattr.'="$1"' : '<$1_';
		$xml = preg_replace( $regexfrom, $regexto, $xml );

		// Let's change </namespace:tag> to </namespace_tag>
		$xml = preg_replace( '~</([a-z0-9]+):~is', '</$1_', $xml );

		// Default flags I use
		if( empty( $flags ) ) $flags = LIBXML_COMPACT | LIBXML_NOBLANKS | LIBXML_NOCDATA;

		// Now load and return (namespaceless)
		return $xml = simplexml_load_string( $xml, $sxclass, $flags );
	}


	public function showXml()
	{
		foreach ( $this->offers as $offer ) {
			echo '<div class="xml swiper-slide">';
				echo '<div class="xml__tag">&lt;<span class="xml__tagname" data-xpath="@internal-id">offer</span> <span class="xml__attr">internal-id</span>=' . $offer['internal-id'] . '&gt;</div>';
					echo '<div class="xml__padding">';
						$this->recursiveOfferLoop( $offer );
					echo '</div>';
				echo '<div class="xml__tag">&lt;&#8260;<span class="xml__tagname">offer</span>&gt;</div>';
			echo '</div>';
		}
	}


	public function recursiveOfferLoop( $offer, $path = '' )
	{
		foreach ( $offer as $node ) {
			if( count( $node ) > 0 ){
				echo '<div class="xml__tag">&lt;<span class="xml__tagname">' . $node->getName() . '</span>&gt;</div>';
					echo '<div class="xml__padding">';
						$path .= $node->getName();
						$this->recursiveOfferLoop( $node, $path );
						$path = '';
					echo '</div>';
				echo '<div class="xml__tag">&lt;&#8260;<span class="xml__tagname">' . $node->getName() . '</span>&gt;</div>';
			}
			else{
				$last_path = substr( dom_import_simplexml( $node )->getNodePath(), strrpos( dom_import_simplexml( $node )->getNodePath(), '/' ) + 1 );

				$final_path = $path ? $path . '/' . $last_path : '' . $last_path;

				echo '<div class="xml__tag">';
					echo '&lt;<span class="xml__tagname" data-xpath="' . $final_path . '">' . $node->getName() . '</span>&gt;';
					echo '<span>' . $node . '</span>';
					echo '&lt;&#8260;<span class="xml__tagname" data-xpath="' . $final_path . '">' . $node->getName() . '</span>&gt;';
				echo '</div>';
			}
		}
	}
}