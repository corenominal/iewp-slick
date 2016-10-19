<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

function iewp_slick_carousels_admin( $request_data )
{

    $apikey = get_option( 'iewp_slick_apikey', '' );

    $data = $request_data->get_params();

    return $data;

}
