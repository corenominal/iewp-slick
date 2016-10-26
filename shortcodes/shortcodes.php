<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Shortcodes for posts and pages
 * Usage: [iewp-slick-carousel id=1]
 */
function iewp_slick_carousel( $atts, $content = null )
{
    global $wpdb;
    $atts = shortcode_atts(
 				array(
 						'id' => -1
 				), $atts
 			);

    $id = $atts['id'];

    //return $data;
    return 'foo';

}
add_shortcode( 'iewp-slick-carousel', 'iewp_slick_carousel' );
