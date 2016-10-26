<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function iewp_slick_carousels_scripts( $hook )
{

	if( 'toplevel_page_iewp_slick_carousels' != $hook )
	{
		return;
	}

	wp_register_style( 'iewp_slick_carousels_css', plugin_dir_url( __FILE__ ) . 'css/iewp_slick_carousels.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_slick_carousels_css' );

	wp_register_script( 'iewp_slick_carousels_js', plugin_dir_url( __FILE__ ) . 'js/iewp_slick_carousels.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'iewp_slick_carousels_js' );

}
add_action( 'admin_enqueue_scripts', 'iewp_slick_carousels_scripts' );

/**
 * Output HTML
 */
function iewp_slick_carousels_callback()
{
	?>
	<div class="wrap">

		<h1>IEWP Slick Carousels <a href="admin.php?page=iewp_slick_carousels_create" id="add-new-carousel" class="page-title-action">Add New</a></h1>

		<p>Carousels are used for displaying image slideshows within posts and pages.</p>

		<table id="iewp-slick-carousels" class="carousels-list wp-list-table widefat fixed striped posts" data-endpoint="<?php echo site_url('wp-json/iewp_slick/carousels_admin') ?>" data-apikey="<?php echo get_option( 'iewp_slick_apikey', '' ); ?>">
        	<thead>
        		<tr>
        			<th class="manage-column column-name column-primary" scope="col">Name</th>
        			<th class="manage-column column-address" scope="col">Slides</th>
					<th class="manage-column column-address" scope="col">Shortcode</th>
        			<th class="manage-column column-options" scope="col">Options</th>
        		</tr>
        	</thead>

        	<tbody id="the-list">
        		<tr><td colspan="3">Loading carousels ...</td></tr>
        	</tbody>
        </table>

	</div>
	<?php
}
