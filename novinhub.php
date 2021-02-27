<?php
/**
 * @package Novinhub
 *
 *
 * Plugin Name: Novinhub
 * Plugin URI: https://novinhub.com/plugins
 * Description: Novinhub wordpress plugin for sending wordpress posts to your social medias.
 * Version: 0.0.4
 * Author: Novinhub
 * Author URI: http://novinhub.com
 * Text Domain: novinhub
 * Domain Path: /languages
 * License:
 */

//Translate Plaugin Description...
$des = esc_html(__('Novinhub wordpress plugin for sending wordpress posts to your social medias.', 'novinhub'));




//If this file is accessed directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	echo esc_html(__("Hey, you don't have permission to access this file", 'novinhub'));
	exit;
}

//Require the composer autoload.
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

if ( ! function_exists( 'add_action' ) ) {
	echo esc_html(__("Hey, you don't have permission to access this file", 'novinhub'));
	exit;
}

define( 'NOVINHUBWP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'NOVINHUBWP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'NOVINHUBWP_PLUGIN', plugin_basename( __FILE__ ) );


load_plugin_textdomain( 'novinhub', false,
	dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


add_action( 'plugins_loaded', 'load_plugin_textdomain' );

register_activation_hook( __FILE__, 'activate_novinhub_plugin' );

function activate_novinhub_plugin() {
	Novinhub\Inc\Base\NovinhubWPActivate::novinhubWPActivate();
}

function deactivate_novinhub_plugin() {
	Novinhub\Inc\Base\NovinhubWpDeactivate::novinhubWPDeactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_novinhub_plugin' );

//Initialize the main class of the plugin
if ( class_exists( 'Novinhub\\Inc\\NovinhubWPInit' ) ) {
	Novinhub\Inc\NovinhubWPInit::novinhubWPRegisterServices();
}




