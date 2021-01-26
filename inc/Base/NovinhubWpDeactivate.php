<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class NovinhubWpDeactivate {
	
	/**
	 * To deactivate plugin
	 */
	public static function novinhubWPDeactivate() {
		delete_option('novinhub_token');
		flush_rewrite_rules();
	}
}