<?php 

$users = get_users(array('role' => 'contributor'));
$forms = get_field('forms','options');

$in_progress_orders = fifo_get_orders(array('order_status' => 'In Progress'));
$assigned_orders = fifo_get_orders(array('order_status' => 'Assigned'));
$urgent_orders = fifo_get_orders(array('order_status' => 'Urgent'));
$rejected_orders = fifo_get_orders(array('order_status' => 'Rejected'));

?>
<div class="wrap">
  <h1>Fiverr Orders Queue</h1>
  <form action="" method="get" id="">
  <div class="filters">
      <input type="hidden" name="page" value="manage-orders" />
      <label for="">Filters: </label>
		  <select name="gig" id="filter-by-gig">
  		  <option value="all-gigs">All Gigs</option>
      <?php 
          
        foreach ($forms as $form) {
          $selected = (!empty($_GET['gig']) && $_GET['gig']===$form['form_name']) ? 'selected="selected"' : '';
          echo '<option value="'.$form['form_name'].'" '.$selected.'>'.$form['title'].'</option>';
        
        }
        
      ?>
      </select> 
<!--   		<label for="fuser" class="">User:</label> -->
  		<select name="fuser" id="" >
        <option value="-1">All Users</option>
        <?php 
          foreach ($users as $suser) {
            $selected = ($suser->ID === intval($_GET['fuser'])) ? ' selected="seleted"' : '';
            echo '<option value="'.$suser->ID.'" '.$selected.'>'.$suser->display_name.'</option>';
          }
        ?>
      </select>  
      <input type="submit" value="Filter" class="button button-primary" />    
  </div>
  </form>
  <div class="manage_orders">  
    <div class="ocol " id="in-progress">
    <?php 
      if (!empty($in_progress_orders)) {
        echo '<div class="td title">In Progress</div>';
        
        fifo_render_orders($in_progress_orders);       
      }
      ?>
      </div>
    <div class="ocol " id="assigned">  
    <?php
      if (!empty($assigned_orders)) {
        echo '<div class="td title">Assigned</div>';
        
        fifo_render_orders($assigned_orders);            
      }      
    ?>  
    </div>
    <div class="ocol " id="urgent">
      <div class="td title">Urgent</div>  
    <?php
      if (!empty($urgent_orders)) {
        
        fifo_render_orders($urgent_orders);            
      }      
    ?>  
    </div>
    <div class="ocol " id="rejected">  
      <div class="td title">Rejected</div>
    <?php
      if (!empty($rejected_orders)) {
        
        fifo_render_orders($rejected_orders);            
      }      
    ?>  
    </div>        
    
    
    <div class="clear"></div>
  </div> 
</div>
