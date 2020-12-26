<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Api\Callbacks;

class AdminCallbacks {
	
	/**
	 * @return mixed admin page template
	 */
	public function adminDashboard() {
		return require_once( PLUGIN_PATH . '/templates/admin.php' );
	}
	
	/**
	 * @param $input callback function for set_setting function in class Admin
	 *
	 * @return mixed
	 */
	public function novinhubOptionsGroup( $input ) {
		return $input;
	}
	
	/**
	 * Echo Novinhub Token to admin template
	 */
	public function novinhubAdminSection() {
		echo '<p>' . __( 'After installing the plugin, take your access token from your', 'novinhub') . '<a href="https://panel.novinhub.com/profile" target="_blank" style="text-decoration: none;">' . __(' Novinhub Profile ', 'novinhub') . '</a>' . __('and insert below.', 'novinhub') . '<p>';
	}
	
	/**
	 * Create input for novinhub_token in admin template
	 */
	public function novinhubGetToken() {
		$value = esc_attr( get_option( 'novinhub_token' ) );
		echo '<input type="text" class="regular-text col-12 col-sm-12" name="novinhub_token" value="' . $value . '" placeholder="' . __('Your Novinhub Token', 'novinhub') . '">';
	}
}