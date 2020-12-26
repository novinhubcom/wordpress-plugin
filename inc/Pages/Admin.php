<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Pages;

use Novinhub\Inc\Api\ApiSettings;
use Novinhub\Inc\Api\Callbacks\AdminCallbacks;

class Admin {
	
	public $settings = [];
	public $pages = [];
	public $callbacks;
	
	
	public function __construct() {
		$this->settings  = new ApiSettings();
		$this->callbacks = new AdminCallbacks();
		$this->pages     = [
			[
				'page_title' => __( 'Novinhub Plugin', 'novinhub' ),
				'menu_title' => __( 'Novinhub', 'novinhub' ),
				'capability' => 'manage_options',
				'menu_slug'  => 'Novinhub_Plugin',
				'callback'   => [ $this->callbacks, 'AdminDashboard' ],
//				'icon_url'   => plugins_url( '../../assets/images/logo2.png', __FILE__),
				'icon_url' => 'https://novinhub.com/assets/img/logo/novinhub-icon-16.png',
				'position'   => 110,
			],
		];
		
		$this->setSettings();
		$this->setSections();
		$this->setFields();
	}
	
	public function register() {
		
		
		$this->settings->addPages( $this->pages )->register();
	}
	
	public function setSettings() {
		
		$args = [
			[
				'option_group' => 'novinhub_options_group',
				'option_name'  => 'novinhub_token',
				'callback'     => [ $this->callbacks, 'novinhubOptionsGroup' ],
			],
		];
		
		$this->settings->setSettings( $args );
	}
	
	public function setSections() {
		$args = [
			[
				'id'       => 'novinhub_admin_index',
				'title'    => __( 'Settings', 'novinhub' ),
				'callback' => [ $this->callbacks, 'novinhubAdminSection' ],
				'page'     => 'Novinhub_Plugin',
			],
		];
		
		$this->settings->setSections( $args );
	}
	
	public function setFields() {
		$args = [
			[
				'id'       => 'novinhub_token',
				'title'    => get_option( 'novinhub_token' ) === '' ? __( 'Enter your Token Here',
					'novinhub' ) :
					__( 'Your Token is', 'novinhub' ),
				'callback' => [ $this->callbacks, 'novinhubGetToken' ],
				'page'     => 'Novinhub_Plugin',
				'section'  => 'novinhub_admin_index',
				'args'     => [
					'label_for' => 'novinhub_token',
					'class'     => 'example-class',
				],
			],
		];
		
		$this->settings->setFields( $args );
	}
	
	//	public function add_admin_pages() {
	//		add_menu_page( 'Novinhub plugin', 'Novinhub', 'manage_options', 'Novinhub_Plugin',
	//			array( $this, 'admin_index' ), 'https://novinhub.com/assets/img/logo/novinhub-icon-16.png', 110 );
	//	}
	//
	//	public function admin_index() {
	//		require_once PLUGIN_PATH . 'templates/admin.php';
	//	}
}