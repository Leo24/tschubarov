<?php 

  $report = '';
  $posts_per_page = empty($_GET['orders_per_page']) ? 12 : $_GET['orders_per_page']; 
  
  if (isset($_POST['bl_bulk_action'])) {
    if ($_POST['bl_action']==='delete') {
      $to_delete = $_POST['pp'];
      if (!empty($to_delete)) {
        foreach ($to_delete as $sid) {
          $post_type = get_post_type($sid);
          $status = get_post_meta($sid, 'status', true);
          //if ($post_type === 'order_report' && $status !== 'Running') {
          if (true) {  
            
            //delete files before delete post;
            $files_to_del = get_post_meta($sid, 'backlink_files_for_report', true);
            //var_dump($files_to_del);
            if (!empty($files_to_del['files'])) {
              foreach ($files_to_del['files'] as $name => $file) {
                if (file_exists(REPORT_FOLDER.$name)) 
                  @unlink(REPORT_FOLDER.$name);  
/*
                if (file_exists(REPORT_FOLDER.$name)) 
                  @unlink(REPORT_FOLDER.$name);
*/
                error_log(date('Y-m-d H:i:s')." delete file ".REPORT_FOLDER.$name.PHP_EOL, 3, FIFO_PATH.'/detele.log');  
              }
              
              @rmdir(REPORT_FOLDER.$sid);
//               @rmdir(REPORT_FOLDER.$sid);
              error_log(date('Y-m-d H:i:s')." delete folder ".REPORT_FOLDER.$sid.PHP_EOL, 3, FIFO_PATH.'/detele.log');

            }
            
            
            if (!empty($files_to_del['reports'])) {
              foreach ($files_to_del['reports'] as $about_file) {
                @unlink($about_file['zip_path']); 
                delete_post_meta($about_file['fiverr_order_id'], '_generated');
                delete_post_meta($about_file['fiverr_order_id'], 'zip_path');
                delete_post_meta($about_file['fiverr_order_id'], 'zip_url');
                error_log(date('Y-m-d H:i:s')." delete file zip ".$about_file['zip_path'].PHP_EOL, 3, FIFO_PATH.'/detele.log');
              } 
            }
            

            $bigZip_url = get_post_meta($sid, 'zip_reports', true);
            $bigZip_path = str_replace(FIFO_URL, FIFO_PATH, $bigZip_url);
            @unlink($bigZip_path); 
            error_log(date('Y-m-d H:i:s')." delete bigzip ".$bigZip_path.PHP_EOL, 3, FIFO_PATH.'/detele.log');
            
            //delete post;
            wp_delete_post($sid, true);
            
            //remove from queue
            $queue = get_option('order_report_queue');
            unset($queue[$sid]);
            update_option('order_report_queue', $queue);
            
          } else {
            $report .= 'Report with ID='.$sid.' can\'t be deleted because its on cheking right now. <br />';
          }
        }
      }
       
    }
  }  
  
   ?>
