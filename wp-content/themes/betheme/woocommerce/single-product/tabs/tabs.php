<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.4.0
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="accordion">
		<div class="mfn-acc accordion_wrapper open1st">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				
				<div class="question">
				
					<div class="title">
						<i class="icon-plus acc-icon-plus"></i><i class="icon-minus acc-icon-minus"></i>
						<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
					</div>
					
					<div class="answer">
						<?php call_user_func( $tab['callback'], $key, $tab ) ?>	
					</div>

				</div>

			<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>