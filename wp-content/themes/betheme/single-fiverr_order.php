<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
if (is_user_logged_in() === false) wp_redirect(get_bloginfo('url'));
acf_form_head();
get_header(); ?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">
			<?php 
				while ( have_posts() ){
					the_post();	
					get_template_part( 'includes/content', 'single-fiverr_order' );
					
				}
			?>
		</div>
		
		<!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>
			
	</div>
</div>

<?php get_footer(); ?>