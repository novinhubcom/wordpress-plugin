<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class NovinhubWPLanguages {
	
	/**
	 * Add hook for load language text domain after plugin loads
	 */
	public function novinhubWPRegister() {
		add_action( 'plugins_loaded', [ $this, 'novinhubWPLanguages' ] );
	}
	
	public function novinhubWPLanguages() {
		return load_plugin_textdomain( 'novinhub', false,
			dirname( plugin_basename( __FILE__ ) ) . '/../../languages/' );
	}
}