<?php 
/*
Plugin Name: Fiverr Forms
Plugin URI: 
Description: 
Version: 1.0
Author: Lilumi
Author URI: 
License: 
Text Domain: fifo
*/  

define('FIFO_URL', plugins_url('', __FILE__ ));
define('FIFO_PATH', dirname(__FILE__));

 
function fifo_acf_json_save_point( $path ) {
  
    $path = FIFO_PATH . '/acf-json';
  
    return $path;
    
}


function fifo_acf_json_load_point( $paths ) {
    
    unset($paths[0]);
    $paths[] = FIFO_PATH . '/acf-json';
    
    return $paths;
    
}

function fifo_set_acf_path() {
  add_filter('acf/settings/save_json', 'fifo_acf_json_save_point');
  add_filter('acf/settings/load_json', 'fifo_acf_json_load_point');  
  
  if (!current_user_can('delete_pages')) {
	  add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
  }
}

add_action( 'init', 'fifo_set_acf_path', 0 );


// Register Custom Post Type
function fifo_add_order_post_type() {

	$labels = array(
		'name'                => _x( 'Fiverr Orders', '', 'fifo' ),
		'singular_name'       => _x( 'Fiverr Order', '', 'fifo' ),
		'menu_name'           => __( 'Fiverr Orders', 'fifo' ),
		'name_admin_bar'      => __( 'Fiverr Orders', 'fifo' ),
		'parent_item_colon'   => __( '', 'fifo' ),
		'all_items'           => __( 'All Fiverr Orders', 'fifo' ),
		'add_new_item'        => __( 'Add New Order', 'fifo' ),
		'add_new'             => __( 'Add New', 'fifo' ),
		'new_item'            => __( 'New Fiverr Order', 'fifo' ),
		'edit_item'           => __( 'Edit Fiverr Order', 'fifo' ),
		'update_item'         => __( 'Update Fiverr Order', 'fifo' ),
		'view_item'           => __( 'View Fiverr Order', 'fifo' ),
		'search_items'        => __( 'Search Fiverr Order', 'fifo' ),
		'not_found'           => __( 'Not found', 'fifo' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'fifo' ),
	);
	$args = array(
		'label'               => __( 'Fiverr Order', 'fifo' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'author', 'comments', 'revisions', 'custom-fields', ),
		'taxonomies'          => array( 'status' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 25,
		'menu_icon'           => 'dashicons-portfolio',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => false,		
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'fiverr_order', $args );

}
add_action( 'init', 'fifo_add_order_post_type', 0 );

// Register Custom Taxonomy
function fifo_add_status_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Statuses', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Status', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Status', 'text_domain' ),
		'all_items'                  => __( 'All Statuses', 'text_domain' ),
		'parent_item'                => __( 'Parent Status', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Status:', 'text_domain' ),
		'new_item_name'              => __( 'New Status', 'text_domain' ),
		'add_new_item'               => __( 'Add New Status', 'text_domain' ),
		'edit_item'                  => __( 'Edit Status', 'text_domain' ),
		'update_item'                => __( 'Update Status', 'text_domain' ),
		'view_item'                  => __( 'View Status', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Statuses with commas', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Status', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
		'popular_items'              => __( 'Popular Statuses', 'text_domain' ),
		'search_items'               => __( 'Search Statuses', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'status', array( 'fiverr_order' ), $args );
	
	fifo_create_status('In Progress'); //old NEW
	fifo_create_status('Assigned'); //old To do 
	fifo_create_status('Urgent'); 
	fifo_create_status('Rejected'); 
	fifo_create_status('Completed');
	
	fifo_cache_status_id();

}
add_action( 'init', 'fifo_add_status_taxonomy', 0 );

function fifo_create_status($status_name = null) {
  if ($status_name === null) return;
  
  $exists = term_exists( $status_name, 'status' );
  if ($exists == false) {
    wp_insert_term($status_name, 'status');
  }
  
}

function fifo_cache_status_id() {
  
  $cached_ids = get_option('status_to_id');
  
  if (empty($cached_ids)) {
    global $wpdb;
    $results = $wpdb->get_results( $wpdb->prepare("SELECT t.term_id, name FROM $wpdb->terms as t INNER JOIN $wpdb->term_taxonomy as tt ON t.term_id = tt.term_id WHERE tt.taxonomy = 'status';", array()), ARRAY_A );
    
    foreach ($results as $res) {
      $to_cache[$res['name']] = (int) $res['term_id']; 
    }

    update_option('status_to_id', $to_cache);
  }
  
}

function remove_admin_menu_items() { //! remove status taxonomy page
  remove_submenu_page( 'edit.php?post_type=fiverr_order', 'edit-tags.php?taxonomy=status&amp;post_type=fiverr_order' );
  
  if (!current_user_can('delete_pages')) {
    remove_menu_page( 'index.php' );
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit.php?post_type=fiverr_order' );
    remove_menu_page( 'profile.php' );
  }
  
}

add_action('admin_menu', 'remove_admin_menu_items');

function change_role_name() {
    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    //You can list all currently available roles like this...
    //$roles = $wp_roles->get_names();
    //print_r($roles);

    //You can replace "administrator" with any other role "editor", "author", "contributor" or "subscriber"...
    $wp_roles->roles['contributor']['name'] = 'Worker';
    $wp_roles->role_names['contributor'] = 'Worker';           
}
add_action('init', 'change_role_name');


function dashboard_redirect($url) {

  if(!current_user_can('delete_pages')) {
    $url = 'wp-admin/admin.php?page=fiverr-orders';
    return $url;
  }
  
}
add_filter('login_redirect', 'dashboard_redirect'); 

function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function fifo_add_status_history_meta_box() {

	$screens = array( 'fiverr_order' );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'myplugin_sectionid',
			__( 'Order Status History', 'fifo' ),
			'fifo_status_history_meta_box_callback',
			$screen,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'fifo_add_status_history_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function fifo_status_history_meta_box_callback( $post ) {
  
  echo 'Form: <span title="'.get_post_meta($post->ID, 'form_id', true).'">'.get_post_meta($post->ID, 'form_title', true)."</span><br />\n<hr />";

	$order_status_history = get_post_meta( $post->ID, 'order_status_history', true );
	
	if (is_array($order_status_history)) {
  	foreach ($order_status_history as $status) {
    	echo $status."<br/>\n";
  	}
	}
  
}


function fifo_update_status_history($post_id = null, $message = '', $field_name = 'order_status_history' ) {
  
  if ( $post_id === null ) return;
  
  $order_status_history = get_post_meta($post_id, $field_name, true);

  if (is_array($order_status_history)) {
    $order_status_history[] = $message;
    update_post_meta($post_id, $field_name, $order_status_history);
  } else {
    update_post_meta($post_id, $field_name, array($message));
  }
  
}

add_filter('acf/validate_value/name=site_url_unformated', 'validate_url_textfield', 10, 4);
function validate_url_textfield( $valid, $value, $field, $input ) {

    // bail early if value is already invalid
    if( !$valid ) {
        return $valid;
    }
    
    $urls = fifo_parse_urls($value); 

    // return
    return count($urls)>0 ? true : 'No valid links found in textarea';
}

add_action('acf/save_post', 'fifo_save_form');

function fifo_save_form( $post_id ) { //!creating order
	
	// bail early if not a fiverr_order
	if( get_post_type($post_id) !== 'fiverr_order' ) 	return;		
	
	if (!empty($_REQUEST['acf']['field_5626a463de2af'])) return; // exit if worker try to generate report - if there is a Full Name, then exit from this function.
		
	// bail early if editing in admin
	if( is_admin() ) return;
	
  $forms = get_field('forms','options');
  
  //var_dump($forms);
  
  foreach ($forms as $form) {
  
   if ($form['form_name'] === $_GET['fiverr_form']) {
     global $current_form;
     $current_form = $form;
     
     break;
   }
  
  }

    $acf_fields = $_POST['acf'];
    
    $urls = fifo_parse_urls($acf_fields['field_565721c4e61cd']); 
    
    update_field('field_56153b416b899',$urls,$post_id); //site_url

	// vars
	$post = get_post( $post_id );
	
	$created = current_time( 'mysql' );
	
	update_post_meta($post_id, 'form_title_from_request', $_GET['fiverr_form']);
	update_post_meta($post_id, 'form_title', $current_form['title']);
	update_post_meta($post_id, 'form_id', $current_form['form_name']);
	update_post_meta($post_id, 'form_created', $created);
	
	
	$deadline = (!empty($current_form['time'])) ? intval($current_form['time']) : 24;
	
	update_post_meta($post_id, 'created_time', time()); // we need UTC timestamp to correct run countdown timer on js
	update_post_meta($post_id, 'deadline', 60*60*$deadline+time()); // we need UTC timestamp to correct run countdown timer on js
	
	fifo_register_accounts($post_id);

	
	fifo_update_status_history($post_id, 'order created at '.$created);
	
	wp_set_object_terms($post_id, 'In progress', 'status', false);
	
	fifo_update_status_history($post_id, 'Status changed to "In progress" at '.$created);
	
	fifo_save_status_timestamp($post_id);
	
	if ($_GET['manual']==='manual') {
  	wp_update_post(array(
        'ID' => $post_id,
        'post_author' => -1
      ));
	}
	
}


add_action('fifo_filter_form_fields', 'fifo_choose_which_fields_to_show');

function fifo_choose_which_fields_to_show() {
  
  $forms = get_field('forms','options');
  
  //var_dump($forms);
  
  foreach ($forms as $form) {
  
   if ($form['form_name'] === $_GET['fiverr_form']) {
     global $current_form;
     $current_form = $form;
     
     break;
   }
  
  }
  
  if ( $current_form['show_network_choise'] == false ) {
  
    add_filter('acf/load_field/name=hide_network_choise', 'fifo_mark_checkbox_checked');
  
  }
  
  if ( $current_form['show_research_type'] == false ) {
  
    add_filter('acf/load_field/name=hide_research_type', 'fifo_mark_checkbox_checked');
  
  }
  
  if ( $current_form['show_keywords'] == false ) {
  
    add_filter('acf/load_field/name=hide_keywords', 'fifo_mark_checkbox_checked');
  
  } 
  
  if ( $current_form['show_site_url'] == false ) {
  
    add_filter('acf/load_field/name=hide_site_url', 'fifo_mark_checkbox_checked');
  
  }    
  
  // add here "if logic" to new fields
  

}

function fifo_mark_checkbox_checked( $field ) {
  
    //if (is_admin()) return $field;
    
    $field['value'] = 1;
    
    //var_dump($field);

    // return the field
    return $field;
    
}



/**
 * Load CSS Styles and Javascript Files
 */
if ( ! function_exists('fifo_css_and_js') ) :
function fifo_css_and_js() {

    wp_enqueue_style( 'fifo-fronend', FIFO_URL.'/css/fifo-style.css');

    wp_register_script( 'fifo-front-js',  FIFO_URL . '/js/fifo-front.js', array(), '0.1.0', true );
    wp_enqueue_script( 'fifo-front-js' );
    wp_localize_script( 'fifo-front-js', 'ajaxConfig', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
       	'fifo_nonce' => wp_create_nonce( 'fifo_nonce' ),
    ) ); 

} // end function

add_action( 'wp_enqueue_scripts', 'fifo_css_and_js' );
endif; // end ! function_exists

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Fiverr Forms',
		'menu_title'	=> 'Fiverr Forms',
		'menu_slug' 	=> 'fiverr-forms',
		'capability'	=> 'delete_pages',
		'redirect'		=> false
	));

}	


