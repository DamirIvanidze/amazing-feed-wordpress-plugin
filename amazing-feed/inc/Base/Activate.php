<?php
/**
 * @package  AmazingFeed
 */

namespace AF\Base;

class Activate {
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

		if( ! get_option( 'amazing_feed_settings') ){
			update_option( 'amazing_feed_settings', $default);
		}
	}
}