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
        		echo $current_form['thank_you_message'];
      		} elseif (!empty($_GET['fiverr_form'])) {
        		
        		$title = (isset($current_form) && !empty($current_form['title'])) ? '['.current_time( 'mysql' ).'] '.$current_form['title'] : current_time( 'mysql' );
      		
        		$options = array(
          		'post_id' => 'new_post',
          		'new_post' => array(
            		  'post_type'		=> 'fiverr_order',
            		  'post_title'  => $title,
  						    'post_status'		=> 'publish'
          		  ),
          		'field_groups' => array('group_561537f9400b6'),  
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
		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>

