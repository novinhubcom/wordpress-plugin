<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc;

final class NovinhubWPInit
{
	/**
	 * Store all classes inside an array
	 * @return array List of classes
	 */
	public static function novinhubWPGetServices() {
		return [
			Pages\NovinhubWPAdmin::class,
			Base\NovinhubWPEnqueue::class,
			Base\NovinhubWPSettingsLinks::class,
			Pages\NovinhubWPPostMetaBox::class,
			Base\NovinhubWPLanguages::class,
			Base\NovinhubWPAjax::class
		];
	}

	/**
	 * Loop through classes and initialize them,
	 * then call the register() method if it exists
	 */
	public static function novinhubWPRegisterServices() {

		foreach ( self::novinhubWPGetServices() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'novinhubWPRegister' ) ) {
				$service->novinhubWPRegister();
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