<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Api\Callbacks;

class NovinhubWPAdminCallbacks {
	
	/**
	 * @return mixed admin page template
	 */
	public function novinhubWPAdminDashboard() {
		return require_once( NOVINHUBWP_PLUGIN_PATH . '/templates/admin.php' );
	}
	
	/**
	 * @param $input callback function for set_setting function in class Admin
	 *
	 * @return mixed
	 */
	public function novinhubWPOptionsGroup( $input ) {
		return $input;
	}
	
	/**
	 * Echo Novinhub Token to admin template
	 */
	public function novinhubWPAdminSection() {
		echo '<p>' . esc_html(__( 'After installing the plugin, take your access token from your', 'novinhub')) . '<a href="https://panel.novinhub.com/profile" target="_blank" style="text-decoration: none;">' . esc_html(__(' Novinhub Profile ', 'novinhub')) . '</a>' . esc_html(__('and insert below.', 'novinhub')) . '<p>';
	}
	
	/**
	 * Create input for novinhub_token in admin template
	 */
	public function novinhubWPGetToken() {
		$value = esc_attr( get_option( 'novinhub_token' ) );
		echo '<input type="text" class="regular-text col-12 col-sm-12" name="novinhub_token" value="' . $value . '" placeholder="' . esc_html(__('Your Novinhub Token', 'novinhub')) . '">';
	}
}