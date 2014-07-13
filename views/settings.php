<div class="wrap">
	<h1>WP Duel Settings</h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'wp-duel' ); ?>
		<table class="form-table">
			<tr valign="top">
			<th scope="row">Contender Post Type</th>
			<td>
				<select name="wpduel_post_type" id="wpduel_post_type">
					<?php echo $this->postTypes(); ?>
				</select>
			</td>
			</tr>
			<tr>
				<th scope="row">
					Output CSS?
				</th>
				<td>
					<label for="css_yes">
						<input type="radio" value="yes" name="wpduel_output_styles" id="css_yes" <?php if ( get_option('wpduel_output_styles') == 'yes' ) echo 'checked'; ?>> Yes
					</label>
					<br />
					<label for="css_no">
						<input type="radio" value="no" name="wpduel_output_styles" id="css_no" <?php if ( get_option('wpduel_output_styles') == 'no' ) echo 'checked'; ?>> No
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					Output JS?
				</th>
				<td>
					<p><em>If "no", radio buttons will be displayed in place of switch.</em></p>
					<label for="js_yes">
						<input type="radio" value="yes" name="wpduel_output_js" id="js_yes" <?php if ( get_option('wpduel_output_js') == 'yes' ) echo 'checked'; ?>> Yes
					</label>
					<br />
					<label for="js_no">
						<input type="radio" value="no" name="wpduel_output_js" id="js_no" <?php if ( get_option('wpduel_output_js') == 'no' ) echo 'checked'; ?>> No
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					Highlight Color
				</th>
				<td>
					<input name="wpduel_highlight_color" type="text" id="wpduel_highlight_color" class="color-picker" value="<?php echo get_option('wpduel_highlight_color'); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					Display Results using
				</th>
				<td>
					<label for="text">
						<input type="radio" value="text" name="wpduel_results_view" id="text" <?php if ( get_option('wpduel_results_view') == 'text' ) echo 'checked'; ?>> Text
					</label><br />
					<label for="chart">
						<input type="radio" value="chart" name="wpduel_results_view" id="chart" <?php if ( get_option('wpduel_results_view') == 'chart' ) echo 'checked'; ?>> Chart
					</label>
				</td>
			</tr>
			<tr id="chart_one">
				<th scope="row">
					Chart Color One
				</th>
				<td>
					<input name="wpduel_chart_color_one" type="text" id="wpduel_chart_color_one" class="color-picker" value="<?php echo get_option('wpduel_chart_color_one'); ?>" />
				</td>
			</tr>
			<tr id="chart_two">
				<th scope="row">
					Chart Color Two
				</th>
				<td>
					<input name="wpduel_chart_color_two" type="text" id="wpduel_chart_color_two" class="color-picker" value="<?php echo get_option('wpduel_chart_color_two'); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					Limit votes using
				</th>
				<td>
					<label for="ip">
						<input type="radio" value="ip" name="wpduel_track_votes" id="ip" <?php if ( get_option('wpduel_track_votes') == 'ip' ) echo 'checked'; ?>> IP
					</label><br />
					<label for="cookie">
						<input type="radio" value="cookie" name="wpduel_track_votes" id="cookie" <?php if ( get_option('wpduel_track_votes') == 'cookie' ) echo 'checked'; ?>> Cookies
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row">
					Display form on Post Type Singular Views
				</th>
				<td>
					<label for="single_view_yes">
						<input type="radio" value="yes" name="wpduel_single_view" id="single_view_yes" <?php if ( get_option('wpduel_single_view') == 'yes' ) echo 'checked'; ?>> Yes
					</label><br />
					<label for="single_view_no">
						<input type="radio" value="no" name="wpduel_single_view" id="single_view_no" <?php if ( get_option('wpduel_single_view') == 'no' ) echo 'checked'; ?>> No
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					Show Thumbnail?
				</th>
				<td>
					<label for="show_image_yes">
						<input type="radio" value="yes" name="wpduel_show_image" id="show_image_yes" <?php if ( get_option('wpduel_show_image') !== 'no' ) echo 'checked'; ?>> Yes
					</label>
					<br />
					<label for="show_image_no">
						<input type="radio" value="no" name="wpduel_show_image" id="show_image_no" <?php if ( get_option('wpduel_show_image') == 'no' ) echo 'checked'; ?>> No
					</label>
				</td>
			</tr>
			<tr valign="top" id="image_size">
				<th scope="row">Image size</th>
				<td>
					<p>Use Custom Image Size?</p>
					<label for="use_custom_no">
						<input type="radio" value="no" name="wpduel_custom_image_size" id="use_custom_no" <?php if ( get_option('wpduel_custom_image_size') == 'no' ) echo 'checked'; ?>> No
					</label>
					<br />
					<label for="use_custom_yes">
						<input type="radio" value="yes" name="wpduel_custom_image_size" id="use_custom_yes" <?php if ( get_option('wpduel_custom_image_size') !== 'no' ) echo 'checked'; ?>> Yes
					</label>
				</td>
			</tr>
			<tr valign="top" id="wp_image_sizes">
				<th scope="row">Available Image Sizes</th>
				<td>
					<label>Image size</label><br />
					<select name="wpduel_wp_image_size">
						<?php
						$sizes = get_intermediate_image_sizes();
						foreach ( $sizes as $size )
						{
							if ( $size !== 'wpduel' ){
								$out = '<option value="' . $size . '"';
								if ( get_option('wpduel_wp_image_size') == $size ) $out .= ' selected';
								$out .= '>' . $size . '</option>';
							}
							echo $out;
						}
						?>
					</select>
				</td>
			</tr>
			<tr valign="top" id="custom_size">
				<th scope="row">Custom Image Size</th>
				<td>
					<div class="error" style="display:none;" id="width_height_error"></div>
					<label for="wpduel_image_width">Width</label>
					<input type="text" name="wpduel_image_width" id="wpduel_image_width" value="<?php echo get_option('wpduel_image_width'); ?>" size="4"> px
					<br />
					<label for="wpduel_image_height">Height</label>
					<input type="text" name="wpduel_image_height" id="wpduel_image_height" value="<?php echo get_option('wpduel_image_height'); ?>" size="4"> px
					<p><em>Note: Images already posted will need to be regenerated for new size to be available.</em></p>
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>

