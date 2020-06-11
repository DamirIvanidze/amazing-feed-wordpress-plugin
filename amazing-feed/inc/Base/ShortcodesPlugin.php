<?
/**
 * @package  DeepLevelPlugin
 */

namespace AF\Base;

class ShortcodesPlugin extends BaseControllerPlugin {

	public function register()
	{
		add_shortcode( 'twbs-flats-template', [ $this, 'twbsFlatsTemplate' ] );
		add_shortcode( 'uk-flats-template', [ $this, 'ukFlatsTemplate' ] );
		add_shortcode( 'amazing-feed-variable', [ $this, 'amazingFeedVariable' ] );
	}

	public function twbsFlatsTemplate( $atts )
	{
		ob_start();

		$attributes = shortcode_atts(
			array(
				'filters' => '',
				'filters_name' => '',
				'main_color_scss' => '',
				'main_color_hex' => '',
				'active_color_hex' => '',
				'ignore_url' => '',
				'cf7' => '',
			),
			$atts
		);

		if ( ! $attributes[ 'filters' ] || ! $attributes[ 'filters_name' ] || ! $attributes[ 'main_color_scss' ] || ! $attributes[ 'main_color_hex' ] || ! $attributes[ 'active_color_hex' ] ) return false;

		$filters = explode( ';', sanitize_text_field( $attributes[ 'filters' ] ) );
		$filters_name = explode( ';', sanitize_text_field( $attributes[ 'filters_name' ] ) );
		$main_color_scss = sanitize_text_field( $attributes[ 'main_color_scss' ] );
		$main_color_hex = sanitize_text_field( $attributes[ 'main_color_hex' ] );
		$active_color_hex = sanitize_text_field( $attributes[ 'active_color_hex' ] );
		$ignore_url = esc_url_raw( $attributes[ 'ignore_url' ] );
		$cf7 = sanitize_text_field( $attributes[ 'cf7' ] );

		wp_enqueue_style( 'ion-range-slider', $this->plugin_url . 'assets/css/modules/ion.rangeSlider.min.css', array(), null, 'all' );
		require_once $this->plugin_path . 'assets/css/twbs-shortcode-css.php';

		// wp_enqueue_script( 'mixitup', $this->plugin_url . '/assets/js/modules/mixitup/mixitup.min.js', array( 'jquery' ), null, true );
		// wp_enqueue_script( 'mixitup-multifilter', $this->plugin_url . '/assets/js/modules/mixitup/mixitup-multifilter.min.js', array( 'jquery' ), null, true );
		// wp_enqueue_script( 'mixitup-pagination', $this->plugin_url . '/assets/js/modules/mixitup/mixitup-pagination.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'ion-range-slider', $this->plugin_url . 'assets/js/modules/ion.rangeSlider.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'twbs-shortcode', $this->plugin_url . 'assets/js/twbs-shortcode.min.js', array( 'jquery' ), null, true );

		require_once $this->plugin_path . 'templates/no_pic.php';
		require_once $this->plugin_path . 'templates/twbs-flats-template.php';

		return ob_get_clean();
	}


	public function ukFlatsTemplate( $atts )
	{
		ob_start();

		$attributes = shortcode_atts(
			array(
				'filters' => '',
				'filters_name' => '',
				'main_color_scss' => '',
				'main_color_hex' => '',
				'active_color_hex' => '',
				'ignore_url' => '',
				'cf7' => '',
			),
			$atts
		);

		if ( ! $attributes[ 'filters' ] || ! $attributes[ 'filters_name' ] || ! $attributes[ 'main_color_scss' ] || ! $attributes[ 'main_color_hex' ] || ! $attributes[ 'active_color_hex' ] ) return false;

		$filters = explode( ';', sanitize_text_field( $attributes[ 'filters' ] ) );
		$filters_name = explode( ';', sanitize_text_field( $attributes[ 'filters_name' ] ) );
		$main_color_scss = sanitize_text_field( $attributes[ 'main_color_scss' ] );
		$main_color_hex = sanitize_text_field( $attributes[ 'main_color_hex' ] );
		$active_color_hex = sanitize_text_field( $attributes[ 'active_color_hex' ] );
		$ignore_url = esc_url_raw( $attributes[ 'ignore_url' ] );
		$cf7 = sanitize_text_field( $attributes[ 'cf7' ] );

		wp_enqueue_style( 'ion-range-slider', $this->plugin_url . 'assets/css/modules/ion.rangeSlider.min.css', array(), null, 'all' );
		require_once $this->plugin_path . 'assets/css/uk-shortcode-css.php';

		wp_enqueue_script( 'mixitup', $this->plugin_url . '/assets/js/modules/mixitup/mixitup.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'mixitup-multifilter', $this->plugin_url . '/assets/js/modules/mixitup/mixitup-multifilter.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'mixitup-pagination', $this->plugin_url . '/assets/js/modules/mixitup/mixitup-pagination.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'ion-range-slider', $this->plugin_url . 'assets/js/modules/ion.rangeSlider.min.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'uk-shortcode', $this->plugin_url . 'assets/js/uk-shortcode.min.js?'.time(), array( 'jquery' ), null, true );

		require_once $this->plugin_path . 'templates/no_pic.php';
		require_once $this->plugin_path . 'templates/uk-flats-template.php';

		return ob_get_clean();
	}


	public function amazingFeedVariable( $atts )
	{
		$attributes = shortcode_atts(
			array(
				'variable' => '',
			),
			$atts
		);

		if ( ! $attributes[ 'variable' ] ) return false;

		$output = get_option( 'amazing_feed_settings' );

		if( $attributes[ 'variable' ] == 'phone' ) {
			$phone = $output[ 'variables' ][ $attributes[ 'variable' ] ];
			$phone_href = '+'.preg_replace('![^0-9]+!', '', $phone);
			return '<a href="tel:' . $phone_href . '" class="phone">' . $phone . '</a>';
		}
		else return $output[ 'variables' ][ $attributes[ 'variable' ] ];
	}
}