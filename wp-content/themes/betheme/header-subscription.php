<?php
/**
 * The Header for our theme.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */
?><!DOCTYPE html>
<?php 
	if( $_GET && key_exists('mfn-rtl', $_GET) ):
		echo '<html class="no-js" lang="ar" dir="rtl">';
	else:
?>
<html class="no-js" <?php language_attributes(); ?> <?php mfn_tag_schema(); ?>>
<?php endif; ?>

<!-- head -->
<head>

<!-- meta -->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php if( mfn_opts_get('responsive') ) echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">'; ?>

<title itemprop="name"><?php
if( mfn_title() ){
	echo mfn_title();
} else {
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Page %s', 'betheme' ), max( $paged, $page ) );
}
?></title>

<?php do_action('wp_seo'); ?>

<link rel="shortcut icon" href="<?php mfn_opts_show( 'favicon-img', THEME_URI .'/images/favicon.ico' ); ?>" />	
<?php if( mfn_opts_get('apple-touch-icon') ): ?>
<link rel="apple-touch-icon" href="<?php mfn_opts_show( 'apple-touch-icon' ); ?>" />
<?php endif; ?>

<!-- wp_head() -->
<?php wp_head(); ?>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-101099779-1', 'auto');
        ga('send', 'pageview');

    </script>
    <script type="text/javascript">
        setTimeout(function(){var a=document.createElement("script");
            var b=document.getElementsByTagName("script")[0];
            a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0026/3743.js?"+Math.floor(new Date().getTime()/3600000);
            a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
    </script>
</head>

<!-- body -->
<body <?php body_class(); ?>>
	
	<?php do_action( 'mfn_hook_top' ); ?>
	
	<?php get_template_part( 'includes/header', 'sliding-area' ); ?>
	
	<?php if( mfn_header_style( true ) == 'header-creative' ) get_template_part( 'includes/header', 'creative' ); ?>
	
	<!-- #Wrapper -->
	<div id="Wrapper">
	
		<?php 
			// Header Featured Image ----------
			$header_style = '';
			
			// Image -----
			if( mfn_ID() && ! is_search() ){
				if( ( ( mfn_ID() == get_option( 'page_for_posts' ) ) || ( get_post_type() == 'page' ) ) && has_post_thumbnail( mfn_ID() ) ){
					
					// Pages & Blog Page ---
					$subheader_image = wp_get_attachment_image_src( get_post_thumbnail_id( mfn_ID() ), 'full' );
					$header_style .= ' style="background-image:url('. $subheader_image[0] .');"';

				} elseif( get_post_meta( mfn_ID(), 'mfn-post-header-bg', true ) ){

					// Single Post ---
					$header_style .= ' style="background-image:url('. get_post_meta( mfn_ID(), 'mfn-post-header-bg', true ) .');"';

				}
			}
			
			// Attachment -----
			if( mfn_opts_get('img-subheader-attachment') == 'fixed' ){
				$header_style .= ' class="bg-fixed"';
			} elseif( mfn_opts_get('img-subheader-attachment') == 'parallax' ){
				$header_style .= ' class="bg-parallax" data-stellar-background-ratio="0.5"';
			}
		?>
		
		<?php if( mfn_header_style( true ) == 'header-below' ) echo mfn_slider(); ?>
	
		<!-- #Header_bg -->
		<div id="Header_wrapper" <?php echo $header_style; ?>>
	
			<!-- #Header -->
			<header id="Header">
				<?php if( mfn_header_style( true ) != 'header-creative' ) get_template_part( 'includes/header', 'top-area' ); ?>	
				<?php if( mfn_header_style( true ) != 'header-below' ) echo mfn_slider(); ?>
			</header>
				
			<?php 
				if( ( mfn_opts_get('subheader') != 'all' ) && ! get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ){
					
					if( is_search() ){
						// Page title -------------------------
						
						echo '<div id="Subheader">';
							echo '<div class="container">';
								echo '<div class="column one">';
								
									global $wp_query;
									$total_results = $wp_query->found_posts;
									
									$translate['search-results'] = mfn_opts_get('translate') ? mfn_opts_get('translate-search-results','results found for:') : __('results found for:','betheme');								
									echo '<h1 class="title">'. $total_results .' '. $translate['search-results'] .' '. get_search_query() .'</h1>';
									
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
					} elseif( ! mfn_slider() || mfn_opts_get( 'subheader-slider-show' ) ){
						// Page title -------------------------
						
						// Subheader | Options
						$subheader_options = mfn_opts_get( 'subheader' );

						if( is_array( $subheader_options ) && isset( $subheader_options['hide-subheader'] ) ){
							$subheader_show = false;
						} elseif( get_post_meta( mfn_ID(), 'mfn-post-hide-title', true ) ){
							$subheader_show = false;
						} else {
							$subheader_show = true;
						}
						
						if( is_array( $subheader_options ) && isset( $subheader_options['hide-breadcrumbs'] ) ){
							$breadcrumbs_show = false;
						} else {
							$breadcrumbs_show = true;
						}
						
						if( is_array( $subheader_options ) && isset( $subheader_options['breadcrumbs-link'] ) ){
							$breadcrumbs_link = 'has-link';
						} else {
							$breadcrumbs_link = 'no-link';
						}
						
						// Subheader | Print
						if( $subheader_show ){
							echo '<div id="Subheader">';
								echo '<div class="container">';
									echo '<div class="column one">';
										
										// Title
										echo '<h1 class="title">'. mfn_page_title() .'</h1>';
										
										// Breadcrumbs
										if( $breadcrumbs_show ) mfn_breadcrumbs( $breadcrumbs_link );
										
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
						
					}
					
				}
			?>
		
		</div>
		
		<?php do_action( 'mfn_hook_content_before' ); ?>