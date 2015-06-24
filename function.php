<?php
function ytvr_notify()
{
	$admin_email = sanitize_text_field($_POST['admin_email']);
	$vid = sanitize_text_field($_POST['id']);
	echo $message = "Hi admin,	
	Recorded video  https://www.youtube.com/watch?v=$vid has been recorded.";
	@mail($admin_email,"Recorded Video",$message);
	exit;
}
add_action('wp_ajax_ytvr_notify', 'ytvr_notify');
add_action('wp_ajax_nopriv_ytvr_notify', 'ytvr_notify');

?>