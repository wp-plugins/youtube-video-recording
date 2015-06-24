<?php
/**
 * @package Video
 * @version 1.0)
 */
/*
Plugin Name: You tube video recorder plugin
Plugin URI: http://wordpress.org/extend/plugins/youtubevideorecorder/
Description: This is video recorder plugin for youtube so recorded video is always saved on youtube channel in the logged in users
Version: 1.0
Author URI: http://nuzax.com/
Author: Mohan
*/

include("function.php");

function ytvr_func( $atts ) {
     extract( shortcode_atts( array(
	      'video' => 'no foo',
	      'baz' => 'default baz'
     ), $atts ) );
     ytvr_video_recording();
	 //return "video = {$video}";
}
add_shortcode( 'videoRecording', 'ytvr_func' );


// Now we set that function up to execute when the admin_notices action is called

function ytvr_admin_actions()
{

    add_options_page('Record Video', 'Record Video', 'manage_options', 'video', 'ytvr_admin');
}

add_action('admin_menu', 'ytvr_admin_actions');

function ytvr_admin()
{
	include('ytvr_admin.php');
}

function ytvr_video_recording() {
	/** These are the lyrics to Hello Dolly */
	$video_options = get_option('video');
	$content =  $video_options['description'].'<div id="widget"></div> <div id="player"></div>';
?>

    <script>
      var tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var widget;
      var player;
      function onYouTubeIframeAPIReady() {
        widget = new YT.UploadWidget('widget', {
		 height: <?php echo esc_html($video_options['height']); ?>,
          width: <?php echo esc_html($video_options['width']); ?>,
          events: {
            'onUploadSuccess': onUploadSuccess,
            'onProcessingComplete': onProcessingComplete
          }
        });
      }

      function onUploadSuccess(event) {
        alert('Video ID ' + event.data.videoId + ' was uploaded and is currently being processed.');
      }

      function onProcessingComplete(event) {
		ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>";
			vid	=	event.data.videoId;
			var data = {
				id: vid,
				admin_email:"<?php echo get_option( 'admin_email' );?>",
				action:'ytvr_notify',
				dataType: "html"
				
			};
			jQuery.post(ajaxurl, data, function(response) {
				alert(response);
			});
			
        player = new YT.Player('player', {
          height: 390,
          width: 640,
          videoId: event.data.videoId,
          events: {}
        });
      }
	</script>
<?php

echo $content;
}


function ytvr_video() {
	echo "<p id='dolly'>$chosen</p>";
}

add_action( 'admin_notices', 'ytvr_video' );
?>
