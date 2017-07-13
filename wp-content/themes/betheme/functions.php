<?php
/**
 * Theme Functions
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

require_once( __DIR__ . '/includes/SeoReports/SERankins/SERankins.php' );
require_once( __DIR__ . '/includes/SeoReports/googleData/pageSpeed.php' );
require_once( __DIR__ . '/includes/SeoReports/CF7_forms/forms.php' );

define( 'THEME_DIR', get_template_directory() );
define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'betheme' );
define( 'THEME_VERSION', '9.6' );

define( 'LIBS_DIR', THEME_DIR. '/functions' );
define( 'LIBS_URI', THEME_URI. '/functions' );
define( 'LANG_DIR', THEME_DIR. '/languages' );

add_filter( 'widget_text', 'do_shortcode' );
add_filter('xmlrpc_enabled', '__return_false');


/* ---------------------------------------------------------------------------
 * White Label
 * IMPORTANT: We recommend the use of Child Theme to change this
 * --------------------------------------------------------------------------- */
defined( 'WHITE_LABEL' ) or define( 'WHITE_LABEL', false );


/* ---------------------------------------------------------------------------
 * Loads Theme Textdomain
 * --------------------------------------------------------------------------- */
load_theme_textdomain( 'betheme',  LANG_DIR );
load_theme_textdomain( 'mfn-opts', LANG_DIR );


/* ---------------------------------------------------------------------------
 * Loads the Options Panel
 * --------------------------------------------------------------------------- */
if( ! function_exists( 'mfn_admin_scripts' ) )
{
	function mfn_admin_scripts() {
		wp_enqueue_script( 'jquery-ui-sortable' );
	}
}
add_action( 'wp_enqueue_scripts', 'mfn_admin_scripts' );
add_action( 'admin_enqueue_scripts', 'mfn_admin_scripts' );

require( THEME_DIR .'/muffin-options/theme-options.php' );

$theme_disable = mfn_opts_get( 'theme-disable' );


/* ---------------------------------------------------------------------------
 * Loads Theme Functions
 * --------------------------------------------------------------------------- */

// Functions --------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-functions.php' );

// Header -----------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-head.php' );

// Menu -------------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-menu.php' );
if( ! isset( $theme_disable['mega-menu'] ) ){
	require_once( LIBS_DIR .'/theme-mega-menu.php' );
}

// Meta box ---------------------------------------------------------------------
require_once( LIBS_DIR .'/meta-functions.php' );

// Custom post types ------------------------------------------------------------
$post_types_disable = mfn_opts_get( 'post-type-disable' );

if( ! isset( $post_types_disable['client'] ) ){
	require_once( LIBS_DIR .'/meta-client.php' );
}
if( ! isset( $post_types_disable['offer'] ) ){
	require_once( LIBS_DIR .'/meta-offer.php' );
}
if( ! isset( $post_types_disable['portfolio'] ) ){
	require_once( LIBS_DIR .'/meta-portfolio.php' );
}
if( ! isset( $post_types_disable['slide'] ) ){
	require_once( LIBS_DIR .'/meta-slide.php' );
}
if( ! isset( $post_types_disable['testimonial'] ) ){
	require_once( LIBS_DIR .'/meta-testimonial.php' );
}

if( ! isset( $post_types_disable['layout'] ) ){
	require_once( LIBS_DIR .'/meta-layout.php' );
}
if( ! isset( $post_types_disable['template'] ) ){
	require_once( LIBS_DIR .'/meta-template.php' );
}

require_once( LIBS_DIR .'/meta-page.php' );
require_once( LIBS_DIR .'/meta-post.php' );

// Content ----------------------------------------------------------------------
require_once( THEME_DIR .'/includes/content-post.php' );
require_once( THEME_DIR .'/includes/content-portfolio.php' );

// Shortcodes -------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-shortcodes.php' );

// Hooks ------------------------------------------------------------------------
require_once( LIBS_DIR .'/theme-hooks.php' );

// Widgets ----------------------------------------------------------------------
require_once( LIBS_DIR .'/widget-functions.php' );

require_once( LIBS_DIR .'/widget-flickr.php' );
require_once( LIBS_DIR .'/widget-login.php' );
require_once( LIBS_DIR .'/widget-menu.php' );
require_once( LIBS_DIR .'/widget-recent-comments.php' );
require_once( LIBS_DIR .'/widget-recent-posts.php' );
require_once( LIBS_DIR .'/widget-tag-cloud.php' );

