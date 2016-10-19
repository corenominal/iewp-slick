<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Register endpoints
 */
function iewp_slick_register_endpoints()
{
    // endpoint:/wp-json/iewp_slick/get_carousels
    register_rest_route( 'iewp_slick', '/carousels_admin', array(
        'methods' => 'GET',
        'callback' => 'iewp_slick_carousels_admin',
		'show_in_index' => false,
    ));
}
add_action( 'rest_api_init', 'iewp_slick_register_endpoints' );

/**
 * Include endpoints for the above registrations
 */
require_once( plugin_dir_path( __FILE__ ) . 'endpoints/carousels_admin.php' );
