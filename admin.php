<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * WP admin pages for creating creating and managing carousels.
 */
function iewp_slick_admin_options()
{
	// Add top level page
	add_menu_page(
		'IEWP Slick Carousels', // page title
		'Slick Carousels', // menu title
		'edit_posts', // capability
		'iewp_slick_carousels', // slug
		'iewp_slick_carousels_callback', // callback
		'dashicons-format-gallery', // icon - 20x20 png or SVG - for dashicon just ref the icon 'dashicons-sos'
		21 //position
	);

	add_submenu_page(
		'iewp_slick_carousels', // parent slug
		'Slick Carousels', // page title
		'All Carousels', // menu title
		'edit_posts', // capability
		'iewp_slick_carousels', // slug
		'iewp_slick_carousels_callback' // callback function
	);

	add_submenu_page(
		'iewp_slick_carousels', // parent slug
		'Slick Carousels - Edit', // page title
		'Edit', // menu title
		'edit_posts', // capability
		'iewp_slick_carousels_edit', // slug
		'iewp_slick_carousels_edit_callback' // callback function
	);

	add_submenu_page(
		'iewp_slick_carousels', // parent slug
		'Slick Carousels - Add New', // page title
		'Add New', // menu title
		'edit_posts', // capability
		'iewp_slick_carousels_create', // slug
		'iewp_slick_carousels_create_callback' // callback function
	);

}
add_action( 'admin_menu', 'iewp_slick_admin_options' );

/**
 * Include admin views
 */
require_once( plugin_dir_path( __FILE__ ) . 'admin/iewp_slick_carousels.php' );
require_once( plugin_dir_path( __FILE__ ) . 'admin/iewp_slick_carousels_create.php' );
require_once( plugin_dir_path( __FILE__ ) . 'admin/iewp_slick_carousels_edit.php' );

/**
 * Enqueue additional CSS
 */
function iewp_slick_enqueue_css()
{
	wp_register_style( 'iewp_slick_carousels_all_css', plugin_dir_url( __FILE__ ) . 'admin/css/iewp_slick_carousels_all.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_slick_carousels_all_css' );
}
add_action( 'admin_enqueue_scripts', 'iewp_slick_enqueue_css' );
