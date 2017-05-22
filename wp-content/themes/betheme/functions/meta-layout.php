<?php
/**
 * Layout custom meta fields.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

/* ---------------------------------------------------------------------------
 * Create new post type
 * --------------------------------------------------------------------------- */
function mfn_layout_post_type() 
{
	$layout_item_slug = mfn_opts_get( 'layout-slug', 'layout-item' );
	
	$labels = array(
		'name' 					=> __('Layouts','mfn-opts'),
		'singular_name' 		=> __('Layout','mfn-opts'),
		'add_new'				=> __('Add New','mfn-opts'),
		'add_new_item' 			=> __('Add New Layout','mfn-opts'),
		'edit_item' 			=> __('Edit Layout','mfn-opts'),
		'new_item' 				=> __('New Layout','mfn-opts'),
		'view_item' 			=> __('View Layout','mfn-opts'),
		'search_items' 			=> __('Search Layouts','mfn-opts'),
		'not_found' 			=> __('No layouts found','mfn-opts'),
		'not_found_in_trash'	=> __('No layouts found in Trash','mfn-opts'), 
		'parent_item_colon' 	=> ''
	  );
		
	$args = array(
		'labels' 				=> $labels,
		'menu_icon'				=> 'dashicons-edit',
		'public' 				=> true,
		'publicly_queryable'	=> true,
		'show_ui' 				=> true, 
		'query_var' 			=> true,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'rewrite' 				=> array( 'slug' => $layout_item_slug, 'with_front'=>true ),
		'supports' 				=> array( 'title', 'page-attributes' ),
	); 
	  
	register_post_type( 'layout', $args );
}
add_action( 'init', 'mfn_layout_post_type' ); 


/*-----------------------------------------------------------------------------------*/
/*	Define Metabox Fields
/*-----------------------------------------------------------------------------------*/

$mfn_layout_meta_box = array(
	'id' 		=> 'mfn-meta-layout',
	'title' 	=> __('Layout Options','mfn-opts'),
	'page' 		=> 'layout',
	'context' 	=> 'normal',
	'priority'	=> 'high',
	'fields' 	=> array(

		array(
			'id'		=> 'mfn-post-layout',
			'type' 		=> 'radio_img',
			'title' 	=> __('Layout', 'mfn-opts'),
			'options' 	=> array(
				'full-width' 	=> array('title' => 'Full width', 'img' => MFN_OPTIONS_URI.'img/1col.png'),
				'boxed' 		=> array('title' => 'Boxed', 'img' => MFN_OPTIONS_URI.'img/boxed.png'),
			),
			'std' 		=> 'full-width'
		),
			
		array(
			'id' 		=> 'mfn-post-grid960',
			'type' 		=> 'switch',
			'title' 	=> __('960px Grid', 'mfn-opts'),
			'desc' 		=> __('Turn it ON if you prefer narrow 960px grid.', 'mfn-opts'),
			'options' 	=> array('1' => 'On','0' => 'Off'),
			'std' 		=> '0'
		),
	
		array(
			'id' 		=> 'mfn-post-bg',
			'type' 		=> 'upload',
			'title' 	=> __('Background Image', 'mfn-opts'),
			'desc' 		=> __('This option can be used <strong>only</strong> with Layout: Boxed.', 'mfn-opts'),
		),
		
		array(
			'id' 		=> 'mfn-post-bg-pos',
			'type' 		=> 'select',
			'title' 	=> __('Background Image | Position', 'mfn-opts'),
			'desc' 		=> __('This option can be used only with your custom image selected above.', 'mfn-opts'),
			'options' 	=> mfna_bg_position(),
			'std' 		=> 'center top no-repeat',
		),
	
		array(
			'id'		=> 'mfn-post-logo-img',
			'type'		=> 'upload',
			'title'		=> __('Logo', 'mfn-opts'),
		),
			
		array(
			'id'		=> 'mfn-post-retina-logo-img',
			'type'		=> 'upload',
			'title'		=> __('Logo | Retina', 'mfn-opts'),
			'desc'		=> __('Retina Logo should be 2x larger than Custom Logo', 'mfn-opts'),
			'sub_desc'	=> __('optional', 'mfn-opts'),
		),
			
		array(
			'id'		=> 'mfn-post-sticky-logo-img',
			'type'		=> 'upload',
			'title'		=> __('Logo | Sticky Header', 'mfn-opts'),
			'sub_desc'	=> __('optional', 'mfn-opts'),
			'desc'		=> __('Use if you want different logo for Sticky Header', 'mfn-opts'),
		),	
		
		array(
			'id'		=> 'mfn-post-sticky-retina-logo-img',
			'type'		=> 'upload',
			'title'		=> __('Logo | Sticky Header Retina', 'mfn-opts'),
			'sub_desc'	=> __('optional', 'mfn-opts'),
			'desc'		=> __('Retina Logo should be 2x larger than Sticky Logo', 'mfn-opts'),
		),
			
		array(
			'id' 		=> 'mfn-post-header-style',
			'type' 		=> 'radio_img',
			'title' 	=> __('Header | Style', 'mfn-opts'),
			'options'	=> mfna_header_style(),
			'std'		=> 'modern',
			'class'		=> 'wide',
		),
			
		array(
			'id'		=> 'mfn-post-sticky-header-style',
			'type'		=> 'select',
			'title'		=> __('Header | Sticky Style', 'mfn-opts'),
			'options'	=> array(
				'white'		=> 'White',
				'dark'		=> 'Dark',
			),
		),
			
		array(
			'id'		=> 'mfn-post-minimalist-header',
			'type'		=> 'switch',
			'title'		=> __('Header | Minimalist', 'mfn-opts'),
			'desc'		=> __('Header without background image & padding', 'mfn-opts'),
			'options'	=> array('1' => 'On','0' => 'Off'),
			'std'		=> '0'
		),
	
		array(
			'id' 		=> 'mfn-post-skin',
			'type' 		=> 'select',
			'title' 	=> __('Skin', 'mfn-opts'),
			'sub_desc' 	=> __('Choose one of the predefined styles or set your own colors', 'mfn-opts'),
			'desc' 		=> __('<strong>Important:</strong> Color options can be used only with the <strong>Custom Skin</strong>', 'mfn-opts'),
			'options' 	=> mfna_skin(),
			'std' 		=> 'custom',
		),
			
		array(
			'id' 		=> 'mfn-post-background-subheader',
			'type' 		=> 'color',
			'title' 	=> __('Subheader | Background', 'mfn-opts'),
			'std' 		=> '#F7F7F7',
		),
		
		array(
			'id' 		=> 'mfn-post-color-subheader',
			'type' 		=> 'color',
			'title' 	=> __('Subheader | Text color', 'mfn-opts'),
			'std' 		=> '#888888',
		),

	),
);


