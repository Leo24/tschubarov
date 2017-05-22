<?php 
  
if (isset($_POST['bulk_action']))  {
  fifo_bulk_action();
} 

$posts_per_page = empty($_GET['orders_per_page']) ? 12 : $_GET['orders_per_page']; 

$get_status = empty($_GET['status']) ? 'In Progress' : $_GET['status']; 

$get_gig = empty($_GET['gig']) ? 'all-gigs' : $_GET['gig']; 

$args = array (
  'post_type' => 'fiverr_order',
  'post_status' => 'publish',
  'orderby' => 'ID',
  'order' => 'DESC',
  'posts_per_page' => $posts_per_page,
  'paged' => isset($_GET['paged']) ? $_GET['paged'] : 1,
  'cache_results' => false,
  'fields' => 'ids'
);

$all_args =  array (
    'post_type' => 'fiverr_order',
    'post_status' => 'publish',
    'orderby' => 'ID',
    'order' => 'DESC',
    'posts_per_page' => -1,
    'cache_results' => false,
    'fields' => 'ids'
);

if (!empty($_GET['fuser']) && intval($_GET['fuser']) >= 0) {
  $args['author'] = $_GET['fuser'];
  $all_args['author'] = $_GET['fuser'];
}

if ($get_status !== 'none') {
  $status_filter = array(
      'taxonomy' => 'status',
			'field'    => 'name',
			'terms'    => $get_status,
  ); 
  
  $args['tax_query'][] = $status_filter;
  $all_args['tax_query'][] = $status_filter;
}

if ($get_gig !== 'all-gigs') {
  $gig_filter = array(
      'key'     => 'form_id',
			'value'   => $get_gig,
			'compare' => '=',
  ); 
  
  $args['meta_query'][] = $gig_filter;
  $all_args['meta_query'][] = $gig_filter;
}

if (!empty($_GET['order_id'])) {
  $id_filter = array(
      'key'     => 'order_number',
			'value'   => $_GET['order_id'],
			'compare' => 'RLIKE',
  ); 
  
  $args['meta_query'][] = $id_filter;
  $all_args['meta_query'][] = $id_filter;  
}

if (isset($_GET['purls'])) {
  $args['meta_key'] = 'registrations';
  $all_args['meta_key'] = 'registrations';
}

if (isset($_GET['furls'])) {
  $all_args['meta_query'] = $args['meta_query'] = array(
    array(
			'key'  => 'registrations',
		),
/*
    array(
			'key'  => 'backlinks',
		),
*/		
  );
}


$the_query = new WP_Query( $args);



$all_orders = get_posts( $all_args );

if (!empty($all_orders)) {
 $count_orders = count($all_orders);
 $total_pages = ceil($count_orders/$posts_per_page);
}
 
 
//var_dump($pids);
 
$user_id = get_current_user_id(); 
$statuses = get_terms( 'status', array('orderby' => 'id', 'order' => 'ASC','hide_empty' => false));

$users = get_users(array('role' => 'contributor'));

$forms = get_field('forms','options');

 //var_dump($_SERVER["REQUEST_URI"]);
 ?>
<div class="wrap"> 
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.css">
  
  <div class="fifo-shadow"></div>
  <div class="fifo-popup-single">
    <div class="fwrap">
      <h2>Do you really want to change status to "Urgent" ?</h2>
      <p>It will set deadline to 12 hours from order create time</p>
      <div class="bwrap">
        <a href="#" class="button button-primary yes">Yes</a> <a href="#" class="button no">No</a>
      </div>
    </div>
  </div>

  <div class="fifo-popup-bulk">
    <div class="fwrap">
      <h2>Do you really want to change status to "Urgent" ?</h2>
      <p>It will set deadline to 12 hours from order create time for all selected tasks</p>
      <div class="bwrap">
        <a href="#" class="button button-primary yes">Yes</a> <a href="#" class="button no">No</a>
      </div>
    </div>
  </div>  
  
  <h1>Manage Fiverr Orders</h1>
