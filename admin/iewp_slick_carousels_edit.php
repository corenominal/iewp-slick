<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function iewp_slick_carousels_edit_scripts( $hook )
{

	if( 'admin_page_iewp_slick_carousels_edit' != $hook )
	{
		return;
	}

	wp_register_style( 'iewp_slick_carousels_edit_css', plugin_dir_url( __FILE__ ) . 'css/iewp_slick_carousels_edit.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_slick_carousels_edit_css' );

	wp_register_script( 'iewp_slick_carousels_edit_js', plugin_dir_url( __FILE__ ) . 'js/iewp_slick_carousels_edit.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'iewp_slick_carousels_edit_js' );

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'iewp_slick_carousels_edit_scripts' );

/**
 * Output HTML
 */
function iewp_slick_carousels_edit_callback()
{
	?>
	<div class="wrap">

		<h1>IEWP Slick Carousels &mdash; <span id="action">Edit</span></h1>

		<label for="iewp-slick-carousel-name">Carousel Name</label>
		<input type="text" class="iewp-slick-input iewp-slick-carousel-name" name="iewp-slick-carousel-name" value="" id="iewp-slick-carousel-name" spellcheck="true" autocomplete="off">

		<label for="iewp-slick-carousel-shortcode">Shortcode:</label>
		<code>[iewp-slick-carousel id=<?php echo $_GET['carousel']; ?>]</code>

		<p>
			<button id="iewp-slick-save-carousel" class="button button-primary button-large" disabled="disabled">Save Carousel</button>
			<button id="iewp-slick-add-slide" class="button button-large">Add Slide</button>
		</p>

		<table id="iewp-slick-carousel-slides" class="slides-list wp-list-table widefat fixed striped posts" data-carousel="<?php echo $_GET['carousel']; ?>" data-endpoint="<?php echo site_url('wp-json/iewp_slick/carousels_admin') ?>" data-apikey="<?php echo get_option( 'iewp_slick_apikey', '' ); ?>">
        	<thead>
        		<tr>
        			<th class="manage-column column-name column-primary" scope="col">Image</th>
        			<th class="manage-column column-address" scope="col">Details</th>
        			<th class="manage-column column-options" scope="col">Options</th>
        		</tr>
        	</thead>

        	<tbody id="the-list">
        		<tr><td colspan="3">Loading slides ...</td></tr>
        	</tbody>
        </table>

	</div>
	<?php
}
