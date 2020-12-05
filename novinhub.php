<?php
/**
 * @package Novinhub
 */
/*
 * Plugin Name: Novinhub plugin
 * Plugin URI: https://myurl.com/plugin
 * Description: Novinhub wordpress plugin for sending wordpress posts to novinhub api.
 * Version: 1.0.0
 * Author: "Novinhub"
 * Author URI: http://novinhub.com
 * License:
 */

//If this file is accessed directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	echo "Hey, you don't have permission to access this file";
	exit;
}

//Require the composer autoload.
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

if ( ! function_exists( 'add_action' ) ) {
	echo "Hey, you don't have permission to access this file";
	exit;
}

define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN', plugin_basename( __FILE__ ) );


load_plugin_textdomain( 'novinhub', false,
	dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


add_action( 'plugins_loaded', 'load_plugin_textdomain' );

register_activation_hook( __FILE__, 'activate_novinhub_plugin' );

function activate_novinhub_plugin() {
	Inc\Base\Activate::activate();
}

function deactivate_novinhub_plugin() {
	Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_novinhub_plugin' );

//Initialize the main class of the plugin
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}