<script>
/**
* Validate custom sizes
*/
function validateSizes()
{
	jQuery('#width_height_error').hide();

	if ( jQuery('input[name="wpduel_custom_image_size"]:checked').val() === 'yes' ){
		
		var width = jQuery('#wpduel_image_width').val();
		var height = jQuery('#wpduel_image_height').val();

		if ( width === '' || height === '' ){
			jQuery('#width_height_error').html('<p>Please provide a width & height.</p>').show();
			return;
		}

		if ( !jQuery.isNumeric(Math.floor(width)) ){
			jQuery('#width_height_error').html('<p>Width should be a whole number value.</p>').show();
			return;
		}

		if ( !jQuery.isNumeric(Math.floor(height)) ){
			jQuery('#width_height_error').html('<p>Height should be a whole number value.</p>').show();
			return;
		}

		jQuery('#submit').unbind('click').click();
		
	} else {
		jQuery('#submit').unbind('click').click();
	}
}

/**
* Will Images be shown?
*/
function show_hide_image()
{
	var shown = jQuery('input[name="wpduel_show_image"]:checked').val();

	if ( shown === 'no' ){
		jQuery('#image_size, #wp_image_sizes, #custom_size').hide();
	} else {
		jQuery('#image_size, #wp_image_sizes, #custom_size').show();
	}
}

/**
* Built in or custom image?
*/
function toggle_size_type()
{
	var use_custom = jQuery('input[name="wpduel_custom_image_size"]:checked').val();
	if ( use_custom === 'no' ){
		jQuery('#custom_size').hide();
		jQuery('#wp_image_sizes').show();
	} else {
		jQuery('#custom_size').show();
		jQuery('#wp_image_sizes').hide();
	}
}

/**
* Toggle the chart color fields
*/
function toggle_chart_colors()
{
	var show = jQuery('input[name="wpduel_results_view"]:checked').val();
	if ( show !== 'chart' ){
		jQuery('#chart_one, #chart_two').hide();
	} else {
		jQuery('#chart_one, #chart_two').show();
	}
}


jQuery('#submit').on('click', function(e){
	e.preventDefault();
	validateSizes();
});

jQuery(document).ready(function(){
	show_hide_image();
	toggle_size_type();
	toggle_chart_colors();
	jQuery('.color-picker').wpColorPicker();
});

jQuery('input[name="wpduel_show_image"]').on('change', function(){
	show_hide_image();
	toggle_size_type();
});

jQuery('input[name="wpduel_custom_image_size"]').on('change', function(){
	toggle_size_type();
});

jQuery('input[name="wpduel_results_view"]').on('change', function(){
	toggle_chart_colors();
});
</script>
