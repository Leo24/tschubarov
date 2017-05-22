<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $wp_query;

if ( $wp_query->max_num_pages <= 1 )
	return;
?>
<div class="column one pager_wrapper">
	<div class="pager">
		<div class="pages">
			<?php
				echo paginate_links( apply_filters( 'woocommerce_pagination_args', array(
					'base'			=> esc_url( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', htmlspecialchars_decode( get_pagenum_link( 999999999 ) ) ) ) ),
					'format' 		=> '',
					'current' 		=> max( 1, get_query_var('paged') ),
					'total' 		=> $wp_query->max_num_pages,
					'prev_next'    	=> false,
					'type'			=> 'plain',
					'end_size'		=> 3,
					'mid_size'		=> 3
				) ) );
			?>
		</div>
	</div>
</div>