// TinyMCE ----------------------------------------------------------------------
require_once( LIBS_DIR .'/tinymce/tinymce.php' );

// Plugins ---------------------------------------------------------------------- 
if( ! isset( $theme_disable['demo-data'] ) ){
	require_once( LIBS_DIR .'/importer/import.php' );
}

require_once( LIBS_DIR .'/class-love.php' );
require_once( LIBS_DIR .'/class-tgm-plugin-activation.php' );

require_once( LIBS_DIR .'/plugins/visual-composer.php' );

// WooCommerce specified functions
if( function_exists( 'is_woocommerce' ) ){
	require_once( LIBS_DIR .'/theme-woocommerce.php' );
}

// Hide activation and update specific parts ------------------------------------

// Slider Revolution
if( ! mfn_opts_get( 'plugin-rev' ) ){
	if( function_exists( 'set_revslider_as_theme' ) ){
		set_revslider_as_theme();
	}
}

// LayerSlider
if( ! mfn_opts_get( 'plugin-layer' ) ){
	add_action('layerslider_ready', 'mfn_layerslider_overrides');
	function mfn_layerslider_overrides() {
		// Disable auto-updates
		$GLOBALS['lsAutoUpdateBox'] = false;
	}
}

// Visual Composer 
if( ! mfn_opts_get( 'plugin-visual' ) ){
	add_action( 'vc_before_init', 'mfn_vcSetAsTheme' );
	function mfn_vcSetAsTheme() {
		vc_set_as_theme();
	}
}

add_action( 'wp_ajax_my_check_order', 'check_order_callback' );
add_action( 'wp_ajax_nopriv_my_check_order', 'check_order_callback' );
function check_order_callback() {
	global $wpdb;

	//FO1AB11E6058FG

	$q = "SELECT * FROM wp_postmeta WHERE meta_key='order_number' and meta_value = '".$_POST["order_id"]."'";
	$results = $wpdb->get_results( $q, OBJECT );

	echo !empty($results)?1:0;

	wp_die();
}

add_filter('acf/validate_value/name=order_number', 'my_acf_validate_value', 10, 4);

function my_acf_validate_value( $valid, $value, $field, $input ){
	global $wpdb;
	// bail early if value is already invalid
	if( !$valid ) {
		return $valid;
	}

	$ref = $_SERVER["HTTP_REFERER"];

	$q = "SELECT * FROM wp_postmeta WHERE meta_key='order_number' and meta_value = '".$value."'";
	$results = $wpdb->get_results( $q, OBJECT );

	if (!empty($results) && !preg_match('/fiverr_order.*?edit\=edit/', $ref) ) {
		$valid = 'Order with such ID is already exist in Database. Please choose another ID. ';
	} else if (!preg_match('/^[a-z0-9]+$/i', $value)) {
		$valid = 'Please use only alphanumeric chars here.';
	}

	// return
	return $valid;
}

function rankgallery_func( ){
	ob_start();

	echo '
	<div id="centerblock" style="position: relative">
	<img id="features_rating_image" src="'.get_template_directory_uri().'/images/features.png" style="position: absolute; top: 108px; left: 48.5%; z-index: 100; cursor: pointer;"> 
    <div class="top_block">
    	
        <div class="r">
            <div class="text_block">
                <h1>Proven to work</h1>
                <p class="p">144 000+ sales, because it works!.</p>
                <div class="btns">
                    <a href="https://www.fiverr.com/conversations/youngceaser" class="btn btn_white">Get Free Analysis</a>
                </div>
                <p class="bottomnote">See some client\'s Rankings, 1 month after our work.</p>
            </div>
            <div>';

	nggShowGallery( 15 );

	echo '</div>
        </div>
    </div>
    </div>';

	$cont = ob_get_clean();
	return $cont;
}
add_shortcode( 'rankgallery', 'rankgallery_func' );

function seo_comp($str) {
	return str_replace(array(' ', '&'), '_', $str);
}

function ys_prepare_output($str) {
	$str = str_replace("\n", "<br/>", $str);

	return formatUrlsInText($str);
}

function formatUrlsInText($text){
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	preg_match_all($reg_exUrl, $text, $matches);
	$usedPatterns = array();
	foreach($matches[0] as $pattern){
		if(!array_key_exists($pattern, $usedPatterns)){
			$usedPatterns[$pattern]=true;
			$text = str_replace  ($pattern, "<a href='{$pattern}' rel='nofollow' target='_blank'>{$pattern}</a>", $text);
		}
	}
	return $text;
}