add_action( 'admin_menu', 'fifo_orders_menu' );

function fifo_orders_menu() {
	add_menu_page( 'Fiverr Orders', 'Fiverr Orders', 'edit_posts', 'fiverr-orders', 'fifo_render_fiverr_orders', 'dashicons-media-spreadsheet', 3 );
	
	add_submenu_page( 'fiverr-orders', 'Add Order', 'Add Order', 'edit_posts', 'admin-fiverr-orders', 'fifo_render_admin_fiverr_orders');
	add_submenu_page( 'fiverr-orders', 'Search Order', 'Search Order', 'edit_posts', 'search-fiverr-orders', 'fifo_render_search_fiverr_orders');
	add_submenu_page( 'fiverr-orders', 'Orders Report Generator', 'Orders Report Generator', 'edit_posts', 'report-generator', 'fifo_reports_generator');
	add_submenu_page( 'fiverr-orders', 'Backlinks Checker', 'Backlinks Checker', 'edit_posts', 'backlinks-checker', 'fifo_backlinks_checker');
	
}

function fifo_render_fiverr_orders() {
	if ( !current_user_can( 'read' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include_once 'view-orders.php';
}

function fifo_render_admin_fiverr_orders() {
	if ( !current_user_can( 'read' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}  
	include_once 'admin-view-orders.php'; 
}

function fifo_render_search_fiverr_orders() {
	if ( !current_user_can( 'read' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}  
	include_once 'search-orders.php'; 
}

function fifo_reports_generator() {
	if ( !current_user_can( 'read' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}  
	include_once 'report-generator.php';   
}

require_once 'report-generator-functions.php';


function fifo_backlinks_checker() {
	if ( !current_user_can( 'read' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}  
	include_once 'backlinks-checker/link-checker.php';   
}

require_once 'backlinks-checker/link-checker-functions.php';


function fifo_add_backend_scripts() {
  
  wp_enqueue_style( 'fifo-backend-css', plugins_url( 'css/fifo-backend.css', __FILE__ ));
    wp_enqueue_style( 'jquery-ui', plugins_url('/css/jquery-ui.min.css', __FILE__ ));
    wp_enqueue_style( 'editor-buttons' );

  if (is_user_logged_in() && ($_GET['page']==='fiverr-orders' || $_GET['page']==='search-fiverr-orders' || $_GET['page']==='backlinks-checker') || $_GET['page']==='report-generator') {

      wp_register_script( 'wp-util', includes_url('js/wp-util.js'),array (), '20141010', true );
      wp_enqueue_script( 'wp-util' );


      wp_enqueue_script ('jquery-ui-core');
      wp_enqueue_script ('jquery-ui-dialog');
    wp_enqueue_script ( 'fifo-data_tables', plugins_url( 'js/jquery.data_tables.js', __FILE__ ), array( 'jquery' ) );
  
    wp_enqueue_script ( 'fifo-countdown', plugins_url( 'js/countdown.min.js', __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script ( 'fifo-backend-script', plugins_url( 'js/fifo-backend.js', __FILE__ ), array( 'jquery','jquery-ui-dialog' ) );
    wp_localize_script( 'fifo-backend-script', 'ajaxConfig', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
           	'fifo_nonce' => wp_create_nonce( 'fifo_nonce' ),
        ) ); 
        

  }      
}

add_action( 'admin_enqueue_scripts', 'fifo_add_backend_scripts' );	


function fifo_pagination( $args = array()) {
  
  $which = $args['position'];

	$total_items = $args['total_items'];
	$total_pages = $args['total_pages'];

	$output = '<span class="displaying-num">' . sprintf( _n( '%s item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';
	
	$url_parts = parse_url($_SERVER['REQUEST_URI']);
	parse_str($url_parts['query'], $query);

	$current = (!empty($query['paged'])) ? $query['paged'] : 1;

	$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

	$current_url = remove_query_arg( array( 'hotkeys_highlight_last', 'hotkeys_highlight_first' ), $current_url );

	$page_links = array();

	$total_pages_before = '<span class="paging-input">';
	$total_pages_after  = '</span>';

	$disable_first = $disable_last = $disable_prev = $disable_next = false;

		if ( $current == 1 ) {
		$disable_first = true;
		$disable_prev = true;
		}
	if ( $current == 2 ) {
		$disable_first = true;
	}
		if ( $current == $total_pages ) {
		$disable_last = true;
		$disable_next = true;
		}
	if ( $current == $total_pages - 1 ) {
		$disable_last = true;
	}

	if ( $disable_first ) {
		$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&laquo;</span>';
	} else {
		$page_links[] = sprintf( "<a class='first-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
			esc_url( remove_query_arg( 'paged', $current_url ) ),
			__( 'First page' ),
			'&laquo;'
		);
	}

	if ( $disable_prev ) {
		$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&lsaquo;</span>';
	} else {
		$page_links[] = sprintf( "<a class='prev-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
			esc_url( add_query_arg( 'paged', max( 1, $current-1 ), $current_url ) ),
			__( 'Previous page' ),
			'&lsaquo;'
		);
	}

	if ( 'bottom' == $which ) {
		$html_current_page  = $current;
		$total_pages_before = '<span class="screen-reader-text">' . __( 'Current Page' ) . '</span><span id="table-paging" class="paging-input">';
	} else {
		$html_current_page = sprintf( "%s<input class='current-page' id='current-page-selector' type='text' name='paged' value='%s' size='%d' aria-describedby='table-paging' />",
			'<label for="current-page-selector" class="screen-reader-text">' . __( 'Current Page' ) . '</label>',
			$current,
			strlen( $total_pages )
		);
	}
	$html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
	$page_links[] = $total_pages_before . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . $total_pages_after;

	if ( $disable_next ) {
		$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&rsaquo;</span>';
	} else {
		$page_links[] = sprintf( "<a class='next-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
			esc_url( add_query_arg( 'paged', min( $total_pages, $current+1 ), $current_url ) ),
			__( 'Next page' ),
			'&rsaquo;'
		);
	}

	if ( $disable_last ) {
		$page_links[] = '<span class="tablenav-pages-navspan" aria-hidden="true">&raquo;</span>';
	} else {
		$page_links[] = sprintf( "<a class='last-page' href='%s'><span class='screen-reader-text'>%s</span><span aria-hidden='true'>%s</span></a>",
			esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
			__( 'Last page' ),
			'&raquo;'
		);
	}

	$pagination_links_class = 'pagination-links';
	if ( ! empty( $infinite_scroll ) ) {
		$pagination_links_class = ' hide-if-js';
	}
	$output .= "\n<span class='$pagination_links_class'>" . join( "\n", $page_links ) . '</span>';

	if ( $total_pages ) {
		$page_class = $total_pages < 2 ? ' one-page' : '';
	} else {
		$page_class = ' no-pages';
	}
	$result = "<div class='tablenav-pages{$page_class}'>$output</div>";

	echo $result;

}


function fifo_assign_to_user($user_id, $sid) {
    
    $user_id = intval($user_id);
    
    if ( $sid > 0) {  
      
      wp_update_post(array(
        'ID' => $sid,
        'post_author' => $user_id
      ));
      
      if ($user_id > 0 ) { //assign to user
      
        $author_data = get_userdata( $user_id );    
        $display_name = $author_data->display_name;
        $curr_user_id = get_current_user_id();
        
        if ($user_id !== $curr_user_id) {   
          
          $curr_user = get_userdata ( $curr_user_id ); 
        
          fifo_update_status_history($sid, 'Assigned to user <strong>"'.$display_name.'"</strong> by administrator "'.$curr_user->display_name.'" at '.current_time( 'mysql' ));
        
        } else { // assigned by himself         
          fifo_update_status_history($sid, 'Assigned to user <strong>"'.$display_name.'"</strong> at '.current_time( 'mysql' ));
        }
        
        wp_set_object_terms($sid, 'Assigned', 'status', false);
        
        fifo_save_status_timestamp($sid);
        
      
      } else { // clear assignment to user
        
        fifo_update_status_history($sid, 'Administrator "'.$curr_user->display_name.'" cleared assosiated user for this order at '.current_time( 'mysql' ));
        
        wp_set_object_terms($sid, 'In progress', 'status', false);
        
        fifo_save_status_timestamp($sid);
        
        $display_name = '';
      } 
      
      return $display_name;
      
    }   
}
	

add_action( 'wp_ajax_assign-to-me', 'fifo_assign_task_to_current_user' );

function fifo_assign_task_to_current_user() {
  define('DOING_AJAX', true);
  $response['state'] = 'error';
  //var_dump($_REQUEST);
  if ( wp_verify_nonce( $_REQUEST['fifo_nonce'], 'fifo_nonce' ) ) { 
    
    $user_id = get_current_user_id();
    $sid = $_REQUEST['pid'];    
    
    if ($user_id > 0 && $_REQUEST['pid'] > 0) {  
      
      $response['display_name'] = fifo_assign_to_user($user_id, $sid);      
      $response['status']  = fifo_return_status_html($sid);      
      $response['state'] = 'ok';
    
    }
    
  }

  header( "Content-Type: application/json" );
  echo json_encode($response);
  exit;  
  
}


add_action( 'wp_ajax_assign-by-admin', 'fifo_assign_task_to_user' );

function fifo_assign_task_to_user() {
  define('DOING_AJAX', true);
  $response['state'] = 'error';
  //var_dump($_REQUEST);
  if ( wp_verify_nonce( $_REQUEST['fifo_nonce'], 'fifo_nonce' ) ) { 
    
    $user_id = intval($_REQUEST['user_id']);
    
    $sid = $_REQUEST['pid'];
    
    if ( $sid > 0) {  
      
      $response['display_name'] = fifo_assign_to_user($user_id, $sid);      
      $response['status']  = fifo_return_status_html($sid);               
      $response['state'] = 'ok';
    
    }
    
  }

  header( "Content-Type: application/json" );
  echo json_encode($response);
  exit;  
  
}

function fifo_return_status_html($sid) {
  if (empty($sid)) return;
  
  $sterms = wp_get_post_terms($sid, 'status');
  $status = $sterms[0]->name;
  $status_class = (!empty($sterms)) ? sanitize_title($status) : 'In Progress' ;
  

  $status_html  = '<span class="status-icon '.$status_class.'">&#x25cf;</span> '.   
    '<span class="fifo-status">'.$status.'</span>';
  $status_html .= '<br /><span class="deadline" data-deadline="'.get_field('deadline', $sid).'"></span><br />'.
    'Deadline: '.date( 'Y-m-d H:i:s', get_field('deadline', $sid) + get_option('gmt_offset')*60*60 ).'<br />';
  $status_html .= '<div class="row-actions"><span class="spinner"></span>'.      
    '<select name="" class="order_status" data-pid="'.$sid.'">'; 

  $statuses = get_terms( 'status', array('orderby' => 'id', 'order' => 'ASC','hide_empty' => false) );  
  if ( ! empty( $statuses ) && ! is_wp_error( $statuses ) ) {
    foreach ($statuses as $single_status) {
      if ($single_status->name === 'In progress' && empty($sterms) ) {
        $status_html .= '<option value="In Progress" selected="selected">In progress</option>';
      } elseif ($single_status->name === $status) {
        $status_html .= '<option value="'.$single_status->name.'" selected="selected">'.$single_status->name.'</option>';
      } else {
        $status_html .= '<option value="'.$single_status->name.'" >'.$single_status->name.'</option>';
      }
    }
  }
  
  $status_html .=" </select></div> \n";   

  
  return $status_html;
}

function fifo_save_status_timestamp($pid = null) {
  if (empty($pid)) return;
  update_post_meta($pid, 'last_changed', time());
}


add_action( 'wp_ajax_change-status', 'fifo_change_status' );

function fifo_change_status() {
  define('DOING_AJAX', true);
  $response['state'] = 'error';
  //var_dump($_REQUEST);
  if ( wp_verify_nonce( $_REQUEST['fifo_nonce'], 'fifo_nonce' ) ) { 
    
    $curr_user_id = get_current_user_id();
    $curr_user = get_userdata ( $curr_user_id );
    
    if ( $_REQUEST['pid'] > 0) {  
      
      wp_set_object_terms($_REQUEST['pid'], $_REQUEST['status'], 'status', false);
        
      fifo_update_status_history($_REQUEST['pid'], 'User "'.$curr_user->display_name.'" changed status to "'.$_REQUEST['status'].'" at '.current_time( 'mysql' ));
      
      fifo_save_status_timestamp($_REQUEST['pid']);
      
      if ($_REQUEST['status'] === 'Completed') {
        
        if (in_array('contributor', $curr_user->roles) && intVal(get_post_field( 'post_author', $_REQUEST['pid'] )) <= 0) {
          fifo_assign_to_user($curr_user_id, $_REQUEST['pid']);
        }
        
        update_post_meta($_REQUEST['pid'], 'order_completed', time());
      } 
        
      $response['status'] = $_REQUEST['status'];
      $response['status_class'] = sanitize_title($_REQUEST['status']);
      
      $response['state'] = 'ok';
    
    }
    
  }

  header( "Content-Type: application/json" );
  echo json_encode($response);
  exit;  
  
}

add_action( 'wp_ajax_change-single-to-urgent', 'fifo_change_single_to_urgent' );

function fifo_change_single_to_urgent() {
  define('DOING_AJAX', true);
  $response['state'] = 'error';
  //var_dump($_REQUEST);
  if ( wp_verify_nonce( $_REQUEST['fifo_nonce'], 'fifo_nonce' ) ) { 
    
    $curr_user_id = get_current_user_id();
    $curr_user = get_userdata ( $curr_user_id );
    
    if ( $_REQUEST['pid'] > 0) {  
      
      wp_set_object_terms($_REQUEST['pid'], $_REQUEST['status'], 'status', false);
        
	    update_post_meta($_REQUEST['pid'], 'deadline', 60*60*12+get_post_meta($_REQUEST['pid'],'created_time', true )); // set to Urgent
      
      fifo_update_status_history($_REQUEST['pid'], 'User "'.$curr_user->display_name.'" changed status to "'.$_REQUEST['status'].'" at '.current_time( 'mysql' )); 
      
      fifo_save_status_timestamp($_REQUEST['pid']);   
        
      $response['status'] = $_REQUEST['status'];
      $response['html_status'] = fifo_return_status_html($_REQUEST['pid']);
      $response['status_class'] = sanitize_title($_REQUEST['status']);
      
      $response['state'] = 'ok';
    
    }
    
  }

  header( "Content-Type: application/json" );
  echo json_encode($response);
  exit;  
  
}

function fifo_bulk_status($status, $sid) {

  $curr_user_id = get_current_user_id();  
  if ( intval($curr_user_id) <= 0 ) return;
  
  $curr_user = get_userdata ( $curr_user_id );
  
  if ( $sid > 0) {  
    
    wp_set_object_terms($sid, $status, 'status', false);
    
    if ($status === 'Urgent') {  
      update_post_meta($sid, 'deadline', 60*60*12+get_post_meta($sid,'created_time', true )); // set to Urgent
    }
    
    fifo_update_status_history($sid, 'User "'.$curr_user->display_name.'" changed status to "'.$status.'" at '.current_time( 'mysql' ));    
    
    fifo_save_status_timestamp($sid); 
    
    if ($status === 'Completed') {
      update_post_meta($sid, 'order_completed', time());
      
      if (in_array('contributor', $curr_user->roles) && intVal(get_post_field( 'post_author', $sid )) <= 0) {
        fifo_assign_to_user($curr_user_id, $sid);
      }
      
    } 
  
  }  
}


function fifo_bulk_action() {
  $pids = $_POST['pp'];
  
  $curr_user_id = get_current_user_id();
  
  if ($curr_user_id == false) return;
  
  $is_admin = current_user_can( 'manage_options' );
  $is_worker = current_user_can( 'read' );
  
  if (is_array($pids)) {
    foreach ($pids as $sid) {
      
      $author_id = get_post_field( 'post_author', $sid );
      
      if ($_POST['assign-to-user']!=='none') {
        if ($is_admin) {
          fifo_assign_to_user($_POST['assign-to-user'], $sid);
        } elseif ( $is_worker && intval($author_id) <=0 ) {
          fifo_assign_to_user($_POST['assign-to-user'], $sid);
        }
      }
      
      $author_id = get_post_field( 'post_author', $sid ); // to get fresh author
      
      if ($_POST['bulk-status']!=='none' && ($is_admin || $is_worker)) {
        fifo_bulk_status($_POST['bulk-status'], $sid);
      }
      
    }
  }

}


if (isset($_POST['export-csv'])) {
  add_action('wp_loaded', 'fifo_export_csv');
  //fifo_export_csv();
}


function fifo_export_csv() {
  $curr_user_id = get_current_user_id();
  if ($curr_user_id == false) return;
    
  $filename = 'orders-'.str_replace(' ', '_', current_time('mysql')).'.csv';
  $delimiter = ',';
  $array = array();
  
  header('Content-Disposition: attachment; filename="'.$filename.'";');
  header('Content-Type: application/csv; charset=UTF-8');

  $pids = $_POST['pp'];
  if (is_array($pids)) {

    foreach ($pids as $sid) {
      
      $sites = get_field('site_url', $sid);
      $sites_array = $keywords_array = array();
      if (!empty($sites)) {
        foreach ($sites as $site) {
          $sites_array[] = $site['url'];
        }
      }
      
      $keywords = get_field('keywords', $sid);  
      if (!empty($keywords)) {
        foreach ($keywords as $keyword) {
          $keywords_array[] = $keyword['keyword'];
        }
      }
      
      $array[] = array(
        'created' => get_post_meta($sid, 'form_created', true),
        'network' => get_field('network_of_sites', $sid),
        'sites' => implode(', ', $sites_array),
        'keywords' => implode(', ', $keywords_array),
        'name' => get_field('fiverr_username', $sid),
        'order' => get_field('order_number', $sid),
        
      );
    
    }
      
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://output', 'w'); 
      fputcsv($f, array('Created',"Please Choose Network of Sites","Please, put your website URL below:", "Keywords", "Please, put your FIVERR USERNAME below:","Please, put your ORDER #NUMBER below:"), $delimiter);
      // loop over the input array
      foreach ($array as $line) { 
          // generate csv lines from the inner arrays
          fputcsv($f, $line, $delimiter); 
      }   
    // make php send the generated csv lines to the browser
    //fpassthru($f);
    die;
  }
  
}

function fifo_create_zip($files = array(), $destination = '', $folderName = '',  $relative_path='', $overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		
		//add the files
		foreach($valid_files as $file) {
  		$namefile = (!empty($relative_path)) ? str_replace($relative_path, $folderName, $file): $file;
  		//mail('sdfsf@dsdg', 'rrrr', '----$namefile='.$namefile.'==$folderName='.$folderName.'==$relative_path='.$relative_path.'==file='.$file);
			$zip->addFile($file,$namefile);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}

function fifo_getDirContents($dir, &$results = array()){
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
            $results['files'][] = $path;
        } else if(is_dir($path) && $value != "." && $value != "..") {
            fifo_getDirContents($path, $results);
            $results['dirs'][] = $path;
        }
    }

    return $results;
}


require_once 'make_report.php';

// search bulk orders
add_action( 'wp_ajax_search-orders', 'fifo_search_orders' );

function fifo_search_orders() {
  define('DOING_AJAX', true);
  $response['state'] = 'error';
  
  $response['found_header'] = $response['not_found_header'] = '';
  $response['found_keys'] = $response['not_found'] = '';

  
  if ( wp_verify_nonce( $_REQUEST['fifo_nonce'], 'fifo_nonce' ) ) { 
    
    $fids_to_search = explode("\n", $_REQUEST['pids']);
    
    
    $not_found = $found_keys = array();
    
    if (is_array($fids_to_search) && !empty($fids_to_search) && !empty($fids_to_search[0])) {
      foreach ($fids_to_search as $fid) {
        
        $args =  array (
          'post_type' => 'fiverr_order',
          'post_status' => 'publish',
          'orderby' => 'ID',
          'order' => 'DESC',
          'nopaging' => true,
          'cache_results' => false,
          'fields' => 'ids',
          'meta_key'     => 'order_number',
          'meta_value'   => $fid,
        );
      
        $pid = get_posts($args);
        //var_dump($pid[0]);
        
        if (!empty($pid)) {
          $found_keys[$pid[0]] = $fid;
        } else {
          $not_found[] = $fid;
        }
      }
    }
    //var_dump($not_found);
    
    if (!empty($found_keys)) {
      $found = array();
      foreach ($found_keys as $key => $value) {
        $found[] = '<a href="'.get_permalink($key).'" target="_blank">'.$value.'</a>'; 
      }
      
      $response['found_header'] = 'Existant';
      $response['found_keys'] = implode('<br />', $found);
    }
    
    
    if (!empty($not_found)) {
      $response['not_found'] = implode('<br />', $not_found);
      $response['not_found_header'] = 'Non Existant';
    }
      
      $response['state'] = 'ok';
  }

  header( "Content-Type: application/json" );
  echo json_encode($response);
  exit;  
  
}


require_once 'admin-manage/admin-manage-functions.php';


function fifo_parse_urls($sites = null) {
  $site_url_text = strtolower($sites);
  preg_match_all('/((https?):\/\/?[^\s\,\;\t\r\n]*)/i',$site_url_text,$matches,PREG_PATTERN_ORDER);

  $urls = array();
  if(!empty($matches[1])&&is_array($matches[1])) {
    foreach($matches[1] as $key => $url)
      $urls[] = array('url'=> str_replace($matches[0][$key], strtolower($matches[0][$key]), $url) );
            
  } else return false;
  return $urls;   
}

$DEBUG_REGISTRATIONS = true;

function fifo_register_accounts($post_id = null) {
  if (empty($post_id)) return;
  
  global $DEBUG_REGISTRATIONS;
  
  $sites = get_field('field_56153b416b899', $post_id);
  if (empty($sites[0]['url'])) {
    $sites = get_field('field_565721c4e61cd', $post_id);
    
    $urls = fifo_parse_urls($sites);   
    
    $site = $urls[0]['url'];
    
  } else {
    $site = $sites[0]['url'];
  }
  
  if (strpos($site, 'http://') === false && strpos($site, 'https://') === false) {
    $site = 'http://'.$site; 
  }
  
  $response = wp_remote_post('http://178.62.200.211:8082/register-users', array(
    'body' => array( 
      'group_id' => 'f'.$post_id, 
      'site' => $site,
      'bio' => '---' ),
  ));
  
  
  $register_queue = get_option('registering_queue');  
  if (empty($register_queue)) {
    $register_queue = array();
  }
  $register_queue[$post_id] = array('id' => $post_id, 'checktime' => time()+60*5);
  update_option('registering_queue', $register_queue);
  
  if ( is_wp_error( $response ) ) {
    $error_message = $response->get_error_message();
    if ($DEBUG_REGISTRATIONS === true) {
      error_log(date('Y-m-d H:i:s')." ERROR posting to API id=".$post_id.', '.$error_message.' response='.var_export($response,1).PHP_EOL, 3, FIFO_PATH.'/registrations.log');
    } 
  } else {
    //all good 
/*
    $response = array (
      'headers' => array(
        'content-type' => 'application/json'
      ),
      'body' => '{"status": "success", "message": "Your registers was added to query"}',
      'response' => array(
        'code' => 200,
        'message' => 'OK'
      ),
      'cookies' => array(),
      'filename' => null
    );
*/
    if ($DEBUG_REGISTRATIONS === true) {
      error_log(date('Y-m-d H:i:s')."response. id=".$post_id.', '.var_export($response,1).PHP_EOL, 3, FIFO_PATH.'/registrations.log');
    }
  }
  
}

function fifo_check_registering_status() {
  
  $register_queue = get_option('registering_queue'); 
  
  global $DEBUG_REGISTRATIONS;
  
  $now = time();
  
  if (!empty($register_queue) && is_array($register_queue)) {
    foreach ($register_queue as $single_order) {
      
      error_log(date('Y-m-d H:i:s')." GOOD registrations response id=".$single_order['id'].', url ='.'http://178.62.200.211:8082/get-registrations/f'.$single_order['id'].', response='.var_export($response,1).PHP_EOL, 3, FIFO_PATH.'/registrations.log');
      
      if ($single_order['checktime'] < $now) {
        $response = wp_remote_get('http://178.62.200.211:8082/get-registrations/f'.$single_order['id']);          
        
        //var_dump($response);
        
          if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            if ($DEBUG_REGISTRATIONS === true) {
              error_log(date('Y-m-d H:i:s')." ERROR getting registrations ".$single_order['id'].' '.$error_message.' response'.var_export($response,1).PHP_EOL, 3, FIFO_PATH.'/registrations.log');
            }  
          
          } else { 
            $resp_body = json_decode($response['body'], true);
            
            if ($DEBUG_REGISTRATIONS === true) {
              error_log(date('Y-m-d H:i:s')." GOOD registrations response id=".$single_order['id'].', url ='.'http://178.62.200.211:8082/get-registrations/f'.$single_order['id'].', response='.var_export($response,1).PHP_EOL, 3, FIFO_PATH.'/registrations.log');
            }
            
            if (empty($resp_body['results'])) { // registrations not ready yet
              
              //add another five minutes              
              $register_queue[$single_order['id']]['checktime'] = time()+60*5;
              
            } else {
              //save data to order
              update_post_meta((int) $single_order['id'], 'registrations', $resp_body['results']);
                
              // if we received all data.
              if (count($resp_body['results']) === 15 ) {
                //remove from queue 
                unset($register_queue[$single_order['id']]);
              
              } else {
                //add another five minutes              
                $register_queue[$single_order['id']]['checktime'] = time()+60*5;
              }
              
            }
            
          }
        
      }
    }
    
    update_option('registering_queue', $register_queue);
    
  }
  
}

function maybe_divide_keywords($keyword) {
  if (strpos($keyword, ',') !== false) {
    $keyw = explode(',', $keyword);
    $result = '';
    foreach ($keyw as $key) {
      $result .= trim($key)."<br />\n";
    } 
    
    return $result;
    
  } else return $keyword."<br />\n";
} 
