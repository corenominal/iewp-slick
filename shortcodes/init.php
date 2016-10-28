<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Conditionally enqueue scripts and styles if shortcode is present
 */
function iewp_slick_conditional_enqueue( $posts )
{
	if ( empty($posts) || is_admin() )
		return $posts;

	$found = false;

    foreach ($posts as $post)
    {
		if ( has_shortcode($post->post_content, 'iewp-slick-carousel') )
        {
			$found = true;
			break;
		}
	}

	if ($found)
    {
        wp_enqueue_script( 'iewp_slick_vendor_js', plugins_url() . '/iewp-slick/vendor/slick/slick.min.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'iewp_slick_vendor_css', plugins_url() . '/iewp-slick/vendor/slick/slick.css', array(), "1.0", "all" );
        wp_enqueue_style( 'iewp_slick_vendor_theme_css', plugins_url() . '/iewp-slick/vendor/slick/slick-theme.css', array(), "1.0", "all" );

		wp_enqueue_script( 'iewp_slick_magnific_popup_js', plugins_url() . '/iewp-slick/vendor/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'iewp_slick_magnific_popup_css', plugins_url() . '/iewp-slick/vendor/magnific-popup/magnific-popup.css', array(), "1.0", "all" );
	}
	return $posts;
}
add_action('the_posts', 'iewp_slick_conditional_enqueue' );
