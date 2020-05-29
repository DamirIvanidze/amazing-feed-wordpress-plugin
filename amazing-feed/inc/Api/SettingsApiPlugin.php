<?
/**
 * @package  DeepLevelPlugin
 */

namespace Inc\Api;

class SettingsApiPlugin
{
	public $admin_pages = array(); // admin pages array
	public $admin_subpages = array(); // admin subpages array


	public function register() {
		if( !empty( $this->admin_pages ) ) {
			add_action( 'admin_menu', array( $this, 'addAdminMenu') );
		}
	}

	/**
	 * Get pages array from DashboardPlugin Class and set to $admin_pages array
	 */

	public function addPages( array $pages ) {
		$this->admin_pages = $pages;
		return $this;
	}

	/**
	 * Push to $admin_subpages array first element of $admin_pages array
	 */

	public function withSubPage( string $title = null )
	{
		if( empty( $this->admin_pages ) ) {
			return $this;
		}

		$this->admin_subpages = array(
			array(
				'parent_slug' => $this->admin_pages['0']['menu_slug'],
				'page_title' => $this->admin_pages['0']['page_title'],
				'menu_title' => ($title) ? $title : $this->admin_pages['0']['menu_title'],
				'capability' => $this->admin_pages['0']['capability'],
				'menu_slug' => $this->admin_pages['0']['menu_slug'],
				'callback' => $this->admin_pages['0']['callback'],
			)
		);

		return $this;
	}

	/**
	 * Get subpages array from DashboardPlugin Class and merge with $admin_subpages array
	 */
	public function addSubPages( array $pages ) {
		$this->admin_subpages = array_merge( $this->admin_subpages, $pages );
		return $this;
	}

	/**
	 * Add some admin pages and subpages in wp-admin menu
	 */
	public function addAdminMenu()
	{
		foreach ( $this->admin_pages as $page ) {
			add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
		}

		foreach ( $this->admin_subpages as $page ) {
			add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
		}
	}



	public static function vardump( $input )
	{
		if( !$input ) return false;

		if( gettype( $input ) == "boolean" ) echo var_dump($input);
		else echo "<pre>".print_r($input,true)."</pre>";
	}
}