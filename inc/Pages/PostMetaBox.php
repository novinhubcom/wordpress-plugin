<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Pages;


class PostMetaBox {
	
	private $if_has_token = false;
	
	public function __construct() {
		if ( ! empty( get_option( 'novinhub_token' ) ) ) {
			$this->if_has_token = true;
		}
	}
	
	/**
	 * Add hook for add meta box if access token available
	 */
	public function register() {
		if ( $this->if_has_token ) {
			add_action( 'add_meta_boxes', [ $this, 'add_box' ] );
			//		add_action( 'save_post', [ $this, 'save_post' ] );
		}
	}
	
	public function add_box() {
		add_meta_box( 'novinhub_post_page',
			translate( __( 'Added by Novinhub', 'novinhub' ) ), [
				$this,
				'novinhub_post_page_html',
			], 'post' );
	}
	
	/**
	 * Include post template
	 */
	public function novinhub_post_page_html() {
		
		require_once( PLUGIN_PATH . '/templates/post.php' );
		
	}
}