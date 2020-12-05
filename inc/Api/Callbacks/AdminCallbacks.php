<?php
/**
 * @package Novinhub
 */

namespace Inc\Api\Callbacks;

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
		echo __( 'Novinhub Token', 'novinhub' );
	}
	
	/**
	 * Create input for novinhub_token in admin template
	 */
	public function novinhubGetToken() {
		$value = esc_attr( get_option( 'novinhub_token' ) );
		echo '<input type="text" class="regular-text col-12" name="novinhub_token" value="' . $value . '" placeholder="' . __('Your Novinhub Token', 'novinhub') . '">';
	}
}