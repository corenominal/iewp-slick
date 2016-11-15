<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Shortcodes for posts and pages
 * Usage: [iewp-slick-carousel id=1]
 */

global $iewp_slick_js;
$iewp_slick_js = '';

function iewp_slick_test_is_url( $url )
{
    $url = filter_var($url, FILTER_SANITIZE_URL);

    if (!filter_var($url, FILTER_VALIDATE_URL) === false)
    {
        return true;
    }

    return false;
}

function iewp_slick_test_is_img( $str )
{
    $supported_images = array(
        'gif',
        'jpg',
        'jpeg',
        'png'
    );

    $ext = strtolower(pathinfo($str, PATHINFO_EXTENSION));

    if (in_array($ext, $supported_images))
    {
        return true;
    }

    return false;
}

function iewp_slick_carousel( $atts, $content = null )
{
    global $wpdb, $iewp_slick_js;
    $atts = shortcode_atts(
 				array(
 						'id' => -1
 				), $atts
 			);

    $id = $atts['id'];

    $sql = "SELECT * FROM iewp_slick_carousel_images
            WHERE carousel_id = " . $id . " ORDER BY `order`";
    $slides = $wpdb->get_results( $sql, ARRAY_A );

    if( $wpdb->num_rows == 0 )
    {
        return;
    }

    $sql = "SELECT * FROM iewp_slick_carousels
            WHERE id = " . $id;
    $carousel = $wpdb->get_row( $sql, ARRAY_A );

    $options = json_decode( $carousel['options'] );

    $class = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

    $html = '<div class="' . $class . '">';

    foreach ( $slides as $slide )
    {
        $html .= '<div>';

        if( iewp_slick_test_is_url( $slide['link_url'] ) )
        {
            if( iewp_slick_test_is_img( $slide['link_url'] ) )
            {
                $html .= '<a class="iewp-slick-magnific" href="' . $slide['link_url'] . '">';
            }
            else
            {
                $html .= '<a href="' . $slide['link_url'] . '">';
            }
        }

        $html .= '<img src="' . $slide['img_url'] . '" alt="">';

        if( iewp_slick_test_is_url( $slide['link_url'] ) )
            $html .= '</a>';

        if( $slide['img_title'] != '' && $options->titles == 'true' )
            $html .= '<div class="slick-title">' . $slide['img_title'] . '</div>';

        $html .= '</div>';
    }

    $html .= '</div>';

    $iewp_slick_js .= '<script type="text/javascript">';
    $iewp_slick_js .= 'jQuery( document ).ready( function( $ ){';
    $iewp_slick_js .= "$('." . $class . "').slick({";
    $iewp_slick_js .= "dots: " . $options->dots . ","; // works
    $iewp_slick_js .= "arrows: " . $options->arrows . ","; // works
    $iewp_slick_js .= "slidesToShow: 1,"; // works
    $iewp_slick_js .= "slidesToScroll: 1,"; // works
    $iewp_slick_js .= "infinite: " . $options->infinite . ",";
    $iewp_slick_js .= "speed: " . $options->speed . ","; // works
    $iewp_slick_js .= "fade: " . $options->fade . ","; // works
    $iewp_slick_js .= "centerMode: " . $options->centerMode . ","; // works
    $iewp_slick_js .= "adaptiveHeight: true,"; // works
    $iewp_slick_js .= "cssEase: '" . $options->cssEase . "',"; // works
    $iewp_slick_js .= "autoplay: " . $options->autoplay . ","; // works
    $iewp_slick_js .= "autoplaySpeed: " . $options->autoplaySpeed . ","; // works
    $iewp_slick_js .= "});";
    $iewp_slick_js .= "});";
    $iewp_slick_js .= "</script>";

    add_action( 'wp_footer', 'iewp_slick_do_js', 100);

    return $html;



}
add_shortcode( 'iewp-slick-carousel', 'iewp_slick_carousel' );

function iewp_slick_do_js()
{
    global $iewp_slick_js;

    if ( strpos( $iewp_slick_js, 'needle' ) === false)
    {
        $iewp_slick_js .= '<script type="text/javascript">';
        $iewp_slick_js .= 'jQuery( document ).ready( function( $ ){';
        $iewp_slick_js .= "$('.iewp-slick-magnific').magnificPopup({";
        $iewp_slick_js .= "type: 'image',";
        $iewp_slick_js .= "mainClass: 'mfp-with-zoom',";
        $iewp_slick_js .= "zoom: {";
        $iewp_slick_js .= "enabled: true,";
        $iewp_slick_js .= "duration: 300,";
        $iewp_slick_js .= "easing: 'ease-in-out',";
        $iewp_slick_js .= "opener: function(openerElement) {";
        $iewp_slick_js .= "return openerElement.is('img') ? openerElement : openerElement.find('img');";
        $iewp_slick_js .= "}";
        $iewp_slick_js .= "}";
        $iewp_slick_js .= "";
        $iewp_slick_js .= "});";
        $iewp_slick_js .= "console.log('magnific-popup enabled');";
        $iewp_slick_js .= "});";
        $iewp_slick_js .= "</script>";
    }

    echo $iewp_slick_js;
}
