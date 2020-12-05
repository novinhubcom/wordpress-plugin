<?php
/**
 * @package Novinhub
 */

namespace Inc\Base;

class Languages {
	
	/**
	 * Add hook for load language text domain after plugin loads
	 */
	public function register() {
		add_action( 'plugins_loaded', [ $this, 'languages' ] );
	}
	
	public function languages() {
		return load_plugin_textdomain( 'novinhub', false,
			dirname( plugin_basename( __FILE__ ) ) . '/../../languages/' );
	}
}