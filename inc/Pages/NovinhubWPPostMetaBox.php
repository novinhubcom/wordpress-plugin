<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Pages;


class NovinhubWPPostMetaBox {
	
	private $if_has_token = false;
	
	public function __construct() {
		if ( ! empty( get_option( 'novinhub_token' ) ) ) {
			$this->if_has_token = true;
		}
	}
	
	/**
	 * Add hook for add meta box if access token available
	 */
	public function novinhubWPRegister() {
		if ( $this->if_has_token ) {
			add_action( 'add_meta_boxes', [ $this, 'novinhubWPAddBox' ] );
		}
	}
	
	public function novinhubWPAddBox() {
		add_meta_box( 'novinhub_post_page',
			translate( esc_html(__( 'Novinhub', 'novinhub' )) ), [
				$this,
				'novinhubWPPostPageHtml',
			] );
	}
	
	/**
	 * Include post template
	 */
	public function novinhubWPPostPageHtml() {
		
		require_once( NOVINHUBWP_PLUGIN_PATH . '/templates/post.php' );
		
	}
}