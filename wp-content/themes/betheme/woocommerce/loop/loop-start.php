<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

$shop_classes = array();

// shop layout aplies only for archives page (shop)
if( ! is_product() ){
	
	// layout
	if( $_GET && key_exists('mfn-shop', $_GET) ){
		$shop_layout = $_GET['mfn-shop']; // demo
	} else {
		$shop_layout = mfn_opts_get( 'shop-layout', 'grid' );
	}
	$shop_classes[] = $shop_layout;
	
	// isotope
	if( $shop_layout == 'masonry' ) $shop_classes[] = 'isotope';
	
}

$shop_classes = implode(' ', $shop_classes);
?>

<div class="products_wrapper isotope_wrapper">
	<ul class="products <?php echo $shop_classes; ?>">