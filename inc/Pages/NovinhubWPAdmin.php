<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Pages;

use Novinhub\Inc\Api\NovinhubWPApiSettings;
use Novinhub\Inc\Api\Callbacks\NovinhubWPAdminCallbacks;

class NovinhubWPAdmin {

	public $settings = [];
	public $pages = [];
	public $callbacks;
	
	
	public function __construct() {
		$this->settings  = new NovinhubWPApiSettings();
		$this->callbacks = new NovinhubWPAdminCallbacks();
		$this->pages     = [
			[
				'page_title' => __( 'Novinhub Plugin', 'novinhub' ),
				'menu_title' => __( 'Novinhub', 'novinhub' ),
				'capability' => 'manage_options',
				'menu_slug'  => 'Novinhub_Plugin',
				'callback'   => [ $this->callbacks, 'novinhubWPAdminDashboard' ],
//				'icon_url'   => plugins_url( '../../assets/images/logo2.png', __FILE__),
				'icon_url' => 'https://novinhub.com/assets/img/logo/novinhub-icon-16.png',
				'position'   => 110,
			],
		];
		
		$this->novinhubWPSetSettings();
		$this->novinhubWPSetSections();
		$this->novinhubWPSetFields();
	}
	
	public function novinhubWPRegister() {
		
		
		$this->settings->novinhubWPAddPages( $this->pages )->novinhubWPRegister();
	}
	
	public function novinhubWPSetSettings() {
		
		$args = [
			[
				'option_group' => 'novinhub_options_group',
				'option_name'  => 'novinhub_token',
				'callback'     => [ $this->callbacks, 'novinhubWPOptionsGroup' ],
			],
		];
		
		$this->settings->novinhubWPSetSettings( $args );
	}
	
	public function novinhubWPSetSections() {
		$args = [
			[
				'id'       => 'novinhub_admin_index',
				'title'    => esc_html(__( 'Settings', 'novinhub' )),
				'callback' => [ $this->callbacks, 'novinhubWPAdminSection' ],
				'page'     => 'Novinhub_Plugin',
			],
		];
		
		$this->settings->novinhubWPSetSections( $args );
	}
	
	public function novinhubWPSetFields() {
		$args = [
			[
				'id'       => 'novinhub_token',
				'title'    => esc_attr(get_option( 'novinhub_token' )) === '' ? esc_html(__( 'Enter your Token Here',
					'novinhub' )) :
                    esc_html(__( 'Your Token is', 'novinhub' )),
				'callback' => [ $this->callbacks, 'novinhubWPGetToken' ],
				'page'     => 'Novinhub_Plugin',
				'section'  => 'novinhub_admin_index',
				'args'     => [
					'label_for' => 'novinhub_token',
					'class'     => 'example-class',
				],
			],
		];
		
		$this->settings->novinhubWPSetFields( $args );
	}
}