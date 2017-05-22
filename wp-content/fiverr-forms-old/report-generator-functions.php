<?php 

define('REPORT_FOLDER', FIFO_PATH.DIRECTORY_SEPARATOR.'for_reports'.DIRECTORY_SEPARATOR);
define('SERVERUSER', 'youngcaesar');

if (!is_dir(REPORT_FOLDER)) {
  $st = mkdir(REPORT_FOLDER, 0755, true);
}
  
  // Register Custom Post Type
function add_post_type_report_generator() {

	$args = array(
		'label'               => __( 'Post Type', 'fifo' ),
		'description'         => __( 'Order report', 'fifo' ),
		'supports'            => array( 'title', 'custom-fields', ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => false,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => false,
		'can_export'          => false,
		'has_archive'         => false,		
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'rewrite'             => false,
		'capability_type'     => 'post',
	);
	register_post_type( 'order_report', $args );

}
add_action( 'init', 'add_post_type_report_generator', 0 );  

if (!empty($_POST['upload_for_report'])) {
  
  add_action('init', 'fifo_manage_files_for_report');

}

function fifo_manage_files_for_report() {
  
  if (!empty($_FILES) && !empty($_POST['upload_for_report'])) {
    $check_files = array();
    $file_ary = reArrayFiles($_FILES['file']);    
    
    file_put_contents(FIFO_PATH.'/report-generator.log', ''); //cleanup log file
    
      foreach ($file_ary as $file) {
                                     
        $target_file =  REPORT_FOLDER. $file['name']; 
        
        if (strpos($file['name'], 'php') === false && strpos($file['name'], '.txt') !== false) {    
          $status = move_uploaded_file($file['tmp_name'],$target_file); 
          
          chown($target_file, SERVERUSER);
          
          if ($status === true) {
            $check_files[$file['name']] = $target_file;
          } else {
            error_log(date('Y-m-d H:i:s')." Can't save uploaded file to $target_file".PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
          }         
        }           
      }
      
      if (!empty($check_files)) {
        fifo_create_new_task_for_making_report($check_files);
      }
      
  }
}

function fifo_create_new_task_for_making_report($files = null) {
  $post_args = array(
    'post_title'     => current_time( 'mysql' ),
    'post_status'    => 'publish',
    'post_type'      => 'order_report'  
  );  
  
  $post_id = wp_insert_post($post_args);
  
  file_put_contents(FIFO_PATH.'/pr-check.log', '');
  
  if (!empty($files)) {
    
    $new_names = $empty_statuses = array();

    if (!is_dir(REPORT_FOLDER.$post_id)) {
      $st = mkdir(REPORT_FOLDER.$post_id, 0755, true);
      chown(REPORT_FOLDER.$post_id, SERVERUSER);
    }
    
    foreach ($files as $name => $sfile) { // $sfile = abs path to file, $name = only filename
      $new_name = $post_id.DIRECTORY_SEPARATOR.$name; 
      $new_location = REPORT_FOLDER.$new_name;
      
      $status = rename($sfile, $new_location); // maybe also use chown
      if ($status === true) {
        $new_names[$new_name] = $new_location; 
        $empty_statuses[$name] = array('html' => $name.' - <span class="bl_queue">in Queue</span>');       
      } else {
        error_log(date('Y-m-d H:i:s')." Can't move file from $sfile to $new_location".PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
      }
      
    }
    
    //error_log(date('Y-m-d H:i:s').' postid ='.$post_id.'  '.var_export(array('files' => $new_names, 'reports' => $empty_statuses),1).PHP_EOL, 3, FIFO_PATH.'/report-generator.log');

    update_post_meta($post_id, 'backlink_files_for_report', array('files' => $new_names, 'reports' => $empty_statuses));
    update_post_meta($post_id, 'status', 'In Queue');
    $queue = get_option('order_report_queue');  
    $queue[$post_id] = $post_id;  
    update_option('order_report_queue', $queue);  
    
    fifo_generate_reports($post_id);
      
  }
  
}

function fifo_generate_reports($pid = null) {
  if (empty($pid)) return;
    
  update_post_meta($pid, 'status', 'Running');
  
  update_post_meta($pid, 'started_at', 'Started at: '.current_time('j F Y H:i s\s'));
  
  $files_for_report = get_post_meta($pid, 'backlink_files_for_report', true);
  
  //error_log(date('Y-m-d H:i:s')." started ".PHP_EOL.var_export($files_for_report, 1).PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
  
  if (!empty($files_for_report['files'])) {
    
    $bigZip = array();
    
    $rep_connection = new \PhpAmqpLib\Connection\AMQPConnection('localhost', 5672, 'guest', 'secret2005');
    $rep_channel = $rep_connection->channel();
    $rep_channel->queue_declare('rabbit_gen_report', false, true, false, false);
    
    foreach ($files_for_report['files'] as $fname_with_id => $file_abs_path) {      
      $fname = str_replace($pid.DIRECTORY_SEPARATOR, '', $fname_with_id);
      $order_id = str_replace('.txt', '', $fname);
      
      //error_log(date('Y-m-d H:i:s')." order ID = ".$order_id.PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
      
      $args = array(
        'post_type' => 'fiverr_order',
        'post_status' => 'publish',
        'orderby' => 'ID',
        'order' => 'DESC',
        'posts_per_page' => -1,
        'cache_results' => false,
        'fields' => 'ids',
        'meta_key'   => 'order_number',
    	  'meta_value' => $order_id
      );
      $orders = get_posts($args);

      if (!empty($orders) && !empty($orders[0])) {
        
        $wp_post_id = $orders[0]; // use first order even if there are many orders with this fiverr number
        
        //error_log(date('Y-m-d H:i:s')." orders with fiverr number ".var_export($orders, 1).PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
        
        $file_content = file($file_abs_path);
        $file_content = remove_utf8_bom($file_content);
        
        $lines = array();
        foreach ($file_content as $line) {
          $line = trim($line);
          if (!empty($line) && strpos($line, 'http')!==false)
          $lines[$line] = 1;
        }
        
        $file_content = implode(PHP_EOL, array_keys($lines));
        
        update_field('field_5626a52ade2b3', $file_content, $wp_post_id); // field_5626a52ade2b3 = key for "Backlinks" field in fiverr order cpt
        //error_log(date('Y-m-d H:i:s')." backlinks saved ".$file_content.PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
        
        error_log(date('Y-m-d H:i:s ').' message [>] "' . $file_abs_path.'=-='.$fname.'=-='.$order_id.'=-='.$wp_post_id.'=-='.$pid . '" sent' .PHP_EOL, 3, FIFO_PATH.'/report_rabbit.log'); //debug
        $msg = new \PhpAmqpLib\Message\AMQPMessage($file_abs_path.'=-='.$fname.'=-='.$order_id.'=-='.$wp_post_id.'=-='.$pid, array(
            'delivery_mode' => 2,
            'priority' => 1,
            'timestamp' => time(),
            'expiration' => strval(1000 * (strtotime('+1 day midnight') - time() - 1))
        ));
        $rep_channel->basic_publish($msg, '', 'rabbit_gen_report');
      
      } else {
        
        //put results in redis  
        $redis_client = new Predis\Client();
        $redis_client->set($pid.'_'.$order_id, serialize( array(
          'fiverr_order_id' => $order_id , 
          'fname' => $fname,
          'abs_path' => $file_abs_path, 
          'error' => 'There is no fiverr order in our database',
          'html' => '<code>'.$fname.'</code> <span class="bl_err">There is no fiverr order in our database</span><br />',
        ) ));
        
      }
      
    }
    
    $rep_channel->close();
    $rep_connection->close();	
    
  }
 
  
}

function fifo_generate_single_report($oid = null) {
  if (empty($oid)) return;
  
  if( get_post_type($oid) !== 'fiverr_order' ) 	return;	

	$zip = fifo_make_report($oid); // function from file make_report.php
  update_post_meta($oid, 'zip_url', $zip['url']);
  update_post_meta($oid, 'zip_path', $zip['path']);
  update_post_meta($oid, '_generated', 'yes');
  
  return $zip;
}

function fifo_reports_status() {
  $queue = get_option('order_report_queue');
  
  if (!empty($queue) && is_array($queue)) {
    
    $redis_client = new Predis\Client();
    
    foreach ($queue as $wp_id) {
  
      $files_for_report = get_post_meta($wp_id, 'backlink_files_for_report', true);
      
      if (!empty($files_for_report['files'])) {        
        
        $ofiles_counter = count($files_for_report['files']);
        
        $allKeys = $redis_client->keys($wp_id.'_*'); 

        if (count($allKeys) === $ofiles_counter) { //all reports generated
          
          foreach ($allKeys as $skey) {
            $order_report = unserialize( $redis_client->get($skey) );
            $files_for_report['reports'][$order_report['fname']] = $order_report;
            $all_orders[] = $order_report['fiverr_order_id'];
          }
          
          update_post_meta($wp_id, 'backlink_files_for_report', $files_for_report);                    
          $zip_paths = $redis_client->hGetAll($wp_id.'paths');

          //error_log(date('Y-m-d H:i:s')." ZIP PATHS === $zip_paths".PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
          if (is_array($zip_paths)) {
            $bigZip = array_values( $zip_paths );
            
            if (!empty($bigZip)) {
              
              $zip_reports = FIFO_PATH."/reports/{$wp_id}_reports.zip";
              $zip_result = fifo_create_zip($bigZip, $zip_reports, '', FIFO_PATH.'/reports/', true);
              if ($zip_result !== false) {
                $zip_url = str_replace(FIFO_PATH, FIFO_URL, $zip_reports);
                update_post_meta($wp_id, 'zip_reports', $zip_url);
                //$redis_client->delete($wp_id.'paths');
              } else {
                error_log(date('Y-m-d H:i:s')." Can't save zip file will all reports to $zip_reports".PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
              }
              
            }            
          }
          
          update_post_meta($wp_id, 'checked_at', 'Checked at: '.current_time('j F Y H:i s\s'));
          update_post_meta($wp_id, 'status', 'Done');
          
          // remove this task from queue
          unset($queue[$wp_id]);  
          update_option('order_report_queue', $queue);          
          
          
        } else {
          
        }       
        
        
      } else { // delete from queue if no post with this id 
        unset($queue[$wp_id]);
        update_option('order_report_queue', $queue);
      }
      
    }  

        
  } 
  
  
}

/*
function fifo_get_reports_task_from_queue($queue = null) {
  if (empty($queue))
    $queue = get_option('order_report_queue'); 
  
  if (!empty($queue) && is_array($queue)) {
    reset($queue);
    $first_id = key($queue); 
    
    $task = get_post($first_id, ARRAY_A);
    
    if ($task===null) {
      unset($queue[$first_id]);
      update_option('order_report_queue', $queue);
      fifo_get_task_from_queue($queue);
    } else {
      update_option('order_report_queue', $queue);
      return $first_id;
    }   
        
  } else return false;  
}
*/

function fifo_get_task_report_status($rid = null) {
  if (empty($rid)) return;
  
  fifo_reports_status();
  
  $status = get_post_meta($rid, 'backlink_files_for_report', true);
  $zip_report = get_post_meta($rid, 'zip_reports', true);
  
  $redis_client = new Predis\Client();

  if (!empty($zip_report)) {
    $result = '<a href="'.$zip_report.'" class="button button-primary">Download all Reports</a><br /><br />';
  }

  if (!empty($status['reports'])) {
    foreach ($status['reports'] as $fname => $rep) {
      $order_id = str_replace('.txt', '', $fname);
      $report_ready = $redis_client->get($rid.'_'.$order_id);
      if (!empty($report_ready)) {
        $rep_st = unserialize($report_ready);
        $result .= $rep_st['html']."<br />\n";
      } else $result .= $rep['html']."<br />\n";
    }
  }
  
  return $result;
  
}

// Load the heartbeat JS
function fifo_report_heartbeat_enqueue( $hook_suffix ) {
    // Make sure the JS part of the Heartbeat API is loaded.
    wp_enqueue_script( 'heartbeat' );
    add_action( 'admin_print_footer_scripts', 'fifo_heartbeat_report_check_footer_js', 20 );
}
add_action( 'admin_enqueue_scripts', 'fifo_report_heartbeat_enqueue' );

function fifo_heartbeat_report_check_footer_js() {
  global $pagenow;

  // Only proceed if on the dashboard
  if( 'admin.php' !== $pagenow || $_GET['page'] !== 'report-generator' )
      return;
  ?>
  <script>
  (function($){

    // Hook into the heartbeat-send
    $(document).on('heartbeat-send', function(e, data) {
      data['fifo_heartbeat_report_check'] = new Array ();

      $('#report-tasks .report-task').each(function(){
        data['fifo_heartbeat_report_check'].push($(this).data('id'));
      });
    });

    // Listen for the custom event "heartbeat-tick" on $(document).
    $(document).on( 'heartbeat-tick', function(e, data) {

      if ( ! data['backlinks_status_report'] )
        return;

      var result = data['backlinks_status_report'];
      
      for (var key in result) {
        // update task status
        if (result[key]['status'] == 'In Queue') {
            $('tr[data-id="'+key+'"] .blinks-status').html('<span class="bl_queue">In Queue</span>');
        } else if (result[key]['status']  == 'Done') {
            $('tr[data-id="'+key+'"] .blinks-status').html('<span class="bl_ok">Completed</span><br>'+result[key]['checked_at']);
        } else if (result[key]['status']  == 'Running') {
            $('tr[data-id="'+key+'"] .blinks-status').html('<span class="bl_queue">Running</span>');
        }

        // show status for each file
        $('tr[data-id="'+key+'"] .rep-status').html(result[key]['html']);
      }
    });
  }(jQuery));
  </script>
<?php
}



add_filter( 'heartbeat_received', 'fifo_report_check_heartbeat_received', 10, 2 );
function fifo_report_check_heartbeat_received( $response, $data ) {

  // Make sure we only run our query if the fifo_heartbeat key is present
  if( is_array($data['fifo_heartbeat_report_check'])) {

    foreach($data['fifo_heartbeat_report_check'] as $pid) {

      $check_status = get_post_meta($pid, 'status', true);
      $checked_at = get_post_meta($pid, 'checked_at', true);
      
      $report_status = fifo_get_task_report_status($pid);

      $response['backlinks_status_report'][$pid] = array (
        'status' => $check_status,
        'checked_at' => $checked_at,
        'html' => $report_status,
      );
    }
  }

  return $response;
}


function fifo_get_url_pr($url = null) {
  if (empty($url)) return;
  
  $gtb = new GTB_PageRank($url);
  $pageRank = (int) $gtb->getPageRank();
  
  return $pageRank;
  
}