/*-----------------------------------------------------------------------------------*/
/*	Add metabox to edit page
/*-----------------------------------------------------------------------------------*/ 
function mfn_layout_meta_add() {
	global $mfn_layout_meta_box;
	add_meta_box($mfn_layout_meta_box['id'], $mfn_layout_meta_box['title'], 'mfn_layout_show_box', $mfn_layout_meta_box['page'], $mfn_layout_meta_box['context'], $mfn_layout_meta_box['priority']);
}
add_action('admin_menu', 'mfn_layout_meta_add');


/*-----------------------------------------------------------------------------------*/
/*	Callback function to show fields in meta box
/*-----------------------------------------------------------------------------------*/
function mfn_layout_show_box() {
	global $MFN_Options, $mfn_layout_meta_box, $post;
	$MFN_Options->_enqueue();
 	
	// Use nonce for verification
	echo '<div id="mfn-wrapper">';
		echo '<input type="hidden" name="mfn_layout_meta_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		echo '<table class="form-table">';
			echo '<tbody>';
	 
				foreach ($mfn_layout_meta_box['fields'] as $field) {
					$meta = get_post_meta($post->ID, $field['id'], true);
					if( ! key_exists('std', $field) ) $field['std'] = false;
					$meta = ( $meta || $meta==='0' ) ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES ));
					mfn_meta_field_input( $field, $meta );
				}
	 
			echo '</tbody>';
		echo '</table>';
	echo '</div>';
}


/*-----------------------------------------------------------------------------------*/
/*	Save data when post is edited
/*-----------------------------------------------------------------------------------*/
function mfn_layout_save_data($post_id) {
	global $mfn_layout_meta_box;
 
	// verify nonce
	if( key_exists( 'mfn_layout_meta_nonce',$_POST ) ) {
		if ( ! wp_verify_nonce( $_POST['mfn_layout_meta_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
	}
 
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ( (key_exists('post_type', $_POST)) && ('page' == $_POST['post_type']) ) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
 
	foreach ($mfn_layout_meta_box['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		if( key_exists($field['id'], $_POST) ) {
			$new = $_POST[$field['id']];
		} else {
//			$new = ""; // problem with "quick edit"
			continue;
		}
 
		if ( isset($new) && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
add_action('save_post', 'mfn_layout_save_data');


/*-----------------------------------------------------------------------------------*/
/*	Styles & scripts
 /*-----------------------------------------------------------------------------------*/
function mfn_layout_admin_styles() {
	wp_enqueue_style( 'mfn.builder', LIBS_URI. '/css/mfn.builder.css', false, time(), 'all');
}
add_action('admin_print_styles', 'mfn_layout_admin_styles');

function mfn_layout_admin_scripts() {
	wp_enqueue_script( 'jquery.mfn.builder', LIBS_URI. '/js/mfn.builder.js', false, time(), true );
}
add_action('admin_print_scripts', 'mfn_layout_admin_scripts');

?>