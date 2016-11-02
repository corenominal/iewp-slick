<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function iewp_slick_carousels_create_scripts( $hook )
{

	if( 'slick-carousels_page_iewp_slick_carousels_create' != $hook )
	{
		return;
	}

	wp_register_style( 'iewp_slick_carousels_all_css', plugin_dir_url( __FILE__ ) . 'css/iewp_slick_carousels_all.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_slick_carousels_all_css' );

	wp_register_style( 'iewp_slick_carousels_create_css', plugin_dir_url( __FILE__ ) . 'css/iewp_slick_carousels_create.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_slick_carousels_create_css' );

	wp_register_script( 'iewp_slick_carousels_create_js', plugin_dir_url( __FILE__ ) . 'js/iewp_slick_carousels_create.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'iewp_slick_carousels_create_js' );

}
add_action( 'admin_enqueue_scripts', 'iewp_slick_carousels_create_scripts' );

/**
 * Output HTML
 */
function iewp_slick_carousels_create_callback()
{
	?>
	<div class="wrap">

		<h1>IEWP Slick Carousels &mdash; <span id="action">Add New</span></h1>

		<div id="create-carousel-notify" class="create-carousel-notify"></div>

		<p>Give your carousel a name and click "create".</p>

		<form id="create-carousel-form" class="create-carousel-form" action="index.html" method="post" data-endpoint="<?php echo site_url('wp-json/iewp_slick/carousels_admin') ?>" data-apikey="<?php echo get_option( 'iewp_slick_apikey', '' ); ?>">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">Name</th>
							<td>
								<input id="carousel_name" type="text" class="regular-text" name="carousel_name" value="" placeholder="My carousel ...">
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="Create">
				</p>
		</form>

	</div>
	<?php
}
