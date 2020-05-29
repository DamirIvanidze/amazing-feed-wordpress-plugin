<?
/**
 * @package  AmazingFeed
 */

namespace Inc;

final class InitPlugin {

	/**
	 *
	 * Store all the classes inside an array
	 * @return array full list of classes
	 */

	public static function get_services() {
		return [
			Pages\DashboardPlugin::class,
			Base\EnqueuePlugin::class,
			Base\AjaxPlugin::class,
		];
	}


	/**
	 *
	 * Loop through the classes, initialize them,
	 * and call the register() method if it exists
	 * self - for static
	 *
	 */

	public static function register_services() {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}


	/**
	 *
	 * Initialize class
	 * @param class $class  class from the servisec array
	 * @return class instance  new instance of the class
	 *
	 */

	private static function instantiate( $class ) {
		$service = new $class();
		return $service;
	}
}