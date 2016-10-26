<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }
/**
 * Add custom metabox for selecting carousels
 */
function iewp_slick_add_metabox_shortcodes()
{
    # Only show if carousels exist
    global $wpdb;
    $sql = "SELECT * FROM `iewp_slick_carousels`";
    $data = $wpdb->get_results( $sql, ARRAY_A );
    if( $wpdb->num_rows > 0 ):

        add_meta_box(
    		'iewp_slick_metabox_shortcodes',
    		'IEWP Slick Carousel Shortcodes',
    		'iewp_slick_metabox_shortcode_callback',
    		null,
    		'normal',
    		'default'
    		);

    endif;
}
add_action( 'add_meta_boxes', 'iewp_slick_add_metabox_shortcodes' );

/**
 * The metabox callback
 */
function iewp_slick_metabox_shortcode_callback( $post )
{
    # Generate a list of all carousels for quick selection
    global $wpdb;
    $sql = "SELECT iewp_slick_carousels.id, name, COUNT(carousel_id) AS images
              FROM iewp_slick_carousels LEFT JOIN iewp_slick_carousel_images
                ON iewp_slick_carousels.id = iewp_slick_carousel_images.carousel_id
             GROUP BY iewp_slick_carousels.id
             ORDER BY iewp_slick_carousels.id DESC;";
    $carousels = $wpdb->get_results( $sql, ARRAY_A );
    ?>

	<div>
		<div class="meta-row">
            <div id="iewp-slick-carousel-select" class="iewp-slick-carousel-select">
                Select snippet:<br>
                <select>
                <?php
                    $id = false;
                    foreach ( $carousels as $carousel )
                    {
                        if( !$id )
                        {
                            $id = $carousel['id'];
                        }
                        echo '<option data-title="' . $carousel['name'] . '" value="' . $carousel['id'] . '">' . $carousel['name'] . ' [slides: ' . $carousel['images'] . ']</option>';
                    }
                ?>
                </select>
            </div>
            <div>
                <br>
                <strong>Shortcode:</strong><br>
                [iewp-slick-carousel id=<span id="iewp-slick-shortcode-example"><?php echo $id; ?></span>]
            </div>
		</div>
	</div>

	<?php
}

/**
 * Enqueue additional JavaScript and CSS
 */
function iewp_slick_metabox_enqueue_scripts( $hook )
{
    if( 'post.php' != $hook )
	{
		return;
	}
	wp_register_script( 'iewp_slick_metabox_js', plugin_dir_url( __FILE__ ) . 'js/metabox.js', array('jquery'), '0.0.1', true );
	wp_enqueue_script( 'iewp_slick_metabox_js' );
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'iewp_slick_metabox_enqueue_scripts' );
