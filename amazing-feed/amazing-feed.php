<?
/**
 * @package  AmazingFeed
 */


/**
* Plugin Name: Amazing Feed
* Plugin URI:
* Description: Ежедневно обновляем фид новостроек.
* Version: 3.0
* Author: damir.ivanidze
* Author URI: https://bitbybit.su
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: amazing-feed
*/


/*
Amazing Feed is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Amazing Feed is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Amazing Feed.
*/

/**
 * If this file is called firectly, abort!!!
 */
defined( 'ABSPATH' ) or die( 'Hey! What are you doing here? You silly human!' );


/**
 * Require once the Composer Autoload
 */
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}


/**
 * The code that runs during plugin activation
 */
function activate_amazing_feed() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_amazing_feed' );


/**
 * The code that runs during plugin deactivation
 */
function deactivate_amazing_feed() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_amazing_feed' );


/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\InitPlugin' ) ) {
    Inc\InitPlugin::register_services();
}