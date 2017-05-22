<?php 
  $pid = $_GET['id'];
  $ppost = get_post($pid);
?>
<div class="wrap">
  <h1>Report for backlinks cheking process</h1>
  <a href="<?php echo admin_url('admin.php?page=backlinks-checker'); ?>" class="back_to_bl"> < Back to all </a><br />
  <?php if (empty($ppost)) echo '<h1>There is no task with this ID</h1>'; else { ?>
  
  <?php 
/*
      $files_to_check = get_post_meta($pid, 'backlink_files', true); // get list of files
      $bl_checked = get_post_meta($pid, 'backlink_files_checked', true);
      $good_links = get_post_meta($pid, 'good_links', true);
      $backup = get_post_meta($pid, 'backlink_files_to_check', true); // works only for old reports
      var_dump($backup);
      update_post_meta($pid, 'backlink_files_checked', $backup);
      update_post_meta($pid, 'good_links', false);
      var_dump($files_to_check);
      var_dump($bl_checked);
      var_dump($good_links);
*/
/*
      $checker_status = get_option('run_backlinks_checker');
      var_dump($checker_status);
      update_option('run_backlinks_checker', 'stopped');
*/
      //update_post_meta($pid, 'status', 'In Queue');    
     ?>
  
  <div class="bl_report">
    Status: 
      <strong id="bl_status"><?php $check_status = get_post_meta($pid, 'status', true); 
        
        if ($check_status === 'In Queue') {
          echo '<span class="bl_queue">In Queue</span>';
        } elseif ($check_status === 'Done') {
          echo '<span class="bl_ok">Completed</span>';
        } elseif ($check_status === 'Running') {
          echo '<span class="bl_queue">Running</span>';
        }
        
      ?></strong>
      <br />
      <?php 
        if ($check_status !== 'Done') {
          //echo '<span>Information automatically updates every minute</span><br />';
        }
         ?>
      <span> Created at: </span>
      <?php echo get_the_time('j F Y H:i s\s', $pid); ?>
      <br />
      <?php 
      
        $started_at = get_post_meta($pid, 'started_at', true);
        if (!empty($started_at)) echo $started_at.'<br />';
      
        $checked_at = get_post_meta($pid, 'checked_at', true);
        if (!empty($checked_at)) echo $checked_at.'<br />';
      
      ?>
      <br />
      <div class="" id="prg_status"></div>
      <?php                 
        $report = fifo_backlinks_report($pid);
        
        if (!empty($report)) {  
          
      ?>
<!--
      <a href="#all" class="localinks">All</a>
      <a href="#good" class="localinks">Good Backlinks</a>
      <a href="#bad" class="localinks">Bad Backlinks</a>
-->
      <h3>All Backlinks: </h3>  
        <div id="blinks-view">   
        <?php 
         //var_dump($report);
         echo implode('', $report['all']);
          
          //print_r($blinks);
        ?>      
        </div> 
        <?php if ($check_status !== 'In Queue') { ?> 
        <h3>Good Backlinks: </h3>
        <div id="good-links">
        <?php echo implode('', $report['good']); ?>  
        </div>
        <h3>Bad Backlinks: </h3>
        <div id="bad-links">
        <?php echo implode('', $report['bad']); ?>  
        </div>
        <?php } // end if $check_status !== 'In Queue' ?>
      <?php } ?>                
  </div>
  <br />
  <a href="<?php echo admin_url('admin.php?page=backlinks-checker'); ?>" class="back_to_bl"> < Back to all </a>
    <?php } ?>
</div>  

<?php   
