<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class NovinhubWPEnqueue {
	
	/**
	 * Add hook for enqueue scripts and styles for admin page
	 */
	public function novinhubWPRegister() {
		add_action( 'init', [ $this, 'novinhubWPInit' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'novinhubWPEnqueue' ] );
	}
	
	public function novinhubWPInit() {
	
	}
	
	public function novinhubWPEnqueue() {
		global $hook_suffix;
		if ( in_array( $hook_suffix, [
			'toplevel_page_Novinhub_Plugin',
			'post.php',
			'post-new.php',
		] ) ) {
			wp_enqueue_style( 'mypluginstyle1',
                NOVINHUBWP_PLUGIN_URL . 'assets/styles/mystyle.css' );
			
			
			wp_add_inline_script( 'jquery-core', '$ = jQuery;' );
			
			
		}
		
		if ( $hook_suffix === 'post.php' or $hook_suffix === 'post-new.php' ) {
			wp_enqueue_style( 'date-picker',
                NOVINHUBWP_PLUGIN_URL . 'assets/styles/persian-datepicker.css' );
			
			wp_enqueue_script( 'persian-date',
                NOVINHUBWP_PLUGIN_URL . 'assets/scripts/persian-date.js', [ 'jquery' ] );
			
			wp_enqueue_script( 'persian-datepicker',
                NOVINHUBWP_PLUGIN_URL . 'assets/scripts/persian-datepicker.js',
				[ 'jquery' ] );
			
			wp_enqueue_script( 'post-js',
                NOVINHUBWP_PLUGIN_URL . 'assets/scripts/post.js', [ 'jquery' ] );
		}
		
	}
}
