<?php

/*Code for adding "Username" column to SEO Client reports list in admin panel */
add_filter('manage_seo-client-reports_posts_columns' , 'columns_seo_client_reports');

function columns_seo_client_reports( $columns ) {

	// New columns to add to table
	$columns['user_name'] = __( 'Username' );
	$columns['package_type'] = __( 'Package Type' );
	return $columns;
}

// Let WordPress know to use our filter

add_action('manage_seo-client-reports_posts_custom_column', 'columns_seo_client_reports_content', 10, 2);

function columns_seo_client_reports_content( $column, $post_id ) {

	switch( $column ) {

		case 'user_name' :
			$fiverr_username = get_field('fiverr_username', $post_id);
			echo ''.$fiverr_username.'';
			break;
		case 'package_type' :
			$package_type = get_field('bought_package', $post_id);
			echo ''.$package_type.'';
			break;
		default :
			break;
	}
}

// Let WordPress know to use our filter
add_filter( 'manage_seo-client-reports_sortable_columns', 'seo_client_reports_custom_columns_sortable' );

function seo_client_reports_custom_columns_sortable( $columns ) {

	// Add our columns to $columns array
	$columns['user_name'] = 'Username';
	$columns['package_type'] = 'Package Type';
	return $columns;
}
/*End of Code for adding "Username" column to SEO Client reports list in admin panel */
