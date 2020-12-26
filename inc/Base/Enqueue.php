<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

class Enqueue {
	
	/**
	 * Add hook for enqueue scripts and styles for admin page
	 */
	public function register() {
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}
	
	public function init() {
	
	}
	
	public function enqueue() {
		global $hook_suffix;
		if ( in_array( $hook_suffix, [
			'toplevel_page_Novinhub_Plugin',
			'post.php',
			'post-new.php',
		] ) ) {
			wp_enqueue_style( 'mypluginstyle1',
				PLUGIN_URL . 'assets/styles/mystyle.css' );
			
			
			wp_add_inline_script( 'jquery-core', '$ = jQuery;' );
			
			
		}
		
		if ( $hook_suffix === 'post.php' or $hook_suffix === 'post-new.php' ) {
			wp_enqueue_style( 'date-picker',
				PLUGIN_URL . 'assets/styles/persian-datepicker.css' );
			
			wp_enqueue_script( 'persian-date',
				PLUGIN_URL . 'assets/scripts/persian-date.js', [ 'jquery' ] );
			
			wp_enqueue_script( 'persian-datepicker',
				PLUGIN_URL . 'assets/scripts/persian-datepicker.js',
				[ 'jquery' ] );
			
			wp_enqueue_script( 'post-js',
				PLUGIN_URL . 'assets/scripts/post.js', [ 'jquery' ] );
		}
		
	}
}
