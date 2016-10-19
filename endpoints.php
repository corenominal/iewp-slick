<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Register endpoints
 */
function iewp_slick_register_endpoints()
{
	register_rest_route( 'iewp_slick', '/get_carousels', array(
        'methods' => 'GET',
        'callback' => 'iewp_slick_rest_get_carousels',
		'show_in_index' => false,
    ));
}
add_action( 'rest_api_init', 'iewp_slick_register_endpoints' );

/**
 * Include endpoints for the above registrations
 */
require_once( plugin_dir_path( __FILE__ ) . 'endpoints/carousels_admin.php' );