function ys_add_footer_styles() {
	global $post;
	if ($post->post_name=='comparison-table')
		wp_enqueue_style( 'comparison-style', get_template_directory_uri() . '/css/comparison.css' );
};
add_action( 'get_footer', 'ys_add_footer_styles' );

$result = add_role(
	'700words',
	__( '700 Words & Write a Call to Action' ),
	array(
		'read'         => true,  // true allows this capability
		'edit_posts'   => true,
		'delete_posts' => false, // Use false to explicitly deny
	)
);

$result = add_role(
	'specifiedgigs',
	__( 'Specified GIGs permissions' ),
	array(
		'read'         => true,  // true allows this capability
		'edit_posts'   => true,
		'delete_posts' => false, // Use false to explicitly deny
	)
);

function yc_user_gigs_options($user) {
	?>
    <table class="form-table">
        <tr>
            <th>
                <label for="tc_location"><?php _e('GIGs'); ?></label>
            </th>
            <td>

				<?php $forms = get_field('forms','options'); ?>

				<?php

				$allow_gigs = get_the_author_meta( 'allow_gigs', $user->ID );
				foreach ($forms as $form) {


					$checked = (!empty($allow_gigs) && in_array($form['form_name'], $allow_gigs))?' checked=checked ': '';
					echo '<label><input type="checkbox" name="allow_gigs[]" value="'.$form['form_name'].'" '.$checked.'>'.$form['title'].'</label><br>';

				}

				?>

            </td>
        </tr>
    </table>
	<?php
}
add_action('show_user_profile', 'yc_user_gigs_options');
add_action('edit_user_profile', 'yc_user_gigs_options');

add_action('edit_user_profile_update', 'update_extra_profile_fields');

function update_extra_profile_fields($user_id) {
	if ( current_user_can('edit_user',$user_id) ) {
		update_user_meta($user_id, 'allow_gigs', $_POST["allow_gigs"]);
	}
}

add_filter( 'wp_unique_post_slug', 'custom_unique_post_slug', 10, 4 );
function custom_unique_post_slug( $slug, $post_ID, $post_status, $post_type ) {
	if ( 'seo-client-reports' == $post_type ) {
		$post = get_post($post_ID);
		if ( empty($post->post_name)
//             || $slug != $post->post_name
		) {
			$slug = md5( time() );
		}
	}
	return $slug;
}


// Show posts of 'seo-client-reports' post type on home page
function search_filter( $query ) {
	if ( !is_admin() && $query->is_main_query() ) {
		if ( $query->is_search ) {
			$query->set( 'post_type', array('seo-client-reports') );
		}
	}
}

add_action( 'pre_get_posts','search_filter' );

/**
 * @return array
 */
function get_fiverr_banners(){
	$args = array(
		'post_type' => 'fiverr-banners',
	);
	$fiverrBannerInfo = get_posts($args);
	return get_fields($fiverrBannerInfo[0]->ID);
}

/*
    Prevent the email sending step for specific form
*/
add_action("wpcf7_before_send_mail", "wpcf7_create_seo_report");
function wpcf7_create_seo_report() {
	// get the contact form object
	$wpcf = WPCF7_ContactForm::get_current();

	if(isset($_POST) && !empty($_POST)){

		$formData = $_POST;
		foreach($formData as &$value){
			$value = validate_input($value);
		}

		if(isset($_POST['param']) && !empty($_POST['param']) && ($_POST['param'] == 'update_user_profile_details')){
			if(isset($_POST['postURL']) && !empty($_POST['postURL'])){
				$postID = url_to_postid($_POST['postURL']);
				update_form_fields($formData, $postID);
				if ($wpcf) {$wpcf->skip_mail = true;}
			}
		}else {
			$newPost = array(
				'ID'          => 0,
				'post_title'  => $formData['website_url'],
				'post_status' => 'publish',
				'post_type'   => 'seo-client-reports',
			);

			$postID = wp_insert_post( $newPost );

			$googlePageSpeedData = get_google_pagespeed_data( addhttp( $formData['website_url'] ) );

			$check = json_decode( $googlePageSpeedData, true );
			if ( ! isset( $check['error'] ) ) {
				add_post_meta( $postID, 'googlePageSpeedDataBefore', $googlePageSpeedData, true );
			}

			$serankingData = addSiteToSERanking( addhttp( $formData['website_url'] ) );
			update_field( 'se_rankins_site_id', $serankingData['siteid'], $postID );
			addSiteKeywordsToSERanking( $serankingData['siteid'], textareaToArray( $formData['keywords_type'] ) );

			update_form_fields($formData, $postID);

		}

	}
	return $wpcf;
}

