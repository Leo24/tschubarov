<?php
/**
 * Template Name: Page SEO Package subscription
 * @package WordPress
 *
 */

get_header();
?>

    <!-- #Content -->
    <div id="Content">
        <div class="content_wrapper clearfix">

            <!-- .sections_group -->
            <div class="sections_group">

                <div class="entry-content" itemprop="mainContentOfPage">

                    <div class="container">
                        <div class="two-third column" style="float:none; margin:0 auto;">

                            <h2><?php echo the_title();?></h2>

	                        <?php echo do_shortcode('[contact-form-7 id="135822" title="Contact form for Seo Reports" html_class="use-floating-validation-tip"]');?>


                        </div>

                    </div>


                </div>

            </div>


        </div>

        <!-- .four-columns - sidebar -->
		<?php get_sidebar(); ?>

    </div>
    </div>

<?php get_footer(); ?>