<!--  Author, Status, Form Name, Order #, Fiverr Name, Site Url, Keywords, Other Information -->
  <form action="" method="get" id="">
  <div class="tablenav top">
  <div class="alignleft factions">
  		<input type="hidden" name="page" value="fiverr-orders" />
		  <label for="filter-by-gig">Gig: </label>
		  <select name="gig" id="filter-by-gig">
  		  <option value="all-gigs">All Gigs</option>
      <?php 
          
        foreach ($forms as $form) {
          $selected = (!empty($_GET['gig']) && $_GET['gig']===$form['form_name']) ? 'selected="selected"' : '';
          echo '<option value="'.$form['form_name'].'" '.$selected.'>'.$form['title'].'</option>';
        
        }
        
      ?>
      </select>  
		  <label for="filter-by-status">Status: </label>
		  <select name="status" id="filter-by-status">
  		  <option value="none">All Statuses</option>
      <?php 
             
        if ( ! empty( $statuses ) && ! is_wp_error( $statuses ) ) {
          foreach ($statuses as $status) {
            if ($status->name === $get_status) {
              echo '<option value="'.$status->name.'" selected="selected">'.$status->name.'</option>';
            } else {
              echo '<option value="'.$status->name.'" >'.$status->name.'</option>';
            }
          }
        }
           
         ?>
      </select>        		
  		<label for="fuser" class="">User:</label>
  		<select name="fuser" id="" >
        <option value="-1">All Users</option>
        <?php 
          foreach ($users as $suser) {
            $selected = (isset($_GET['fuser']) && $suser->ID === intval($_GET['fuser'])) ? ' selected="seleted"' : '';
            echo '<option value="'.$suser->ID.'" '.$selected.'>'.$suser->display_name.'</option>';
          }
        ?>
      </select>
		  <label for="orders_per_page" class="">Per Page:</label>
		  <input type="number" step="1" min="1" max="999" class="screen-per-page" name="orders_per_page" id="edit_page_per_page" maxlength="3" value="<?php echo $posts_per_page; ?>">
		  <label for="order_id">Order ID: </label>
		  <input type="text" name="order_id" value="<?php if (isset($_GET['order_id'])) echo $_GET['order_id']; ?>" />    
		  <input type="submit" name="" id="post-query-submit" class="button" value="Apply Filter">
  </div>    
  <?php   
    fifo_pagination(
     array(
       'position' => 'bottom',
       'total_items' => $count_orders,
       'total_pages' => $total_pages,
     )
    );
     ?>
   </div>
   </form>
   <form action="" method="post" id="fifo_orders">
   <div class="bulk-actions top">
     <hr />
    <?php if ( current_user_can('manage_options') ) { ?>
    <label for="assign-to-user">Assign task to: </label>
    <select name="assign-to-user" id="" >
        <option value="none">Select User</option>
        <option value="-1">No User</option>
        <?php 
          foreach ($users as $suser) {
            $selected = (isset($_GET['fuser']) && $suser->ID === intval($_GET['fuser'])) ? ' selected="seleted"' : '';
            echo '<option value="'.$suser->ID.'" '.$selected.'>'.$suser->display_name.'</option>';
          }
        ?>
    </select>
    <?php } else { ?>
    <label for="assign-to-user">Assign task to: </label>
    <select name="assign-to-user" id="" >
        <option value="none">Select User</option>
        <?php 
          $curr_user_id = get_current_user_id(); 
          $curr_user = get_userdata ( $curr_user_id );
          echo '<option value="'.$curr_user->ID.'" >'.$curr_user->display_name.'</option>';
        ?>
    </select>    
    <?php } ?>
	  <label for="bulk-status">Change Status: </label>
	  <select name="bulk-status" id="bulk-status">
		  <option value="none">Select Status</option>
    <?php 
           
      if ( ! empty( $statuses ) && ! is_wp_error( $statuses ) ) {
        foreach ($statuses as $status) {
          echo '<option value="'.$status->name.'" >'.$status->name.'</option>';
        }
      }
         
       ?>
    </select>  
          
    <input type="submit" name="bulk_action" id="bulk-submit" class="button" value="Apply to Selected">
  </div> 
  
  <table class="wp-list-table widefat striped posts fiverr-orders display" style="width:100%">
   <thead>
     <tr>
       <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
       <th style="width:30px;">ID</th>
       <th style="width:12%;">Status</th>
       <th style="width:12%;">Assigned to</th>
       <th style="width:15%;">Form Name</th>
       <th style="width:110px;">Created</th>
       <th style="width:20%;">Form Information</th>
       <th style="width:100px;">Order #</th>
       <th style="width:10%;">Fiverr Name</th>