function update_form_fields($formData, $postID){
	$customFieldsList = array(
		'fiverr_username',
		'bought_package',
		'website_url',
		'keywords_type',
		'social_logins',
		'website_admin_logins',
		'google_pages_access',
		'client_name',
		'client_email',
		'client_address',
		'client_phone',
		'client_zip_code',
		'client_google_analytics',
		'additional_info',
	);

	foreach($customFieldsList as $value) {
		update_field($value, $formData[$value], $postID);
	}
}


/**
 * @param $data
 *
 * @return string
 */
function validate_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}



/**
 * @return array
 */
function getSeoApiCreads(){
	$seo_api_posts = get_posts(
		array(
			'posts_per_page' => -1,
			'post_type' => 'seoapicreadentials',
		)
	);

	return get_fields($seo_api_posts[0]->ID);
}



/**
 * Get MOZ API DATA
 */

function get_moz_api_data($accessID, $secretKey, $objectURL, $cols){
// Set your expires times for several minutes into the future.
// An expires time excessively far in the future will not be honored by the Mozscape API.
	$expires = time() + 300;

// Put each parameter on a new line.
	$stringToSign = $accessID."\n".$expires;

// Get the "raw" or binary output of the hmac hash.
	$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);

// Base64-encode it and then url-encode that.
	$urlSafeSignature = urlencode(base64_encode($binarySignature));

// Put it all together and you get your request URL.
// This example uses the Mozscape URL Metrics API.
	$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;

// Use Curl to send off your request.
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	$ch = curl_init($requestUrl);
	curl_setopt_array($ch, $options);
	$content = curl_exec($ch);
	curl_close($ch);
	$content = json_decode($content, true);

	return $content;
}


function handle_backlinks_on_acf_save_post() {

	$postID = get_the_ID();
	$backlinks = array();
	$fields = get_fields($postID);
	foreach ($fields as $key => $value) {
		if(strpos($key, '_backlink')){
			$value = textareaToArray($value);
			$backlinks[$key] = $value;
		}
	}

	$backlinks = json_encode($backlinks);

	if ( ! add_post_meta( $postID, 'backlinks', $backlinks, true ) ) {
		update_post_meta( $postID, 'backlinks', $backlinks );
	}


	//Add google pagespeed data on post create
	$url = get_field('website_url', $postID);
	$googlePageSpeedData = get_google_pagespeed_data(addhttp($url));
	$check = json_decode($googlePageSpeedData, true);
	if(!isset($check['error'])) {
		if (!add_post_meta( $postID, 'googlePageSpeedDataBefore', $googlePageSpeedData, true)){}
	}
//	//Add site to SERanking
//	if(empty($fields['se_rankins_site_id'])){
//		$serankingData = addSiteToSERanking(addhttp($url));
//		update_field('se_rankins_site_id', $serankingData['siteid'], $postID);
//		addSiteKeywordsToSERanking($serankingData['siteid'], textareaToArray(strip_tags($fields['keywords_type'])));
//	}

	return;

}

add_action('acf/save_post', 'handle_backlinks_on_acf_save_post', 20);


//Form data for "Profile Details" tab of SEO Clients report.
add_action( 'wp_ajax_get_user_profile_details', 'get_user_profile_details' );
add_action( 'wp_ajax_get_user_profile_details', 'get_user_profile_details' );
function get_user_profile_details() {
	if(isset($_POST) && !empty($_POST['postID']) ) {
		$postID = $_POST['postID'];
		$customFieldsList = array(
			'fiverr_username',
			'bought_package',
			'website_url',
			'keywords_type',
			'social_logins',
			'website_admin_logins',
			'google_pages_access',
			'client_name',
			'client_email',
			'client_address',
			'client_phone',
			'client_zip_code',
			'client_google_analytics',
			'additional_info',
		);

		$fields = get_fields($postID);
		$formData = array();
		foreach($fields as $key => $field){
			if(in_array($key, $customFieldsList)){
				$formData[$key] = $field;
			}
		}
		wp_send_json($formData);
	}
}