<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

function iewp_slick_carousels_admin( $request_data )
{

    $apikey = get_option( 'iewp_slick_apikey', '' );

    $data = $request_data->get_params();

    /**
	 * Test for action
	 */
	if( !isset( $data['action'] ) )
 	{
 		$data['error'] = 'Please provide an action';
 		return $data;
 	}

    switch ( $data['action'] )
	{
		case 'list_carousels':
			global $wpdb;
			$sql = "SELECT iewp_slick_carousels.id, name, COUNT(carousel_id) AS images
                      FROM iewp_slick_carousels LEFT JOIN iewp_slick_carousel_images
                        ON iewp_slick_carousels.id = iewp_slick_carousel_images.carousel_id
                     GROUP BY iewp_slick_carousels.id
                     ORDER BY iewp_slick_carousels.id DESC;";
			$data['carousels'] = $wpdb->get_results( $sql, ARRAY_A );
			$data['num_rows'] = $wpdb->num_rows;
			unset( $data['action'] );
			unset( $data['apikey'] );
			return $data;
			break;

        case 'delete_carousel':
            if( $data['apikey'] != $apikey )
            {
                $data['error'] = 'Invalid API key';
                return $data;
            }
            global $wpdb;
			$wpdb->delete( 'iewp_slick_carousels', array( 'id' => $data['id'] ), array( '%d' ) );
            $wpdb->delete( 'iewp_slick_carousel_images', array( 'carousel_id' => $data['id'] ), array( '%d' ) );

			unset( $data['action'] );
			unset( $data['apikey'] );
			return $data;
			break;

		default:
			$data['error'] = 'Please provide an action';
			return $data;
			break;
	}

}
