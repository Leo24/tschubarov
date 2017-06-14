<?php
/**
Template Name: Fiverr Form
 */
acf_form_head();
get_header(); 
?>

<!-- #Content -->
<div id="Content">
	<div class="content_wrapper clearfix">

		<!-- .sections_group -->
		<div class="sections_group">

			<div class="entry-content" itemprop="mainContentOfPage">
				<?php 
					while ( have_posts() ){
						the_post();							// Post Loop
						if (function_exists('mfn_builder_print')) mfn_builder_print( get_the_ID() );	// Content Builder & WordPress Editor Content
					}
				?>
<?php 

      		do_action('fifo_filter_form_fields');

      		
      		global $current_form;
          //var_dump($current_form);
          echo '<div class="container"><div class="two-third column" style="float:none; margin:0 auto;">';
          
      		if (isset($_GET['updated'])) {
				echo '<script>
    			    window.location = "http://goo.gl/Jq0A3G";
				</script>';
      		} elseif (!empty($_GET['fiverr_form'])) {
        		
        		$title = (isset($current_form) && !empty($current_form['title'])) ? '['.current_time( 'mysql' ).'] '.$current_form['title'] : current_time( 'mysql' );

				$field_group = 'group_561537f9400b6';
				if ($_GET['fiverr_form'] == 'kw') {
					$field_group = 'group_58a70519f2586';
				};

        		$options = array(
          		'post_id' => 'new_post',
          		'new_post' => array(
            		  'post_type'		=> 'fiverr_order',
            		  'post_title'  => $title,
  						    'post_status'		=> 'publish'
          		  ),
          		'field_groups' => array($field_group),
          		'submit_value'		=> 'Send Order'
        		);
        		echo '<h2>'.$current_form['title'].'</h2><p>'.$current_form['description'].'</p>';
        		
        		  $forms = get_field('forms','options');
  
              //var_dump($forms);
              
              $is_form = false;
              
              foreach ($forms as $form) {
              
               if ($form['form_name'] === $_GET['fiverr_form']) {
                 $is_form = true;
                 break;
               }
              
              }

              if ($is_form) 
                acf_form( $options ); 
              else echo '<h2>There is nothing to view</h2>';  
                
      		
      		} else {
        		echo '<h2>There is nothing to view</h2>';
      		}
				get_sidebar('fiverr');

				echo '</div></div>';
        ?>
				
			</div>
			
			<?php if (function_exists('mfn_opts_get')) { if( mfn_opts_get('page-comments') ): ?>
				<div class="section section-page-comments">
					<div class="section_wrapper clearfix">
					
						<div class="column one comments">
							<?php comments_template( '', true ); ?>
						</div>
						
					</div>
				</div>
			<?php endif; } ?>

		</div>
		
		<!-- .four-columns - sidebar -->
<!--		--><?php //get_sidebar('fiverr'); ?>

	</div>
</div>

<!--Start of Zendesk Chat Script-->
<script type="text/javascript">
	window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
	_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
		$.src="https://v2.zopim.com/?4MoVedGBe76Xq58e6ll358yMqhDVByEG";z.t=+new Date;$.
			type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zendesk Chat Script-->

<?php get_footer(); ?>

