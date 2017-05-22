<?php 
 
  if ( !function_exists( 'add_action' ) ) {
  	die; // doesn't allow to run directly
  }
   
  $user_id = get_current_user_id(); 

  if ( (int) $user_id < 1 ) die; // doesn't allow to run not logged users
  
  
  if (!empty($_GET['id'])) {
    include_once('single-report.php');
  } else {
  
  // I didn't use function which checks user premissions because workers has minimun permissions either as a subscriber.
  
  $posts_per_page = empty($_GET['orders_per_page']) ? 12 : $_GET['orders_per_page']; 
  
  $report = '';
  
  if (isset($_POST['force_restart'])) {
    fifo_force_restart();
  }
  
  if (isset($_POST['bl_bulk_action'])) {
    if ($_POST['bl_action']==='delete') {
      $to_delete = $_POST['pp'];
      if (!empty($to_delete)) {
        foreach ($to_delete as $sid) {
          $post_type = get_post_type($sid);
          $status = get_post_meta($sid, 'status', true);
          if ($post_type === 'backlinks' && $status !== 'Running') {
            
            //delete files before delete post;
            $files_to_del = get_post_meta($sid, 'backlink_files', true);
            //var_dump($files_to_del);
            if (!empty($files_to_del)) {
              foreach ($files_to_del as $name => $file) {
                //var_dump(FIFO_PATH.'/backlinks-checker/to_check/'.$name);
                //var_dump(FIFO_PATH.'/backlinks-checker/checked_or/'.$name);
                if (file_exists(FIFO_PATH.'/backlinks-checker/to_check/'.$name)) 
                  @unlink(FIFO_PATH.'/backlinks-checker/to_check/'.$name);  
                if (file_exists(FIFO_PATH.'/backlinks-checker/checked_or/'.$name)) 
                  @unlink(FIFO_PATH.'/backlinks-checker/checked_or/'.$name);
              }
              
              @rmdir(FIFO_PATH.'/backlinks-checker/to_check/'.$sid);
              @rmdir(FIFO_PATH.'/backlinks-checker/checked_or/'.$sid);
              
              if (file_exists(FIFO_PATH.'/backlinks-checker/checked_good/'.$sid.'_good_backlinks.zip')) 
                @unlink(FIFO_PATH.'/backlinks-checker/checked_good/'.$sid.'_good_backlinks.zip');  
            }
            
            //delete post;
            wp_delete_post($sid, true);
            
            //remove from queue
            $queue = get_option('backlinks_checker_queue');
            unset($queue[$sid]);
            update_option('backlinks_checker_queue', $queue);
            
          } else {
            $report .= 'Report with ID='.$sid.' can\'t be deleted because its on cheking right now. <br />';
          }
        }
      }
       
    }
  }
  
?>
<div class="wrap">
  <h1>Backlinks Checker</h1>
  <div id="ftabs">
    <div class="tabbers">
      <div class="stab active" data-tab="tab1">Files</div>
      <div class="stab" data-tab="tab2">Direct Input</div>
      <div class="clear"></div>
    </div>
    <div class="tab tab1 active">
      <h2>Create task from files  (only 99 files allowed per task)</h2>
      <form action="<?php echo admin_url('/admin.php?page=backlinks-checker'); ?>" class="dropzone" id="backlinks-files" method="post">
        <div class="fallback">
          <input type="file" name="file[]" multiple="multiple" />
          <input type="submit" value="Create Task" id="submit-all-no-js" class="button button-primary" />
        </div>
        <input type="hidden" name="bulk_upload" value="<?php echo time(); ?>" />
      </form>
      <input type="submit" value="Create Task" id="submit-all" class="button button-primary disabled" />
    </div>
    <div class="tab tab2">
      <h2>Direct input backlinks</h2>
      <form action="<?php echo admin_url('/admin.php?page=backlinks-checker'); ?>" method="post">
        <label for="">Paste links into the textarea, one link per line, please</label><br />
        <textarea name="fbacklinks" id="fifo_backlinks" cols="60" rows="10"></textarea><br />
        <input class="button button-primary" type="submit" name="fifo_check_links" value="Check Links" />
      </form>
    </div>
  </div>
  
  <br />  
  <h1 class="m0">Backlinks Reports:</h1>
  <span><?php echo $report; ?></span>
<?php 
  $qu = get_option('backlinks_checker_queue');
  if (!empty($qu)) echo  'Queue to check: ',implode(', ', $qu);
  
  $args =  array (
    'post_type' => 'backlinks',
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
      'post_type' => 'backlinks',
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
  <table id="backlink-tasks" class="wp-list-table widefat striped display" style="width:100%">
    <thead>
      <tr>
        <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
        <th>ID</th>
        <th>Status</th>
        <th>Created</th>
        <th>Download</th>
        <th style="width:50%;">Backlinks</th>    
      </tr>
    </thead>
    <tbody id="the-list">
    <?php foreach ($pids as $pid) {
        $check_status = get_post_meta($pid, 'status', true);
    ?>
    <tr class="backlink-task <?php if($check_status !== 'Completed'): ?>in-process<?php endif; ?>" data-id="<?php echo $pid ?>">
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
          echo '<span class="bl_'.$check_status.'">'.$check_status.'</span>';
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
      <td class="blinks-download">
      <?php 
      // download path
      $dl = get_post_meta($pid, 'zip_backlinks', true);
      if (!empty($dl)) {
        echo '<a href="'.$dl.'" class="button button-primary">Download Zip</a>';
      }
        
        
      ?>
      </td>
      <td>
        <div class="blinks-view">   
          <?php 
            $backlinks_info = get_post_meta($pid, 'backlink_files_info', true);
            //var_dump($backlinks_info);
            if (!empty($backlinks_info)) { 
              
              $files_info = $backlinks_info['files'];
              $total_count = 0;
              $files_count = count($files_info);
          
          ?>
          <span class="">
            <a href="<?php echo admin_url('admin.php?page=backlinks-checker&id='.$pid); ?>" class="bl_details">View Report</a>
          <br /> 
          Files to check: <?php echo $files_count; ?> files
          <?php  

            if (!empty($files_info)) {
              echo '<ul>';
              foreach($files_info as $fname => $res) { 
                $total_count += count($files_info[$fname]['urls']);
                $fstatus = $files_info[$fname]['status'];

                $count_bad = 0;
                foreach ($res['urls'] as $url => $url_report) {
                  if(!empty($url_report['response']) && (int)$url_report['response']!=200) {
                    $count_bad++;
                  }
                }
              ?>
                  <li data-file="<?php echo $fname ?>">
                    <span class="status <?php if($fstatus['checked']==='checked' || $check_status === 'Done'): ?>bl_ok<?php else: ?>bl_queue<?php endif; ?>">&#x25cf;</span>
                    <strong><?php echo str_replace($pid.DIRECTORY_SEPARATOR, '', $fname) ?></strong>: <strong><span class="amount"><?php echo $files_info[$fname]['status']['amount']; ?> urls <?php if($count_bad>0): ?>(<?php echo $count_bad ?> have errors)<?php endif; ?></span></strong>
                  </li>
              <?php }
              echo '</ul>';
            }
          ?>
          </span>
          <br />
          <?php echo 'Total Urls: '.$total_count;  }?> 
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
        <th>Download</th>        
        <th style="width:50%;">Backlinks</th>     
      </tr>
    </tfoot>
  </table>
  <div class="bottom-info">

  </div>    
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
</div>

<?php } // end else === view backlinks multiple queue