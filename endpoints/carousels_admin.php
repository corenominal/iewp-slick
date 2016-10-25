<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

function iewp_slick_carousels_admin( $request_data )
{

    $apikey = get_option( 'iewp_slick_apikey', '' );

    $data = $request_data->get_params();

    /**
	 * Test for api key action
	 */
    if( $data['apikey'] != $apikey )
    {
        $data['error'] = 'Invalid API key';
        return $data;
    }

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
            global $wpdb;
			$wpdb->delete( 'iewp_slick_carousels', array( 'id' => $data['id'] ), array( '%d' ) );
            $wpdb->delete( 'iewp_slick_carousel_images', array( 'carousel_id' => $data['id'] ), array( '%d' ) );

			unset( $data['action'] );
			unset( $data['apikey'] );
			return $data;
			break;

        case 'create_carousel':
            if( !isset( $data['name'] ) || empty( $data['name'] ) )
            {
                $data['error'] = 'Please provide a name for the carousel';
                return $data;
            }
            global $wpdb;
    		$sql = "SELECT * FROM iewp_slick_carousels
    				WHERE name = '" . $data['name'] . "';";
    		$result = $wpdb->get_results( $sql, ARRAY_A );

    		if( $wpdb->num_rows > 0 )
            {
                $data['error'] = 'Name already in use, try another';
                return $data;
            }
            unset( $data['action'] );
			unset( $data['apikey'] );
            $data['options'] = '';
            $wpdb->insert( 'iewp_slick_carousels', $data, array( '%s', '%s' ) );
            $data['id'] = $wpdb->insert_id;
			return $data;
			break;

        case 'get_carousel':
            global $wpdb;
			$sql = "SELECT * FROM iewp_slick_carousels WHERE id = " . $data['carousel'];
            $data['carousel'] = $wpdb->get_row( $sql, ARRAY_A );
            if( $wpdb->num_rows == 0 )
            {
                $data['error'] = 'Could not find carousel';
                return $data;
            }
			unset( $data['action'] );
			unset( $data['apikey'] );
			return $data;
			break;

        case 'get_slides':
			global $wpdb;
			$sql = "SELECT *
                      FROM iewp_slick_carousel_images
                     WHERE carousel_id = " . $data['carousel'] . "
                     ORDER BY `order` ASC;";
			$data['slides'] = $wpdb->get_results( $sql, ARRAY_A );
			$data['num_rows'] = $wpdb->num_rows;
			unset( $data['action'] );
			unset( $data['apikey'] );
			return $data;
			break;

        case 'delete_slide':
            global $wpdb;
            $wpdb->delete( 'iewp_slick_carousel_images', array( 'id' => $data['id'] ), array( '%d' ) );

			unset( $data['action'] );
			unset( $data['apikey'] );
			return $data;
			break;

        case 'save_carousel':
            global $wpdb;
            $wpdb->delete( 'iewp_slick_carousel_images', array( 'carousel_id' => $data['carousel_id'] ), array( '%d' ) );
            if( trim( $data['name'] ) == '' )
            {
                $data['name'] = 'Untitled ' . $data['carousel_id'];
            }
            $wpdb->update( 'iewp_slick_carousels', // table
                           array( 'name' => $data['name'] ), // data
                           array( 'id' => $data['carousel_id'] ), // where
                           array( '%s' ), // data format
                           array( '%d' ) // where format
                         );
            foreach ($data['carousel'] as $slide)
            {
                $wpdb->insert( 'iewp_slick_carousel_images',
                    array( 'carousel_id' => $slide['carousel_id'],
                           'order' => $slide['order'],
                           'img_url' => $slide['img_url'],
                           'img_alt' => $slide['img_alt'],
                           'img_title' => $slide['img_title'],
                           'link_url' => $slide['link_url']
                    ),
                    array( '%d', '%d', '%s', '%s', '%s', '%s' )
                );
            }

			unset( $data['action'] );
			unset( $data['apikey'] );
			return $data;
			break;

		default:
			$data['error'] = 'Please provide a valid action';
			return $data;
			break;
	}

}
