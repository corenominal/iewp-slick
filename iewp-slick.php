<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Plugin Name: IEWP Slick
 * Plugin URI: https://github.com/corenominal/iewp-slick
 * Description: A WordPress Plugin for Slick - the last carousel you'll ever need
 * Author: Philip Newborough
 * Version: 0.0.1
 * Author URI: https://corenominal.org
 */

/**
 * Plugin activation functions
 */
function iewp_slick_activate()
{
   require_once( plugin_dir_path( __FILE__ ) . 'activation/db.php' );
}
register_activation_hook( __FILE__, 'iewp_slick_activate' );

/**
 * Admin screens
 */
require_once( plugin_dir_path( __FILE__ ) . 'admin.php' );
