<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function iewp_iewp_slick_carousels_edit_scripts( $hook )
{

	if( 'slick-carousels_page_iewp_slick_carousels_edit' != $hook )
	{
		return;
	}

	wp_register_style( 'iewp_slick_carousels_edit_css', plugin_dir_url( __FILE__ ) . 'css/iewp_slick_carousels_edit.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_slick_carousels_edit_css' );

	wp_register_script( 'iewp_slick_carousels_edit_js', plugin_dir_url( __FILE__ ) . 'js/iewp_slick_carousels_edit.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'iewp_slick_carousels_edit_js' );

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'iewp_iewp_slick_carousels_edit_scripts' );

/**
 * Output HTML
 */
function iewp_slick_carousels_edit_callback()
{
	?>
	<div class="wrap">

		<h1>IEWP Slick Carousels &mdash; <span id="action">Add New</span></h1>

		<div class="iewp-slick-carousel">

			<input type="text" class="iewp-slick-title" size="30" value="" id="title" spellcheck="true" autocomplete="off" placeholder="Carousel Name...">

		</div>

	</div>
	<?php
}
