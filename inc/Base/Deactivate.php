<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class Deactivate {
	
	/**
	 * To deactivate plugin
	 */
	public static function deactivate() {
		delete_option('novinhub_token');
		flush_rewrite_rules();
	}
}