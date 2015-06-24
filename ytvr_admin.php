<?php

global $wpdb;



//	When content revenge form is posted.

if(isset($_POST['video_hidden']) == TRUE && $_POST['video_hidden'] == 'Y')
{
	$video_options['height'] = sanitize_text_field($_POST['height']);
	$video_options['width'] = sanitize_text_field($_POST['width']);
	$video_options['description'] = sanitize_text_field($_POST['description']);
	$video_options['key'] = sanitize_text_field($_POST['key']);

	//	Update option in table
	update_option('video', $video_options);
}

//	This code runs when the page is loaded

else
{
	//	Set the default values for fields.
	$video_options['height'] = '';
	$video_options['width'] ='';
	$video_options['description'] ='';
	$video_options['key'] = '';
	//	Load options from options table and unserialize them.
	$video_options = get_option('video');
}

?>
			<form name="video_form" method="post" action="<?php echo admin_url(); ?>options-general.php?page=video" >
            	<input type="hidden" name="video_hidden" value="Y" />
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td>Height </td>
						<td><input type="text" name="height" value="<?php echo esc_html($video_options['height']); ?>" /></td>
					  </tr>
					  <tr>
						<td>Width </td>
						<td><input type="text" name="width" value="<?php echo esc_html($video_options['width']); ?>" /></td>
					  </tr>
					  <tr>
						<td>Description </td>
						<td><textarea name="description" rows="10" cols="50"><?php echo esc_html($video_options['description']); ?></textarea></td>
					  </tr>
					  <tr>
						<td>Validation Key </td>
						<td><input type="text" name="key" value="<?php echo esc_html($video_options['key']); ?>" /></td>
					  </tr>
				</table>

				<p class="submit">
					<input type="submit" name="Submit" value="<?php _e('Save', 'Video'); ?>" />
				</p>
			</form>
