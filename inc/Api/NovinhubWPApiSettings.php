<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Api;

class NovinhubWPApiSettings {
	
	public $novinhubWP_admin_pages = [];
	public $novinhubWP_settings = [];
	public $novinhubWP_sections = [];
	public $novinhubWP_fields = [];
	
	/**
	 * Add hooks for admin_menu and initialize admin custom fields
	 */
	public function novinhubWPRegister() {
		if ( ! empty( $this->novinhubWP_admin_pages ) ) {
			add_action( 'admin_menu', [ $this, 'novinhubWPAddAdminMenu' ] );
		}
		
		if ( ! empty( $this->novinhubWP_settings ) ) {
			add_action( 'admin_init', [ $this, 'novinhubWPRegisterCustomFields' ] );
		}
	}
	
	/**
	 * @param $pages
	 *
	 *Initialize $novinhubWP_admin_pages
	 *
	 * @return $this
	 */
	public function novinhubWPAddPages( $pages ) {
		$this->novinhubWP_admin_pages = $pages;
		
		return $this;
	}
	
	/**
	 * add_menu_page registration
	 */
	public function novinhubWPAddAdminMenu() {
		foreach ( $this->novinhubWP_admin_pages as $page ) {
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
	public function novinhubWPSetSettings( $settings ) {
		$this->novinhubWP_settings = $settings;
		
		return $this;
	}
	
	/**
	 * @param $sections
	 *
	 * Initialize novinhubWP_sections
	 *
	 * @return $this
	 */
	public function novinhubWPSetSections( $sections ) {
		$this->novinhubWP_sections = $sections;
		
		return $this;
	}
	
	/**
	 * @param $fields
	 *
	 * Initialize novinhubWP_fields
	 * @return $this
	 */
	public function novinhubWPSetFields( $fields ) {
		$this->novinhubWP_fields = $fields;
		
		return $this;
	}
	
	/**
	 *novinhubWP_settings, novinhubWP_sections and novinhubWP_fields registration
	 */
	public function novinhubWPRegisterCustomFields() {
		
		//Register settings
		foreach ( $this->novinhubWP_settings as $setting ) {
			register_setting( $setting['option_group'], $setting['option_name'],
				( isset( $setting['callback'] ) ? $setting['callback']
					: '' ) );
		}
		
		//Register sections
		foreach ( $this->novinhubWP_sections as $section ) {
			add_settings_section( $section['id'], $section['title'],
				( isset( $section['callback'] ) ? $section['callback']
					: '' ), $section['page'] );
		}
		
		// Add setting fields
		foreach ( $this->novinhubWP_fields as $field ) {
			add_settings_field( $field['id'], $field['title'],
				( isset( $field['callback'] ) ? $field['callback']
					: '' ), $field['page'], $field['section'],
				( isset( $field['args'] ) ? $field['args'] : '' ) );
		}
	}
	
}