<!--        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="http://euromaidan.com/wp-admin/edit.php?post_type=fiverr_order&amp;orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th> -->
     </tr>
   </thead>
   <tbody id="the-list">
<?php
if ( $the_query->have_posts() ) {
    while ($the_query->have_posts()) {
        $the_query->the_post();

        $sid = get_the_ID();

        $author_id = get_post_field( 'post_author', $sid );
        $sterms = wp_get_post_terms($sid, 'status');
        $status_class = (!empty($sterms)) ? sanitize_title($sterms[0]->name) : 'new' ;
        ?>
        <tr class="tr-<?php echo $status_class; ?>">
            <th scope="row" class="check-column">
                <label class="screen-reader-text"
                       for="cb-select-<?php echo $sid; ?>"><?php echo get_post_meta($sid, 'form_title', true); ?></label>
                <input id="cb-select-<?php echo $sid; ?>" type="checkbox" name="pp[]" value="<?php echo $sid; ?>">

                <div class="locked-indicator"></div>
            </th>
            <td><?php echo $sid; ?></td>
            <td class="d-status">
                <?php
                echo '<span class="status-icon ' . $status_class . '">&#x25cf;</span> ';
                if (!empty($sterms)) {
                    echo '<span class="fifo-status">' . $sterms[0]->name . '</span>';
                } else echo '<span class="fifo-status"></span>';

                if ($sterms[0]->name !== 'Completed') {
                    echo '<br /><span class="deadline" data-deadline="' . get_field('deadline', $sid) . '"></span>';
                }
                echo '<br />Deadline: ' . date('Y-m-d H:i:s', get_field('deadline', $sid) + get_option('gmt_offset') * 60 * 60) . '<br />';

                ?>
                <div class="row-actions">
                    <span class="spinner"></span>
                    <select name="" class="order_status" data-pid="<?php echo $sid; ?>">
                        <?php
                        if (!empty($statuses) && !is_wp_error($statuses)) {
                            foreach ($statuses as $status) {
                                if ($status->name === 'In progress' && empty($sterms)) {
                                    echo '<option value="In progress" selected="selected">In progress</option>';
                                } elseif ($status->name === $sterms[0]->name) {
                                    echo '<option value="' . $status->name . '" selected="selected">' . $status->name . '</option>';
                                } else {
                                    echo '<option value="' . $status->name . '" >' . $status->name . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </div>

            </td>
            <td>
                <?php
                $author_data = get_userdata($author_id);
                echo '<span class="assigned-user">' . $author_data->display_name . '</span>';

                if (current_user_can('manage_options')) {
                    echo '<br /><span class="assign_to">assign to</span><span class="spinner"></span>';
                    ?>
                    <select name="" id="" class="assignedto" data-pid="<?php echo $sid; ?>">
                        <option value="-1">No User</option>
                        <?php
                        foreach ($users as $suser) {
                            $selected = ($suser->ID === intval($author_id)) ? ' selected="seleted"' : '';
                            echo '<option value="' . $suser->ID . '" ' . $selected . '>' . $suser->display_name . '</option>';
                        }
                        ?>
                    </select>
                <?php
                }

                if (!current_user_can('manage_options') && current_user_can('read') && ($author_id == false || intval($author_id) <= 0)) {
                    echo '<br /><a class="assigntome new" data-pid="' . $sid . '" href="' . wp_nonce_url(admin_url('admin-ajax.php?action=assign-to-me&pid=' . $sid), 'fifo_nonce', 'fifo_nonce') . '">get this task in work</a><span class="spinner"></span>';
                }

                ?>
            </td>
            <td>
                <?php
                echo get_post_meta($sid, 'form_title', true);
                ?>
                <br /><a href="#" class="comments-dialog-open" data-pid="<?php echo $sid; ?>">View Comments (<?php echo get_comments_number(); ?>)</a>
                <div class="row-actions">
                    <a href="<?php echo get_permalink(); ?>/?edit=edit" target="_blank">Edit Order</a>
                    <br />
                    <br />
                    <a href="<?php echo get_permalink(); ?>" target="_blank">View Details</a>
                </div>
            </td>
            <td>
                <?php echo get_post_meta($sid, 'form_created', true) . "<br />\n"; ?>
            <?php 
              
              if ($sterms[0]->name === 'Completed' && isset($_GET['debug'])) {
                $last_changed = get_post_meta($sid, 'order_completed', true);
                if (empty($last_changed)){
                  $last_changed = get_post_meta($sid, 'last_changed', true);
                }
                
                if (!empty($last_changed)) {
                  echo date('Y-m-d h:i:s',$last_changed);
                }
                
              }
              
               ?>    
            </td>
            <td>
                <?php
                $sites = get_field('site_url', $sid);
                if (!empty($sites)) {
                    echo '<strong>Sites</strong><br />';
                    foreach ($sites as $site) {
                        echo '<a href="' . $site['url'] . '" target="_blank">' . $site['url'] . "</a><br />\n";
                    }

                    echo '<br />';

                }

                $keywords = get_field('keywords', $sid);
                if (!empty($keywords)) {
                    echo '<strong>Keywords</strong><br />';
                    foreach ($keywords as $keyword) {
                      //echo $keyword['keyword'] . "<br />\n";
                      echo maybe_divide_keywords($keyword['keyword']);  
                    }

                    echo '<br />';

                }               


                $fields = get_field_objects($sid);

                foreach ($fields as $key => $field) {
                    if (strpos($key, 'hide_') !== false) continue;

                    if (in_array($key, array('site_url', 'keywords', 'fiverr_username', 'order_number', 'backlinks')) === false) {

                        if (is_string($field['value']) && !empty($field['value']) && $field['value'] !== 'none') {
                            echo '<strong>' . $field['label'] . '</strong>:<br /> ' . $field['value'] . "<br />\n";
                        }

                        if ($field['type'] === 'checkbox') {
                            if (!empty($field['value'])) {
                                echo '<strong>' . $field['label'] . '</strong>:<br /> ';

                                $f = $field['value'];
                                foreach ($f as $val) {
                                    echo $field['choices'][$val] . "<br />\n";
                                }
                            }
                        }

                    }
                }
                
                
                $registrations = get_post_meta($sid,'registrations', true);
                if (!empty($registrations) && is_array($registrations)) {
                  echo "\n<br /><strong>Profiles</strong><br />\n";
                  foreach ($registrations as $account) {
                    echo '<a href="'.$account['profile_url'].'" target="_blank">'.$account['profile_url']."</a><br />\n";
                  }
                }


                ?>
            </td>
            <td><?php the_field('order_number', $sid); ?></td>
            <td><?php the_field('fiverr_username', $sid); ?></td>
        </tr>


    <?php
    }
}
   ?>
   </tbody>
   <tfoot>
     <tr>
       <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
       <th>ID</th>
       <th>Status</th>
       <th>Author</th>
       <th>Form Name</th>
       <th>Created</th>
       <th>Form Information</th>
       <th>Order #</th>
       <th>Fiverr Name</th>       
<!--        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="http://euromaidan.com/wp-admin/edit.php?post_type=fiverr_order&amp;orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th> -->
     </tr>
   </tfoot>
  </table>
  <input type="submit" name="export-csv" id="export_csv" value="Export Selected to CSV file" class="button button-primary" />
</form>		  
  <?php  ?>
  <div class="tablenav bottom">
  <?php   
    fifo_pagination(
     array(
       'position' => 'bottom',
       'total_items' => $count_orders,
       'total_pages' => $total_pages,
     )
    );
     ?>
   </div>
</div> <!-- .wrap  -->

<div id="comments-dialog" title="Show comments">
    <table class="widefat fixed striped comments wp-list-table comments-box" style="">
        <tbody id="the-comment-list" data-wp-lists="list:comment">
        </tbody>
    </table>
</div>

<div id="insert-comment-dialog" title="Add comment">
    <form id="insert-comment-form" class="wp-editor-container">
        <textarea name="comment_content" class="wp-editor-area" style="height:278px"></textarea>
    </form>
</div>