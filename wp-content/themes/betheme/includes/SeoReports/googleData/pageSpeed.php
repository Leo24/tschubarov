<?php


/**
 * @param $url
 *
 * @return mixed
 */
function get_google_pagespeed_data($url) {

	$apiCreads = getSeoApiCreads();
	$apiKey = $apiCreads['google_api_key'];

	$requestUrl = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=".$url."&strategy=desktop&screenshot=true&key=".$apiKey;

// Use Curl to send off your request.
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	$ch = curl_init($requestUrl);
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);
	curl_close($ch);
//	$content = json_decode($content, true);
	return $content;
}


function AddUpdateGooglePageSpeedDataButton() {
	?>
	<script>
        jQuery(function(){
            jQuery("body.post-type-YOUR-CUSTOM-POST-TYPE .wrap h1").append('' +
                '<a href="index.php?param=your-action" class="page-title-action">Import from ...</a>'
            );
        });
	</script>
	<?php
}
add_action('admin_head', 'AddUpdateGooglePageSpeedDataButton');



add_action("wp_ajax_update_google_page_speed_data", "update_google_page_speed_data");
add_action("wp_ajax_nopriv_update_google_page_speed_data", "update_google_page_speed_data");

function update_google_page_speed_data() {

	if(isset($_POST) && !empty($_POST['postID']) ) {
		$postID              = $_POST['postID'];
		$websiteUrl = get_field('website_url', $postID);
		$googlePageSpeedData = get_google_pagespeed_data(addhttp($websiteUrl));

		// Add a new custom field if the key does not already exist, or updates the value of the custom field with that key otherwise.
		if ( ! add_post_meta( $postID, 'googlePageSpeedDataAfter', $googlePageSpeedData, true ) ) {
			update_post_meta( $postID, 'googlePageSpeedDataAfter', $googlePageSpeedData );
		}

		$check = json_decode($googlePageSpeedData, true);
		if(!isset($check['error'])) {
			wp_send_json($googlePageSpeedData);
		}
		else{
			wp_send_json_error($googlePageSpeedData);
		}
	}
}


add_action( 'post_submitbox_misc_actions', 'custom_update_google_data_button' );

function custom_update_google_data_button(){
	global $post;
	if($post->post_type == 'seo-client-reports'){
		$html  = '<div id="major-publishing-actions" style="overflow:hidden">';
		$html .= '<div id="update-google-page-speed-action">';
		$html .= '<input type="button" accesskey="p" tabindex="1" value="Update Google PageSpeed Data" class="button-primary" id="update-google-page-speed-data" name="publish" data-image-url="'.get_home_url().'/wp-content/themes/betheme/images/shop-loader.gif" data-url="'.get_home_url().'/wp-admin/admin-ajax.php" data-post-id="'.$post->ID.'">';
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}
}

function update_google_pagespeed_data_script( ) {
	wp_enqueue_script( 'update_google_pagespeed_data_script', get_template_directory_uri() . '/js/update_google_pagespeed_data_script.js' );
}
add_action('admin_enqueue_scripts', 'update_google_pagespeed_data_script');


