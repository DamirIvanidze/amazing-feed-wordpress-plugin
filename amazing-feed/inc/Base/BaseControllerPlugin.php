<?
/**
 * @package  AmazingFeed
 */

namespace AF\Base;

class BaseControllerPlugin {

	public $plugin_path;
	public $plugin_url;
	public $plugin;

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ) . '/amazing-feed.php';

		add_filter( 'intermediate_image_sizes', [ $this, 'dco_remove_default_image_sizes' ] );
		add_action( 'init', [ $this, 'remove_all_image_sizes' ] );
	}


	public function adminDashboardTemplate()
	{
		return require_once( $this->plugin_path . 'templates/dashboard.php' );
	}

	public function adminSettingsTemplate()
	{
		return require_once( $this->plugin_path . 'templates/settings.php' );
	}


	public function dco_remove_default_image_sizes( $sizes ) {
		return array_diff( $sizes, array(
			'thumbnail',
			'medium',
			'medium_large',
			'large',
		) );
	}

	public function remove_all_image_sizes() {
		foreach( get_intermediate_image_sizes() as $size ) {
			remove_image_size( $size );
		}
	}
}