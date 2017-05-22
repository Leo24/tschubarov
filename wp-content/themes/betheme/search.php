<?php
/**
 * The search template file.
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

get_header();

$translate['published'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-published','Published by') : __('Published by','betheme');
$translate['at'] 			= mfn_opts_get('translate') ? mfn_opts_get('translate-at','at') : __('at','betheme');
$translate['readmore'] 		= mfn_opts_get('translate') ? mfn_opts_get('translate-readmore','Read more') : __('Read more','betheme');
?>

<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group" style="width:100% !important;">
		
			<div class="section">
				<div class="section_wrapper clearfix">
				
					<div class="column one column_blog">	
						<div class="blog_wrapper isotope_wrapper">
			
							<div class="posts_group classic">
								<?php
									while ( have_posts() ):
										the_post();
										?>
										<div id="post-<?php the_ID(); ?>" <?php post_class( array('post-item', 'clearfix', 'no-img') ); ?>>
											
											<div class="post-desc-wrapper">
												<div class="post-desc">
												
													<?php if( mfn_opts_get( 'blog-meta' ) ): ?>
														<div class="post-meta clearfix">
															<div class="author-date">
																<span class="author"><span><?php echo $translate['published']; ?> </span><i class="icon-user"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta( 'display_name' ); ?></a></span>
																<span class="date"><span><?php echo $translate['at']; ?> </span><i class="icon-clock"></i> <?php echo get_the_date(); ?></span>
															</div>
														</div>
													<?php  endif; ?>
													
												
													<div class="post-title">
														<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													</div>
													
													<div class="post-excerpt">
														<?php the_excerpt(); ?>
													</div>
	
													<div class="post-footer">
														<div class="post-links">
															<i class="icon-doc-text"></i> <a href="<?php the_permalink(); ?>" class="post-more"><?php echo $translate['readmore']; ?></a>
														</div>
													</div>
						
												</div>
											</div>
										</div>
										<?php
									endwhile;
								?>
							</div>
					
							<?php	
								// pagination
								if(function_exists( 'mfn_pagination' )):
									echo mfn_pagination();
								else:
									?>
										<div class="nav-next"><?php next_posts_link(__('&larr; Older Entries', 'betheme')) ?></div>
										<div class="nav-previous"><?php previous_posts_link(__('Newer Entries &rarr;', 'betheme')) ?></div>
									<?php
								endif;
							?>
					
						</div>
					</div>
					
				</div>
			</div>
			
		</div>

	</div>
</div>

<?php get_footer(); ?>