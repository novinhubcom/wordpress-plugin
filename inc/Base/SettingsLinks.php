<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class SettingsLinks {
	
	/**
	 * Add hook for plugin action links
	 */
	public function register() {
		add_filter( 'plugin_action_links_' . PLUGIN,
			[ $this, 'settings_link' ] );
	}
	
	/**
	 * @param $links
	 *
	 * @return links
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=Novinhub_Plugin">' . __('Settings', 'novinhub') . '</a>';
		array_push( $links, $settings_link );
		
		return $links;
	}
}