<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc;

final class Init
{
	/**
	 * Store all classes inside an array
	 * @return array List of classes
	 */
	public static function get_services() {
		return [
			Pages\Admin::class,
			Base\Enqueue::class,
			Base\SettingsLinks::class,
			Pages\PostMetaBox::class,
			Base\Languages::class,
			Base\Ajax::class
		];
	}

	/**
	 * Loop through classes and initialize them,
	 * then call the register() method if it exists
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
	 * @param class $class Input class from services array
	 *
	 * @return class instance New instance of the class
	 */
	private static function instantiate( $class ) {

		$service = new $class;

		return $service;
	}
}