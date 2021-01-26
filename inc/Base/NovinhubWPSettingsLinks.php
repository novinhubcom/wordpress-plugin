<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class NovinhubWPSettingsLinks {
	
	/**
	 * Add hook for plugin action links
	 */
	public function novinhubWPRegister() {
		add_filter( 'plugin_action_links_' . NOVINHUBWP_PLUGIN,
			[ $this, 'novinhubWPSettingsLink' ] );
	}
	
	/**
	 * @param $links
	 *
	 * @return links
	 */
	public function novinhubWPSettingsLink( $links ) {
		$settings_link = '<a href="admin.php?page=Novinhub_Plugin">' . esc_html(__('Settings', 'novinhub')) . '</a>';
		array_push( $links, $settings_link );
		
		return $links;
	}
}