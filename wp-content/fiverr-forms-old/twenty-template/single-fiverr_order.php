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

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
  	if (is_user_logged_in()) {	
  		// Start the loop.
  		while ( have_posts() ) : the_post(); ?>
  
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'twentyfifteen' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
        $post_id = get_the_id();

  			$author_id = get_post_field( 'post_author', $post_id );
        $sterms = wp_get_post_terms($post_id, 'status'); 
        $status_class = (!empty($sterms)) ? sanitize_title($sterms[0]->name) : 'new' ;
        $author_data = get_userdata( $author_id );
        
        echo '<strong>Created</strong>: '.get_post_meta($post_id, 'form_created', true).'<br />';
        
        echo '<strong>Assigned to</strong>: '.$author_data->display_name.'<br />';
        
        if ( ! empty( $sterms ) && ! is_wp_error( $sterms ) ) {
          foreach ($sterms as $status) {
            echo '<strong>Status</strong>: '.$status->name.'<br />';
          }
        }
        
        echo '<strong>Gig</strong>: '.get_post_meta($post_id, 'form_title', true).'<br />';
        
        echo '<strong>Fiverr order ID</strong>: '.get_field('order_number', $post_id).'<br />';
        echo '<strong>Fiverr username</strong>: '.get_field('fiverr_username', $post_id).'<br />';
        
        $sites = get_field('site_url', $sid);
        if (!empty($sites)) {
          echo '<strong>Sites</strong><br />';  
          foreach ($sites as $site) {
            echo '<a href="'.$site['url'].'">'.$site['url']."</a><br />\n";
          }
          
          echo '<br />';
        
        }
        
        $keywords = get_field('keywords', $sid);  
        if (!empty($keywords)) {
          echo '<strong>Keywords:</strong><br />';
          foreach ($keywords as $keyword) {
            //echo $keyword['keyword']."<br />\n";
            echo maybe_divide_keywords($keyword['keyword']);
          }
          
          echo '<br />';
        }
        
        function maybe_divide_keywords($keyword) {
          if (strpos($keyword, ',') !== false) {
            $keyw = explode(',', $keyword);
            $result = '';
            foreach ($keyw as $key) {
              $result .= trim($key)."<br />\n";
            } 
            
            return $result;
            
          } else return $keyword."<br />\n";
        }        
        
         $fields = get_field_objects($sid);
         
         foreach ($fields as $key => $field) {
           if (strpos($key, 'hide_') !== false) continue;
           
           if (in_array($key, array('site_url', 'keywords', 'fiverr_username', 'order_number')) === false ) {
             //var_dump($field);
            if ($field['type']==='textarea' && !empty($field['value'])) {
               echo '<strong>'.$field['label'].'</strong>:<br />';
               $lines = explode("\n",$field['value']);
               foreach ($lines as $line) {
                 echo $line."<br />\n";
               }
            } elseif (is_string($field['value']) && !empty($field['value']) && $field['value']!=='none' ) {
               echo '<strong>'.$field['label'].'</strong>:<br /> '.$field['value']."<br />\n";
            }
             
             if ($field['type']==='select' && is_array($field['value']) ) {
               echo '<strong>'.$field['label'].'</strong>:<br /> ';
               foreach ($field['value'] as $fv) {
                 echo $fv.'<br />';
               }
             }

             if ($field['type']==='true_false' && !empty($field['value'])) {
               echo '<strong>'.$field['label'].'</strong>:<br /> ';
               if ($field['value'] === true) echo 'Yes<br />';
               else echo 'No<br />';
             }           
             
             if ($field['type']==='checkbox' && !empty($field['value'])) {
                 echo '<strong>'.$field['label'].'</strong>:<br /> ';
                 $f = $field['value'];
                 foreach ($f as $val) {
                   echo $field['choices'][$val]."<br />\n";
                 } 
             }
             
             echo '<br />';
             
           }
           
         }        
        
        echo '<br />';
        
        $options = array(
          'field_groups' => array('group_5626a45164cd7'),
          'submit_value'		=> 'Update Order'
        );
        
        acf_form( $options ); 
        
		?>
		
		<div class="fiverr_report">
		  <input type="button" class="button button-primary" value="Make Report" id="make-report" data-pid="<?php the_id(); ?>" />
		  <span class="spinner"></span>
		  <a href="" class="dl_rep">Download report</a>
		</div>
		
	</div><!-- .entry-content -->
</article><!-- #post-## -->
<?php  
  			// If comments are open or we have at least one comment, load up the comment template.
  			if ( comments_open() || get_comments_number() ) :
  				comments_template();
  			endif;
  
  		// End the loop.
  		endwhile;
		}
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
