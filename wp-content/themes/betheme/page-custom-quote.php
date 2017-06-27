<?php
/**
 * Template Name: Page For Custom Quote
 * @package WordPress
 *
 */

get_header();
?>

<link href="<?php echo get_template_directory_uri().'/css/custom-quote-page/style.css';?>" rel="stylesheet">


<!-- #Content -->
<div id="Content">
    <div class="content_wrapper clearfix">

        <!-- .sections_group -->
        <div class="sections_group">

            <div class="entry-content" itemprop="mainContentOfPage">

                <div class="container">
                    <div class="three-fourth column" style="float:none; margin:0 auto;">

                        <h2><?php echo the_title();?></h2>

						<?php echo do_shortcode('[gravityform id=1 title=false description=true ajax=true tabindex=49]');?>

                        <div class="prom-message">
                            <p>*Information provided is strictly confidential and we never share your information.</p>
                        </div>

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
