<?php
if ( ! defined( 'WPINC' ) ) { die('Direct access prohibited!'); }

/**
 * Enqueue additional JavaScript and CSS
 */
function iewp_slick_carousels_edit_scripts( $hook )
{

	if( 'slick-carousels_page_iewp_slick_carousels_edit' != $hook )
	{
		return;
	}

	wp_register_style( 'iewp_slick_carousels_all_css', plugin_dir_url( __FILE__ ) . 'css/iewp_slick_carousels_all.css', array(), '0.0.1', 'all' );
	wp_enqueue_style( 'iewp_slick_carousels_all_css' );

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
			<button id="iewp-slick-options" class="button button-large">Toggle Options</button>
			<button id="iewp-slick-add-slide" class="button button-large">Add Slide</button>
			<button id="iewp-slick-save-carousel" class="button button-primary button-large" disabled="disabled">Save Carousel</button>
		</p>

		<div id="iewp-slick-options-panel" class="iewp-slick-options-panel">
			<h3>Carousel Options</h3>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">Show titles</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-titles">
								<option value="true">true</option>
								<option value="false">false</option>
							</select>
							<p class="description">Enable titles within slides.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Show arrows</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-arrows">
								<option value="true">true</option>
								<option value="false">false</option>
							</select>
							<p class="description">Enable next/previous arrow buttons.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Show dots</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-dots">
								<option value="true">true</option>
								<option value="false">false</option>
							</select>
							<p class="description">Enable dots under carousel for selecting slides.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Animation speed</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-speed">
								<?php
								$speed = 200;
								while ( $speed <= 750 )
								{
									echo '<option value="' . $speed . '">' . $speed . '</option>';
									$speed = $speed + 50;
								}
								?>
							</select>
							<p class="description">Slide switching animation speed in milliseconds.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Fade animation</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-fade">
								<option value="true">true</option>
								<option value="false">false</option>
							</select>
							<p class="description">Crossfade bewteen slides, instead of sliding.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Centre mode</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-centerMode">
								<option value="true">true</option>
								<option value="false">false</option>
							</select>
							<p class="description">Enables centered view with partial prev/next slides.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">CSS Ease</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-cssEase">
								<option value="linear">linear</option>
								<option value="ease">ease</option>
								<option value="ease-in-out">ease-in-out</option>
								<option value="ease-in">ease-in</option>
								<option value="ease-out">ease-out</option>
								<option value="cubic-bezier(.87,-.41,.19,1.44)">bounce</option>
							</select>
							<p class="description">CSS3 animation easing.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Autoplay</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-autoplay">
								<option value="true">true</option>
								<option value="false">false</option>
							</select>
							<p class="description">Enables aotoplay.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Autoplay Speed</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-autoplaySpeed">
								<?php
								$speed = 1000;
								while ( $speed <= 10000 )
								{
									echo '<option value="' . $speed . '">' . $speed . '</option>';
									$speed = $speed + 500;
								}
								?>
							</select>
							<p class="description">Autoplay speed in milliseconds.</p>
						</td>
					</tr>
					<tr>
						<th scope="row">Infinite</th>
						<td>
							<select class="iewp-slick-option iewp-slick-input" id="iewp-slick-option-infinite">
								<option value="true">true</option>
								<option value="false">false</option>
							</select>
							<p class="description">Infinite loop sliding.</p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

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
