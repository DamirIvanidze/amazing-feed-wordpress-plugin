<?
/**
 * @package  DeepLevelPlugin
 */

namespace Inc\Base;

class EnqueuePlugin extends BaseControllerPlugin {

	public function register()
	{
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue') );
	}

	public function enqueue( $hook )
	{
		$admin_pages_array = array(
			'toplevel_page_amazing_feed',
			'amazing-feed_page_amazing_feed_settings',
		);

		if( in_array( $hook, $admin_pages_array ) ) {
			wp_enqueue_style( 'admin-style', $this->plugin_url . 'assets/css/admin.style.min.css?' . time(), array(), null, 'all' );
			wp_enqueue_style( 'flexboxgrid', $this->plugin_url . 'assets/css/flexboxgrid.min.css', array(), null, 'all' );
			wp_enqueue_style( 'swiper', $this->plugin_url . 'assets/css/swiper.min.css', array(), null, 'all' );

			wp_enqueue_script( 'admin-script', $this->plugin_url . 'assets/js/admin.script.min.js?' . time(), array( 'jquery-form' ), null, true );
			wp_enqueue_script( 'jquery-ui', $this->plugin_url . 'assets/js/jquery-ui.min.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'swiper', $this->plugin_url . 'assets/js/swiper.min.js', array( 'jquery' ), null, true );

			wp_enqueue_script( 'jquery-form' );
			wp_localize_script( 'admin-script', 'ajax_var', admin_url( 'admin-ajax.php' ) );
		}
		else return;
	}
}