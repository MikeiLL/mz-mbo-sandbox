<?php
/*
 * Plugin Name: Mindbody Sandbox Plugin
 * Description: Child plugin for mZoo Mindbody and MBO Access for testing.
 * @package MZMBOSANDBOX
 *
 * @wordpress-plugin
 * Version: 		1.0.6
 * Stable tag: 		1.0.6
 * Author: 			mZoo.org
 * Author URI: 		http://www.mZoo.org/
 * Plugin URI: 		http://www.mzoo.org/
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: 	mbo-sandbox
 * Domain Path: 	/languages
*/
namespace MZoo\MBO_Sandbox;

use MZoo\MBO_Sandbox as NS;
use MZoo\MzMindbody as MZ;
use MZoo\MzMindbody\Core;
use MZoo\MzMboAccess;
use MZoo\MBO_Sandbox\Dependencies\Carbon_Fields\Container;
use MZoo\MBO_Sandbox\Dependencies\Carbon_Fields\Field;

if ( !defined( 'WPINC' ) ) {
    die;
}

// TODO make more eloquent appoach like EDD JILT work!
//	 * Based on http://wptavern.com/how-to-prevent-wordpress-plugins-from-activating-on-sites-with-incompatible-hosting-environments

/**
 * Define Constants
 */

define( __NAMESPACE__ . '\NS', __NAMESPACE__ . '\\' );

define( NS . 'PLUGIN_NAME', 'mbo-sandbox' );

define( NS . 'PLUGIN_VERSION', '1.0.6' );

define( NS . 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );

define( NS . 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );

define( NS . 'PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

define( NS . 'PLUGIN_TEXT_DOMAIN', 'mbo-sandbox' );

define( NS . 'INIT_LEVEL', 30 );

add_action( 'admin_init', __NAMESPACE__ . '\\mbo_sandbox_has_mbo_api_and_access' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\start_the_plugin' );


$wp_sandbox_autoload = NS\PLUGIN_NAME_DIR . '/vendor/autoload.php';
if ( file_exists( $wp_sandbox_autoload ) ) {
	include_once $wp_sandbox_autoload;
}

// Mozart-managed dependencies.
$wp_sandbox_mozart_autoload = NS\PLUGIN_NAME_DIR . '/src/Mozart/autoload.php';
if ( file_exists( $wp_sandbox_mozart_autoload ) ) {
	include_once $wp_sandbox_mozart_autoload;
}




function mbo_sandbox_crb_load() {
		Dependencies\Carbon_Fields\Carbon_Fields::boot();
}

function mbo_sandbox_attach_theme_options() {
    Container\Container::make( 'theme_options', __( 'Sandbox Options' ) )
		->add_fields(
			array(
				Field::make( 'complex', 'sandbox_levels', __( 'Sandbox Level' ) )
				->add_fields(
					'sandbox_level',
					array(
						Field::make( 'text', 'sandbox_name', __( 'Name' ) ),
						Field::make( 'multiselect', 'sandbox_test', __( 'Feeling' ) )
							->add_options( [1 => "amazed", 2 => 'dazzled'] ),
					)
				)
			)
		);
}
/**
 * Insure that parent plugin, is active or deactivate plugin.
 */
function mbo_sandbox_has_mbo_api_and_access() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) && !(is_plugin_active( 'mz-mindbody-api/mz-mindbody.php' ) ) ) {
	// if ( is_admin() && current_user_can( 'activate_plugins' ) && !(is_plugin_active( 'mz-mindbody-api/mz-mindbody.php' ) && is_plugin_active( 'mz-mbo-access/mz-mbo-access.php' )) ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\mbo_sandbox_child_plugin_notice' );

		deactivate_plugins( plugin_basename( __FILE__ ) ); 

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}
}



/**
 * Child Plugin Notice
 */
function mbo_sandbox_child_plugin_notice(){
		?><div class="error"><p><?php echo __("Sorry, but MBO Sandbox plugin requires the parent plugins, MZ Mindbody API and MZ MBO Access, to be installed and active.", NS\PLUGIN_TEXT_DOMAIN); ?></p></div><?php
}

function mbo_sandbox_one( $atts, $content = '' ){
	$options = carbon_get_theme_option( 'sandbox_levels' ); 
    var_dump("OPTIONS:");
    var_dump($options);
    return "Hello Sandbox";
}

function load_our_shortcode(){
	add_shortcode('mbo-sandbox-one', __NAMESPACE__ . '\mbo_sandbox_one');
}

function start_the_plugin(){
	add_action( 'plugins_loaded', __NAMESPACE__ . '\load_our_shortcode', INIT_LEVEL );
	add_action( 'after_setup_theme', __NAMESPACE__ . '\\mbo_sandbox_crb_load' );
	add_action( 'carbon_fields_register_fields', __NAMESPACE__ . '\\mbo_sandbox_attach_theme_options' );
}



?>