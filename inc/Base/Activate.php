<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class Activate {
	
	/**
	 * To activate plugin
	 */
	public static function activate() {
		flush_rewrite_rules();
	}
}