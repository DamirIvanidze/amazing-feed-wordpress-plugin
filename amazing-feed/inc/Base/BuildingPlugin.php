<?
/**
 * @package  AmazingFeed
 */

namespace AF\Base;

use DOMDocument;
use DOMXPath;

class BuildingPlugin {
	public function getImagesFromUrl( $array = array() )
	{
		$site_parse_url = parse_url( $array[ 'site_parse_page' ] )[ 'scheme' ] . '://' . parse_url( $array[ 'site_parse_page' ] )[ 'host' ];

		libxml_use_internal_errors(true);

		$dom = new DOMDocument();
		$dom->loadHTMLFile( $array[ 'site_parse_page' ] );
		$x_path = new DOMXPath( $dom );

		$href_array = [];
		$title_array = [];

		$nodes= $x_path->query('//*[@id="' . $array[ 'id_for_find' ] . '"]');

		foreach ( $nodes as $node ) {
			$hrefs = $x_path->query('.//a[contains(@class, "' . $array[ 'link_class_for_find' ] . '")]', $node);
			foreach ( $hrefs as $key => $value ) {
				if( $array[ 'no_image' ] ) $href_array[$key][] = $array[ 'site_parse_page' ] . '/' . $value->getAttribute( 'href' );
				else $href_array[$key][] = $site_parse_url . '/' . $value->getAttribute( 'href' );
				if($key == 4) break;
			}

			$titles = $x_path->query('.//*[contains(@class, "' . $array[ 'title_class_for_find' ] . '")]', $node);
			foreach ( $titles as $key => $value ) {
				if( $array[ 'utf8_decode' ] ) $title_array[$key][] = utf8_decode( $value->nodeValue );
				else $title_array[$key][] = $value->nodeValue;
				if($key == 4) break;
			}
		}


		$merged = array_map(function ($c, $s) {
			return array_merge($c, $s);
		}, $href_array, $title_array);


		foreach ($merged as $key => $value) {
			$link = $value[0];

			$new_dom = new DOMDocument();
			$new_dom->loadHTMLFile( $link );
			$new_xpath = new DOMXPath( $new_dom );

			foreach( $new_xpath->query( '//*[@class="' . $array[ 'block_image_class' ] . '"]//img') as $node ) {
				$href = $node->getAttribute( $array[ 'image_attr' ] );
				$merged[$key]['images'][] = $site_parse_url . $href;
			}
		}


		return $merged;
	}
}