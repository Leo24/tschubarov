<div class="wrap">
  <h1>Choose form to create manual order</h1>
  <table class="wp-list-table widefat striped add-order">
   <tbody>
     
<?php 

$forms = get_field('forms','options');

foreach ($forms as $form) {
  //  /fiverr-forms/?
  echo '<tr><td><h3>'.$form['title'].'</h3> <a href="'.get_bloginfo('url').'/fiverr/?manual=manual&fiverr_form='.$form['form_name'].'" class="button button-primary" target="_blank">Create Order</a></td></tr>';
}

?> 
   </tbody> 
  </table>
</div>