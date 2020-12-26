<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Api;

class ApiSettings {
	
	public $admin_pages = [];
	public $settings = [];
	public $sections = [];
	public $fields = [];
	
	/**
	 * Add hooks for admin_menu and initialize admin custom fields
	 */
	public function register() {
		if ( ! empty( $this->admin_pages ) ) {
			add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		}
		
		if ( ! empty( $this->settings ) ) {
			add_action( 'admin_init', [ $this, 'registerCustomFields' ] );
		}
	}
	
	/**
	 * @param $pages
	 *
	 *Initialize admin_pages
	 *
	 * @return $this
	 */
	public function addPages( $pages ) {
		$this->admin_pages = $pages;
		
		return $this;
	}
	
	/**
	 * add_menu_page registration
	 */
	public function add_admin_menu() {
		foreach ( $this->admin_pages as $page ) {
			add_menu_page( $page['page_title'], $page['menu_title'],
				$page['capability'],
				$page['menu_slug'], $page['callback'], $page['icon_url'],
				$page['position'] );
		}
	}
	
	/**
	 * @param $settings
	 *
	 * Initialize settings
	 *
	 * @return $this
	 */
	public function setSettings( $settings ) {
		$this->settings = $settings;
		
		return $this;
	}
	
	/**
	 * @param $sections
	 *
	 * Initialize sections
	 *
	 * @return $this
	 */
	public function setSections( $sections ) {
		$this->sections = $sections;
		
		return $this;
	}
	
	/**
	 * @param $fields
	 *
	 * Initialize fields
	 * @return $this
	 */
	public function setFields( $fields ) {
		$this->fields = $fields;
		
		return $this;
	}
	
	/**
	 *Settings, Sections and Fields registration
	 */
	public function registerCustomFields() {
		
		//Register settings
		foreach ( $this->settings as $setting ) {
			register_setting( $setting['option_group'], $setting['option_name'],
				( isset( $setting['callback'] ) ? $setting['callback']
					: '' ) );
		}
		
		//Register sections
		foreach ( $this->sections as $section ) {
			add_settings_section( $section['id'], $section['title'],
				( isset( $section['callback'] ) ? $section['callback']
					: '' ), $section['page'] );
		}
		
		// Add setting fields
		foreach ( $this->fields as $field ) {
			add_settings_field( $field['id'], $field['title'],
				( isset( $field['callback'] ) ? $field['callback']
					: '' ), $field['page'], $field['section'],
				( isset( $field['args'] ) ? $field['args'] : '' ) );
		}
	}
	
}