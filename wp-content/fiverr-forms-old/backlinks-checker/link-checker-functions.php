<?php  
  
$path = dirname(__FILE__);   

define('BLINK_FOLDER', FIFO_PATH.DIRECTORY_SEPARATOR.'backlinks-checker'.DIRECTORY_SEPARATOR);

require_once FIFO_PATH.'/lib/amqp/vendor/autoload.php';   
  
add_filter( 'heartbeat_settings', 'fifo_heartbeat_settings' );  
function fifo_heartbeat_settings( $settings ) {
    $settings['interval'] = 30; //Anything between 15-60
    return $settings;
}

// Register Custom Post Type
add_action( 'init', 'add_post_type_backlinks_checker', 0 );  
function add_post_type_backlinks_checker() {

	$args = array(
		'label'               => __( 'Post Type', 'fifo' ),
		'description'         => __( 'Backlinks checks', 'fifo' ),
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
	register_post_type( 'backlinks', $args );

}



/**
* Backlink_checker Class
*/
class BacklinkChecker {

  /* -----------------------------------------------------------------------------  
    post option 'backlink_files_info' array (file_name => file_content_as_array) already checked links;  
  ----------------------------------------------------------------------------- */  
  public function run($pid = null) {

    if (empty($pid)) return;
    
    $results = array();
    
    update_post_meta($pid, 'status', 'Running');    
    update_post_meta($pid, 'started_at', 'Started at: '.current_time('j F Y H:i s\s'));
    
    $backlink_info = get_post_meta($pid, 'backlink_files_info', true); // get all links to check
    $backlink_files = $backlink_info['files'];
    
    if (!empty($backlink_files) && is_array($backlink_files)) {    
      
      foreach ($backlink_files as $file_name => $urls) {
        
        file_put_contents(FIFO_PATH.'/backlog.log', ''); //debug cleanup
        //error_log(date('Y-m-d H:i:s ').'FILE: '.$file_name." ".PHP_EOL, 3, FIFO_PATH.'/backlog.log'); //debug
     
        $fiv = str_replace($pid.'/', '', $file_name);
        $fiverr_id = str_replace('.txt', '', $fiv);
        $this->send_urls_to_rabbitmq(array_keys($urls['urls']), $pid, $fiverr_id);  
          
      }
      
    }
   
  }
  
  private function send_urls_to_rabbitmq($urls = null, $wp_id, $fiverr_id) {
    //error_log(date('Y-m-d H:i:s ').' [>] START "' . var_export($urls, 1) . '" sent' .PHP_EOL, 3, FIFO_PATH.'/rabbit.log'); //debug
    if (empty($urls)) return;  

    $connection = new \PhpAmqpLib\Connection\AMQPConnection('localhost', 5672, 'guest', 'secret2005');
    $channel = $connection->channel();
    $channel->queue_declare('check_url', false, true, false, false);
    
    $order_data_prefix = $wp_id.'_'.$fiverr_id.'_';
    
    foreach($urls as $url) {
        //error_log(date('Y-m-d H:i:s ').' [>] "' . $order_data_prefix . $url . '" sent' .PHP_EOL, 3, FIFO_PATH.'/rabbit.log'); //debug
        $msg = new \PhpAmqpLib\Message\AMQPMessage($order_data_prefix . $url, array(
            'delivery_mode' => 2,
            'priority' => 1,
            'timestamp' => time(),
            'expiration' => strval(1000 * (strtotime('+1 day midnight') - time() - 1))
        ));
        $channel->basic_publish($msg, '', 'check_url');
        //echo ' [>] "' . $order_data_prefix . $url . '" sent' . PHP_EOL;
    }
    $channel->close();
    $connection->close();	
    
  } 

}

function fifo_get_status() {
  
  $checked_dir_path = BLINK_FOLDER.'checked_or'.DIRECTORY_SEPARATOR;
  if (!is_dir($checked_dir_path.$pid)) {
    $st = mkdir($checked_dir_path.$pid, 0755, true);
  } 
  
  $queue = get_option('backlinks_checker_queue');
  
  if (!empty($queue) && is_array($queue)) {
    foreach ($queue as $wp_id) {
      $backlink_info = get_post_meta($wp_id, 'backlink_files_info', true);
      
      $backlink_files_urls = $backlink_info['files'];
      
      if (!empty($backlink_files_urls)) {
        foreach ($backlink_files_urls as $file_name => $urls_array) {
          $fiv = str_replace($wp_id.'/', '', $file_name);
          $fiverr_id = str_replace('.txt', '', $fiv);
          
          $counters[$wp_id][$fiverr_id] = array('wp_id' => $wp_id, 'count' => count($urls_array['urls']), 'file_name' => $file_name);
        }
        
      } else {
        unset($queue[$wp_id]);
        update_option('backlinks_checker_queue', $queue);
      }
    }
  } 
  // end get array of counters
  
  $redis = new Predis\Client();
  
  if (!empty($counters)) {    
        
    foreach ($counters as $wpid => $fiverrs ) {
      
      $is_checked = true;
      
      foreach ($fiverrs as $fiverrid => $k ) {
        
        $wpid_fiverrid = $wpid.'_'.$fiverrid;  
          
        $backlink_info = get_post_meta($wpid, 'backlink_files_info', true);
        $backlink_files_urls = $backlink_info['files'];
        $files_to_check = $backlink_info['backlink_files'];
        $wpid_file_name = $k['file_name'];
        
        $allKeys = $redis->keys($wpid_fiverrid.'_*');      
        
        $good_links = get_post_meta($wpid, 'good_links', true);
        
        if ($backlink_files_urls[$wpid_file_name]['status']['checked'] !== 'checked') {
         
          if (count($allKeys) === $k['count']) { // if all urs in file are checked
            
            foreach ($backlink_files_urls[$wpid_file_name]['urls'] as $single_url => $data) {
              $response = $redis->get($wpid_fiverrid.'_'.md5($single_url));
              $results[$wpid_file_name]['urls'][$single_url] = array('response' => $response);
              
              if ((int)$response === 200) {
                $good_links[$wpid_file_name][$single_url] = $single_url;
                //error_log(date('Y-m-d H:i:s ').'FILE: '.var_export($good_links, 1)." ".PHP_EOL, 3, FIFO_PATH.'/goodlinks.log'); //debug
              }


              
            }

            #print_r($backlink_files_urls[$wpid_file_name]['urls']);
    
    # $backlink_files[$post_id.DIRECTORY_SEPARATOR.$name] = array( 'urls' => $backlinks_to_check, 'backlink_files' => $new_names);        
    
            //$this->backlinks_array[$this->fname] = array_merge($this->backlinks_array[$this->fname], $results[$this->fname]); //merging with unchecked to show status
            $backlink_files_urls[$wpid_file_name]['urls'] = array_merge($backlink_files_urls[$wpid_file_name]['urls'], $results[$wpid_file_name]['urls']);
            
            $backlink_files_urls[$wpid_file_name]['status'] = array('amount' => $k['count'].' from '.$k['count'] , 'checked' => 'checked' );
            
            $backlink_info['files'] = $backlink_files_urls;
            
            update_post_meta($wpid, 'backlink_files_info', $backlink_info); // save result of link checking with responses;
            update_post_meta($wpid, 'good_links', $good_links); 
            
            file_put_contents(FIFO_PATH.'/ck.log', var_export($backlink_files_urls,1));        
            
            @rename($files_to_check[$wpid_file_name], $checked_dir_path.$wpid_file_name); // move to folder where collects checked files.  
            
          } else {


            $is_checked = false;
            // to set status of file checking
            $backlink_files_urls[$wpid_file_name]['status'] = array('amount' => count($allKeys).' from '.$k['count']  );
            $backlink_info['files'] = $backlink_files_urls;
            update_post_meta($wpid, 'backlink_files_info', $backlink_info);      
          }
        
        }
      
      } //endfoearch in checking files
      
      if ($is_checked === true) {
        save_good_backlinks_to_files($wpid, $good_links); 
        @rmdir(BLINK_FOLDER.'to_check'.DIRECTORY_SEPARATOR.$wpid); 
        
        update_post_meta($wpid, 'checked_at', 'Checked at: '.current_time('j F Y H:i s\s'));
        update_post_meta($wpid, 'status', 'Completed');
        
        // remove this task from queue
        $queue = get_option('backlinks_checker_queue');
        unset($queue[$wpid]);  
        update_option('backlinks_checker_queue', $queue);   
        
      }      
      
    } //endfoearch in wordpress task
  
  } //endif !empty($counters)   

}

function save_good_backlinks_to_files($pid, $good_links = null) {
  if (empty($good_links)) { // in case, when you want to run this function outside class
    $good_links = get_post_meta($pid, 'good_links', true); 
  }
  
  $to_zip = array();
  if (!empty($good_links)) {
    foreach ($good_links as $fname => $fcontent) {
      
      $folder_path = FIFO_PATH.DIRECTORY_SEPARATOR.'backlinks-checker'.DIRECTORY_SEPARATOR.'checked_good'.DIRECTORY_SEPARATOR;
      
      if (!is_dir($folder_path.$pid)) {
        $st = mkdir($folder_path.$pid, 0755, true);
      }
      
      $good_name = $folder_path.$fname;
      
      $zip_name = $folder_path.$pid.'_good_backlinks.zip'; 
      
      //var_dump($fcontent);
      $fcontent = array_unique($fcontent); // in case, when was a restart of process.
      sort($fcontent, SORT_STRING); //sort by urls
      
      file_put_contents($good_name, implode(PHP_EOL, $fcontent));
      $to_zip[] = $good_name;
      
    }
  
    $res = fifo_create_zip($to_zip, $zip_name, $pid.'_good_backlinks'.DIRECTORY_SEPARATOR, $folder_path.$pid.DIRECTORY_SEPARATOR, true);
    
    if ($res !== false) {
      foreach ($to_zip as $fname) {
        unlink($fname);
      }
      
      @rmdir($folder_path.$pid);
      
      update_post_meta($pid, 'zip_backlinks', FIFO_URL.DIRECTORY_SEPARATOR.'backlinks-checker'.DIRECTORY_SEPARATOR.'checked_good'.DIRECTORY_SEPARATOR.$pid.'_good_backlinks.zip');
    }  
  
  }
  
} 

/* -----------------------------------------------------------------------------  
  Function fifo_run_check - executes from checker.php during cron schedule
----------------------------------------------------------------------------- */  
function fifo_run_check($pid = null) {
  
  $backlink_checker = new BacklinkChecker();
  $backlink_checker->run($pid);
  
}

function fifo_backlinks_report($pid = null) { 
  if (empty($pid)) return;
  
  $result = '';
  
  $blinks_info = get_post_meta($pid, 'backlink_files_info', true);
  if (!empty($blinks_info)) {
    
    $blinks = $blinks_info['files'];
    
    $all_links = $good_links = $bad_links = array(); 

    foreach ($blinks as $fname => $sfile) {
      
      $bad_links[$fname] = $good_links[$fname] = $all_links[$fname] = array();
      
      foreach ($sfile['urls'] as $url => $url_report) {
        $response = ''; 
        $url_status = ''; 
        
        $url = trim($url);
        
        if ( (int) $url_report['response'] === 200) { 
          $response = '<span class="bl_ok">OK</span>';
          $good_links[$fname][] = '<a href="'.$url.'" target="_blank" class="'.$url_status.'">'.$url.'</a><br />';
        }  
        elseif ( (int) $url_report['response'] === 404) {
          $response = '<span class="bl_e404">404</span>';
          $url_status = ' bl_err';
          $bad_links[$fname][] = '<a href="'.$url.'" target="_blank" class="'.$url_status.'">'.$url.'</a>&nbsp;'.$response.'<br />';
          
        }
        elseif ( $url_report['response'] === NULL) {
          $response = '<span class="bl_grey">in queue</span>';
          $url_status = ' bl_grey';
          $bad_links[$fname][] = '<a href="'.$url.'" target="_blank" class="'.$url_status.'">'.$url.'</a>&nbsp;'.$response.'<br />';
          
        }          
        elseif ($url_report['response'] !== '') {
          $response = '<span class="bl_err">'.$url_report['response'].'</span>';
          $url_status = ' bl_err';
          $bad_links[$fname][] = '<a href="'.$url.'" target="_blank" class="'.$url_status.'">'.$url.'</a>&nbsp;'.$response.'<br />';
        }
        
        $all_links[$fname][] = '<a href="'.$url.'" target="_blank" class="'.$url_status.'">'.$url.'</a>&nbsp;'.$response.'<br />';
      }
      
      $good = (!empty($good_links[$fname])) ? implode('', $good_links[$fname]) : 'Unfortunately - No Good Links in this file';
      $bad =  (!empty($bad_links[$fname])) ? implode('', $bad_links[$fname]) : 'Good News - No bad links in this file';
      $all = (!empty($all_links[$fname])) ? implode('', $all_links[$fname]) : '';
      
      $result['good'][] = '<br /><span id="good"></span>'.str_replace($pid.DIRECTORY_SEPARATOR, '', $fname).' '.count($good_links[$fname]).'<br />'.$good;
      $result['bad'][] = '<br /><span id="bad"></span>'.str_replace($pid.DIRECTORY_SEPARATOR, '', $fname).' '.count($bad_links[$fname]).'<br />'.$bad;
      $result['all'][] = '<br /><span id="all"></span>'.str_replace($pid.DIRECTORY_SEPARATOR, '', $fname).' '.count($all_links[$fname]).'<br />'.$all;
    
    }  
    
    //$result = array('all' => $all_links, 'good' => $good_links, 'bad' => $bad_links);
  }
  
  return $result;
}


// Load the heartbeat JS
function fifo_heartbeat_enqueue( $hook_suffix ) {
    // Make sure the JS part of the Heartbeat API is loaded.
    wp_enqueue_script( 'heartbeat' );
    add_action( 'admin_print_footer_scripts', 'fifo_heartbeat_backlinks_files_check_footer_js', 20 );
}
add_action( 'admin_enqueue_scripts', 'fifo_heartbeat_enqueue' );

function fifo_heartbeat_backlinks_files_check_footer_js() {
    global $pagenow;

    // Only proceed if on the dashboard
    if( 'admin.php' !== $pagenow || $_GET['page'] !== 'backlinks-checker' || !empty($_GET['id']) )
        return;
    ?>
    <script>
        (function($){

            // Hook into the heartbeat-send
            $(document).on('heartbeat-send', function(e, data) {
                data['fifo_heartbeat_check'] = new Array ();

                $('#backlink-tasks .backlink-task.in-process').each(function(){
                    data['fifo_heartbeat_check'].push($(this).data('id'));
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
                        $('tr[data-id="'+key+'"] .blinks-status').html('<span class="bl_In">In Queue</span>');
                    } else if (result[key]['status']  == 'Completed') {
                        $('tr[data-id="'+key+'"] .blinks-status').html('<span class="bl_Completed">Completed</span><br>'+result[key]['checked_at']);
                    } else if (result[key]['status']  == 'Running') {
                        $('tr[data-id="'+key+'"] .blinks-status').html('<span class="bl_Running">Running</span>');
                    }

                    // show zip link if done
                    if(result[key]['zip_file'])
                        $('tr[data-id="'+key+'"] .blinks-download').html('<a href="'+result[key]['zip_file']+'" class="button button-primary">Download Zip</a>');

                    // update files status
                    if (result[key]['file_status'].length > 0) {
                      for(var i=0;i<result[key]['file_status'].length;i++) {
                        var $file = $('tr[data-id="'+key+'"] li[data-file="'+result[key]['file_status'][i]['file']+'"]');
                        var $status = $('.status', $file);
                        var $amount = $('.amount', $file);
                        $amount.html(result[key]['file_status'][i]['amount']);
                        $status.attr({'class' : 'status '+result[key]['file_status'][i]['checked']});
                      }  
                    }    
                }
            });
        }(jQuery));
    </script>
<?php
}

add_filter( 'heartbeat_received', 'fifo_file_check_heartbeat_received', 10, 2 );

function fifo_file_check_heartbeat_received( $response, $data ) {

    // Make sure we only run our query if the fifo_heartbeat key is present
    if( is_array($data['fifo_heartbeat_check'])) {
        // data contains ids of the tasks we need to response with the statuses of files
        foreach($data['fifo_heartbeat_check'] as $pid) {

            $zip_file = get_post_meta($pid, 'zip_backlinks', true);
            $check_status = get_post_meta($pid, 'status', true);
            if (empty($check_status)) $check_status = '';
            $checked_at = get_post_meta($pid, 'checked_at', true);

            $backlinks_info = get_post_meta($pid, 'backlink_files_info', true);
            
            foreach ($backlinks_info['files'] as $fname => $data) {
              $count_bad = 0;
              foreach($data['urls'] as $url => $info ) {
                $url_response = $info['response'];
                if(!empty($url_response) && (int)$url_response != 200) { //
                  $count_bad++;
                }
              }
              $state = (isset($data['status']['checked'])) ? 'checked' : 'notyet';
              $file_statuses[] = array('file' => $fname, 'amount' => $data['status']['amount'] . ( $count_bad > 0 ? ' urls ('.$count_bad.' have errors)' : ' urls'), 'checked' => $state);
            }

            $response['backlinks_status_report'][$pid] = array (
                'status' => $check_status,
                'checked_at' => $checked_at,
                'zip_file' => $zip_file,
                'file_status' => $file_statuses,
            );
        }
    }

    return $response;
}

function fifo_info_from_redis($pid = null) {
  if (empty($pid)) return;
  
  $redis_client = new Predis\Client();

  $allKeys = $redis_client->keys($pid.'_*'); 
  foreach ($allKeys as $key) {
    $parts = explode('_', $key);
    $value = $redis_client->get($key);
    $result[$parts[1]][$parts[2]] = $value;
  }
  
  return $result;
  
}



function fifo_add_dropzone_scripts() {
  
  if ($_GET['page']==='backlinks-checker' || $_GET['page']==='report-generator') {   
 
    wp_enqueue_style ( 'dropzone', FIFO_URL.'/css/dropzone.css' );
    wp_enqueue_script ( 'dropzone', FIFO_URL.'/js/dropzone.js', array( 'jquery' ) );

  }      
}

add_action( 'admin_enqueue_scripts', 'fifo_add_dropzone_scripts' );

if (!empty($_POST['bulk_upload'])) {
  
  add_action('init', 'fifo_manage_bulk_files');

}

function fifo_manage_bulk_files() {
  
  if (!empty($_FILES) && !empty($_POST['bulk_upload'])) {
    $check_files = array();
    $store_folder = BLINK_FOLDER.'to_check'.DIRECTORY_SEPARATOR;   
    $file_ary = reArrayFiles($_FILES['file']);
    
      foreach ($file_ary as $file) {
                                     
        $target_file =  $store_folder. $file['name']; 
        
        if (strpos($file['name'], 'php') === false && strpos($file['name'], '.txt') !== false) {    
          $status = move_uploaded_file($file['tmp_name'],$target_file); 
          if ($status === true) {
            $check_files[$file['name']] = $target_file;
          }          
        }           
      }
      
      if (!empty($check_files)) {
        fifo_create_new_task_for_backlinks_checking($check_files);
      }
      
  }
}

if (!empty($_POST['fifo_check_links'])) {
  
  add_action('init', 'fifo_check_backlinks_from_textarea');

}

function fifo_check_backlinks_from_textarea() {
  if (empty($_POST['fbacklinks'])) return;
  
  $fname = 'fromtextarea.txt';
  
  $res = file_put_contents(BLINK_FOLDER.'to_check'.DIRECTORY_SEPARATOR.$fname, $_POST['fbacklinks']);
  
  if ($res !== false) {    
    $file_ary = array($fname => BLINK_FOLDER.'to_check'.DIRECTORY_SEPARATOR.$fname);
    fifo_create_new_task_for_backlinks_checking($file_ary);   
  }
  
}

function fifo_create_new_task_for_backlinks_checking($files = null) {
  $post_args = array(
    'post_title'     => current_time( 'mysql' ),
    'post_status'    => 'publish',
    'post_type'      => 'backlinks'  
  );  
  
  $post_id = wp_insert_post($post_args);
  
  
  if (!empty($files)) {
    
    $storeFolder = BLINK_FOLDER.'to_check'.DIRECTORY_SEPARATOR;
    $new_names = $backlink_files = array();

    if (!is_dir($storeFolder.$post_id)) {
      $st = mkdir($storeFolder.$post_id, 0755, true);
    }    
    
    foreach ($files as $name => $sfile) { // $sfile = abs path to file, $name = only filename
      $new_name = $post_id.DIRECTORY_SEPARATOR.$name; 
      $new_location = $storeFolder.$new_name;
      
      $status = rename($sfile, $new_location);
      if ($status === true) {
        $new_names[$new_name] = $new_location;
        
        $file_content = file($new_location); // read links to array
        
        if (!empty($file_content)) {
          $file_content = remove_utf8_bom($file_content);
          $file_content = array_unique($file_content); // remove duplicates of links
          
          $backlinks_to_check = array();
          
          foreach ($file_content as $line) {
            if (!empty($line) && strpos($line, 'http')!==false) {
              $backlinks_to_check[trim($line)] = array('response' => null);
            }
          }
          
          $backlink_files['files'][$post_id.DIRECTORY_SEPARATOR.$name] = array( 'urls' => $backlinks_to_check, 'status' => array( 'amount' => count($backlinks_to_check) ) );
        }
      }
    }
    
    $backlink_files['backlink_files'] = $new_names;

    update_post_meta($post_id, 'backlink_files_info', $backlink_files); // to show preview in single view
    update_post_meta($post_id, 'status', 'In Queue');
    $queue = get_option('backlinks_checker_queue');  
    $queue[$post_id] = $post_id;  
    update_option('backlinks_checker_queue', $queue);    
    
    fifo_run_check($post_id);
  }

  
}

if (!function_exists('reArrayFiles')) {

  function reArrayFiles(&$file_post) {
  
      $file_ary = array();
      $file_count = count($file_post['name']);
      $file_keys = array_keys($file_post);
  
      for ($i=0; $i<$file_count; $i++) {
          foreach ($file_keys as $key) {
              $file_ary[$i][$key] = $file_post[$key][$i];
          }
      }
  
      return $file_ary;
  }

}

if (!function_exists('remove_utf8_bom')) {
  function remove_utf8_bom($text) {
     $bom = pack('H*','EFBBBF');
     $text = preg_replace("/^$bom/", '', $text);
     return $text;
  }
}


add_action( 'admin_enqueue_scripts', 'fifo_comments_templates' );

function fifo_comments_templates() {

    if ($_GET['page']==='fiverr-orders') {

        add_action( 'admin_print_footer_scripts', 'fifo_comments_templates_js', 20 );

    }
}

function fifo_comments_templates_js () {
?>
    <!-- comment template -->
    <script type="text/html" id="tmpl-comment">
        <tr id="comment-{{data.comment_ID}}" class="comment byuser comment-author-{{data.comment_author}} bypostauthor">
            <td class="author column-author" data-colname="Author" style="width:25%">
                <strong>{{data.comment_author}}</strong><br>
                <a href="mailto:{{data.comment_author_email}}">{{data.comment_author_email}}</a><br>
                {{data.comment_author_IP}}
            </td>
            <td class="comment column-comment has-row-actions column-primary" data-colname="Comment">
                <div class="submitted-on">Submitted on {{data.comment_date}}</div>

                {{data.comment_content}}
            </td>
        </tr>
    </script>
    <!-- no results template -->
    <script type="text/html" id="tmpl-no-comments">
        <div class="nothing">No comments for this order.</div>
    </script>
<?php
}

add_action( 'wp_ajax_get_comments', 'fifo_get_comments' );

function fifo_get_comments() {
    $pid = intval($_POST['pid']);

    $comments = get_comments(array(
        'post_id' => $pid,
    ));

    echo json_encode($comments);

    exit;
}

add_action( 'wp_ajax_insert_comment', 'fifo_insert_comment' );

function fifo_insert_comment () {
    global $current_user;

    $pid = intval($_POST['pid']);
    $content = $_POST['content'];

    $commentdata = array(
        'comment_post_ID' => $pid, // to which post the comment will show up
        'comment_content' => $content, //fixed value - can be dynamic
        'comment_author' => $current_user->display_name, //fixed value - can be dynamic
        'comment_author_email' => $current_user->user_email, //fixed value - can be dynamic
        'user_id' => $current_user->ID, //passing current user ID or any predefined as per the demand
    );

    echo wp_new_comment( $commentdata );
    exit;
}



#########################################################
function fifo_debug_status() {
  
  #$checked_dir_path = BLINK_FOLDER.'checked_or'.DIRECTORY_SEPARATOR;
  #if (!is_dir($checked_dir_path.$pid)) {
  #  $st = mkdir($checked_dir_path.$pid, 0755, true);
  #} 
  
  $queue = get_option('backlinks_checker_queue');
  
  if (!empty($queue) && is_array($queue)) {
    foreach ($queue as $wp_id) {
      $backlink_info = get_post_meta($wp_id, 'backlink_files_info', true);
      
      $backlink_files_urls = $backlink_info['files'];
      
      if (!empty($backlink_files_urls)) {
        foreach ($backlink_files_urls as $file_name => $urls_array) {
          $fiv = str_replace($wp_id.'/', '', $file_name);
          $fiverr_id = str_replace('.txt', '', $fiv);
          
          $counters[$wp_id][$fiverr_id] = array('wp_id' => $wp_id, 'count' => count($urls_array['urls']), 'file_name' => $file_name);
        }
        
      } else {
        unset($queue[$wp_id]);
        update_option('backlinks_checker_queue', $queue);
      }
    }
  } 
  // end get array of counters
  
  $redis = new Predis\Client();
  
  if (!empty($counters)) {    
        
    foreach ($counters as $wpid => $fiverrs ) {
      
      $is_checked = true;
      
      foreach ($fiverrs as $fiverrid => $k ) {
        
        $wpid_fiverrid = $wpid.'_'.$fiverrid;  
          
        $backlink_info = get_post_meta($wpid, 'backlink_files_info', true);
        $backlink_files_urls = $backlink_info['files'];
        $files_to_check = $backlink_info['backlink_files'];
        $wpid_file_name = $k['file_name'];
        
        $allKeys = $redis->keys($wpid_fiverrid.'_*');  
        //var_dump($allKeys)    ;
        
        $good_links = get_post_meta($wpid, 'good_links', true);
        
        #if ($backlink_files_urls[$wpid_file_name]['status']['checked'] !== 'checked') {
        if (true) {  
         
          if (count($allKeys) === $k['count']) { // if all urs in file are checked

            foreach ($backlink_files_urls[$wpid_file_name]['urls'] as $single_url => $data) {
              //var_dump($single_url);
              $response = $redis->get($wpid_fiverrid.'_'.md5($single_url));
              //var_dump($response);
              $results[$wpid_file_name]['urls'][$single_url] = array('response' => $response);
              
              if ((int)$response === 200) {
                $good_links[$wpid_file_name][$single_url] = $single_url;
              }


            }
    
    # $backlink_files[$post_id.DIRECTORY_SEPARATOR.$name] = array( 'urls' => $backlinks_to_check, 'backlink_files' => $new_names);        
    
            //$this->backlinks_array[$this->fname] = array_merge($this->backlinks_array[$this->fname], $results[$this->fname]); //merging with unchecked to show status
            $backlink_files_urls[$wpid_file_name]['urls'] = array_merge($backlink_files_urls[$wpid_file_name]['urls'], $results[$wpid_file_name]['urls']);
            
            $backlink_files_urls[$wpid_file_name]['status'] = array('amount' => $k['count'].' from '.$k['count'] , 'checked' => 'checked' );
            
            $backlink_info['files'] = $backlink_files_urls;
            
            //var_dump($wpid_file_name);
            //var_dump($backlink_files_urls[$wpid_file_name]);
            
            update_post_meta($wpid, 'backlink_files_info', $backlink_info); // save result of link checking with responses;
            update_post_meta($wpid, 'good_links', $good_links); 
            
            file_put_contents(FIFO_PATH.'/ck.log', var_export($backlink_files_urls,1));        
            
            #@rename($files_to_check[$wpid_file_name], $checked_dir_path.$wpid_file_name); // move to folder where collects checked files. 
            
          } else {


            $is_checked = false;
            // to set status of file checking
            $backlink_files_urls[$wpid_file_name]['status'] = array('amount' => count($allKeys).' from '.$k['count']  );
            $backlink_info['files'] = $backlink_files_urls;
            update_post_meta($wpid, 'backlink_files_info', $backlink_info);      
          }
        
        }
        
      
      } //endfoearch in checking files
      
      if ($is_checked === true) {
        save_good_backlinks_to_files($wpid, $good_links); 
        @rmdir(BLINK_FOLDER.'to_check'.DIRECTORY_SEPARATOR.$wpid); 
        
        update_post_meta($wpid, 'checked_at', 'Checked at: '.current_time('j F Y H:i s\s'));
        update_post_meta($wpid, 'status', 'Completed');
        
        // remove this task from queue
        $queue = get_option('backlinks_checker_queue');
        unset($queue[$wpid]);  
        update_option('backlinks_checker_queue', $queue);   
        
      }      
      
    } //endfoearch in wordpress task
  
  } //endif !empty($counters)   

}
