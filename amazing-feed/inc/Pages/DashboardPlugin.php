<?
/**
 * @package  DeepLevelPlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseControllerPlugin; // store variables
use \Inc\Api\SettingsApiPlugin; // add some admin pages and subpages in wp-admin menu

class DashboardPlugin extends BaseControllerPlugin
{
    public $settings; // for SettingsApiPlugin Class
    public $pages = array(); // array of admin pages
    public $subpages = array(); // array of admin subpages

    public function register()
    {
        $this->settings = new SettingsApiPlugin(); // initialize SettingsApiPlugin Class

        $this->setPages(); // add info about admin page into array

        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'Amazing Feed',
                'menu_title' => 'Amazing Feed',
                'capability' => 'manage_options',
                'menu_slug' => 'amazing_feed',
                'callback' => array( $this, 'adminDashboardTemplate' ),
                'icon_url' => 'dashicons-update-alt',
                'position' => 110
            )
        );

        $this->subpages = array(
            array(
                'parent_slug' => 'amazing_feed',
                'page_title' => 'Настройки',
                'menu_title' => 'Настройки',
                'capability' => 'manage_options',
                'menu_slug' => 'amazing_feed_settings',
                'callback' => array( $this, 'adminSettingsTemplate' ),
            )
        );
    }
}