<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class NovinhubWPActivate {
	
	/**
	 * To activate plugin
	 */
	public static function novinhubWPActivate() {
		flush_rewrite_rules();
	}
}