<div class="wrap">
  <h2>Add files to create report.</h2>
    <p>Files MUST be named with fiverr order ID, like FO22F7E6C644.txt</p>
    <form action="<?php echo admin_url('/admin.php?page=report-generator'); ?>" class="dropzone" id="backlinks-files" method="post">
      <div class="fallback">
        <input type="file" name="file[]" multiple="multiple" />
        <input type="submit" value="Create Task" id="submit-all-no-js" class="button button-primary" />
      </div>
      <input type="hidden" name="upload_for_report" value="<?php echo time(); ?>" />
    </form>
    <input type="submit" value="Create Task" id="submit-all" class="button button-primary disabled" />
    
    <h1>Orders Reports:</h1>
    <span><?php echo $report; ?></span>
    <?php 
    $qu = get_option('order_report_queue');
    if (!empty($qu)) echo  'Queue to generate report: ',implode(', ', $qu);
    
    $args =  array (
      'post_type' => 'order_report',
      'post_status' => 'publish',
      'orderby' => 'ID',
      'order' => 'DESC',
      'posts_per_page' => $posts_per_page,
      'paged' => isset($_GET['paged']) ? $_GET['paged'] : 1,
      'cache_results' => false,
      'fields' => 'ids'
    );
    
    $pids = get_posts($args);
    
    $all_args =  array (
        'post_type' => 'order_report',
        'post_status' => 'publish',
        'orderby' => 'ID',
        'order' => 'DESC',
        'posts_per_page' => -1,
        'cache_results' => false,
        'fields' => 'ids'
    ); 
    
    $all_orders = get_posts( $all_args );
    
    if (!empty($all_orders)) {
     $count_orders = count($all_orders);
     $total_pages = ceil($count_orders/$posts_per_page);
    }   
    
    if(!empty($pids)) {  
    ?>  
    <form action="" method="post" id="">
    <div class="top-info">
      <div class="bulk-actions top alignleft">
        <label for="bl_action"></label>
        <select name="bl_action" id="bl_action">
          <option value="none">Bulk Actions</option>
          <option value="delete">Delete</option>
        </select>
        <input type="submit" id="doaction" name="bl_bulk_action" class="button action" value="Apply">
      </div> 
      <div class="alignright">
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
    </div>
    
    <table id="report-tasks" class="wp-list-table widefat striped display" style="width:100%">
      <thead>
        <tr>
          <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
          <th>ID</th>
          <th>Status</th>
          <th>Created</th>
          <th style="width:50%;">Info</th>    
        </tr>
      </thead>
      <tbody id="the-list">
      <?php foreach ($pids as $pid) {
          $check_status = get_post_meta($pid, 'status', true);
      ?>
      <tr class="report-task <?php if($check_status !== 'Done'): ?>in-process<?php endif; ?>" data-id="<?php echo $pid ?>">
        <th scope="row" class="check-column">			
          <label class="screen-reader-text" for="cb-select-<?php echo $pid; ?>"><?php echo $pid; ?></label>
    			<input id="cb-select-<?php echo $pid; ?>" type="checkbox" name="pp[]" value="<?php echo $pid; ?>">
    			<div class="locked-indicator"></div>
    		</th>
        <td>
          <?php echo $pid; ?>
        </td>
        <td class="blinks-status">
        <?php
    
            if ($check_status === 'In Queue') {
              echo '<span class="bl_queue">In Queue</span>';
            } elseif ($check_status === 'Done') {
              echo '<span class="bl_ok">Completed</span>';
            } elseif ($check_status === 'Running') {
              echo '<span class="bl_queue">Running</span>';
            }
            
          ?>
          <br />
          <?php 
          
            $checked_at = get_post_meta($pid, 'checked_at', true);
            if (!empty($checked_at)) echo $checked_at;
          
          ?>
          <br />
        </td>
        <td>
          <?php echo get_the_time('j F Y H:i s\s', $pid); ?>
          <br />
        </td>
        <td>
          <div class="blinks-view">   
            <span class="">
            Files to check: <br />
            <span class="rep-status"><?php echo fifo_get_task_report_status($pid); ?></span>
            </span> 
            <span class="bl_view_more"><em>View All</em></span> 
            <span class="bl_close">X</span>      
          </div>
        </td> 
      </tr> 
      <?php } ?>  
      </tbody>    
      <tfoot>
        <tr>
          <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td>
          <th>ID</th>
          <th>Status</th>
          <th>Created</th>      
          <th>Info</th>     
        </tr>
      </tfoot>
    </table>
    </form>
    <?php } //end !empty pids ?>  
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
<div class="clear"></div>    
</div>
<?php 
  
  add_filter('admin_footer_text', 'fifo_remove_footer_text');
  add_filter('update_footer', 'fifo_remove_footer_text');
  
  function fifo_remove_footer_text() {
    return ;
  }