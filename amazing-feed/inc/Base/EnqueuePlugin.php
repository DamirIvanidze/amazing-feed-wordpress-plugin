<?
/**
 * @package  DeepLevelPlugin
 */

namespace AF\Base;

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
			'amazing-feed_page_amazing_feed_shortcodes',
			'amazing-feed_page_amazing_feed_variables',
			'amazing-feed_page_amazing_feed_building',
		);

		if( in_array( $hook, $admin_pages_array ) ) {
			wp_enqueue_style( 'admin-style', $this->plugin_url . 'assets/css/admin.style.min.css', array(), null, 'all' );
			wp_enqueue_style( 'flexboxgrid', $this->plugin_url . 'assets/css/modules/flexboxgrid.min.css', array(), null, 'all' );
			wp_enqueue_style( 'swiper', $this->plugin_url . 'assets/css/modules/swiper.min.css', array(), null, 'all' );

			wp_enqueue_script( 'admin-script', $this->plugin_url . 'assets/js/admin.script.min.js', array( 'jquery-form' ), null, true );
			wp_enqueue_script( 'jquery-ui', $this->plugin_url . 'assets/js/modules/jquery-ui.min.js', array( 'jquery' ), null, true );
			wp_enqueue_script( 'swiper', $this->plugin_url . 'assets/js/modules/swiper.min.js', array( 'jquery' ), null, true );

			wp_enqueue_script( 'jquery-form' );
			wp_localize_script( 'admin-script', 'ajax_var', admin_url( 'admin-ajax.php' ) );
		}
		else return;
	}
}