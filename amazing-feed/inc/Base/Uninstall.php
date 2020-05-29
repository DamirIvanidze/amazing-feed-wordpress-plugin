<?php
/**
 * @package  AmazingFeed
 */


/**
 * If uninstall.php is not called by WordPress, die
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}


$option_name = 'amazing_feed_settings';

delete_option( $option_name );