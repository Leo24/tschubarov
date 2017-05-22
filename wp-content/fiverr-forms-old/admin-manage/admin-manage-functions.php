<?php 
  
add_action( 'admin_menu', 'fifo_manage_menu' );

function fifo_manage_menu() {	
	add_submenu_page( 'fiverr-orders', 'Orders Statistic', 'Orders Statistic', 'edit_posts', 'manage-orders', 'fifo_render_manage_orders');
	add_submenu_page( 'fiverr-orders', 'Orders Graphics', 'Orders Graphics', 'edit_posts', 'orders-graphics', 'fifo_render_graphics_orders');
	
}

function fifo_render_manage_orders() {
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include_once 'admin-manage-view.php';
}

function fifo_render_graphics_orders() {
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	include_once 'admin-manage-graphs.php';
}



function fifo_sort_by_time($a, $b) {
  return (int) $a['last_changed'] - (int) $b['last_changed'];
}

function fifo_get_orders($options = array()) {
  
  
  $args = array (
    'post_type' => 'fiverr_order',
    'post_status' => 'publish',
    'orderby' => 'ID',
    'order' => 'DESC',
    'posts_per_page' => -1,
    'cache_results' => false,
    'fields' => 'ids'
  );
  
  if (!empty($_GET['fuser']) && intval($_GET['fuser']) > 0) {
    $args['author'] = $_GET['fuser'];
  }
  
  $get_gig = empty($_GET['gig']) ? 'all-gigs' : $_GET['gig'];
   
  if ($get_gig !== 'all-gigs') {
    $gig_filter = array(
      'key'     => 'form_id',
  		'value'   => $get_gig,
  		'compare' => '=',
    ); 
    
    $args['meta_query'][] = $gig_filter;
  }
  
  if (!empty($options['order_status'])) {
    
    $status_filter = array(
      'taxonomy' => 'status',
  		'field'    => 'name',
  		'terms'    => $options['order_status'],
    ); 
  
    $args['tax_query'] = array($status_filter);
  
  }
  
  $pids = get_posts( $args );
  
  if (!empty($pids)) {
    
    foreach ($pids as $pid) {
      $last_changed = get_post_meta($pid, 'last_changed', true);
      if (!empty($last_changed)) {
        $result[$pid] = array('last_changed' => (int) $last_changed, 'from' => 'pmeta'); 
      } else {
        $result[$pid] = array('last_changed' => strtotime(get_field('form_created', $pid)), 'from' => 'create_date'); 
      }
    }
    
    //@!TODO: change to mysql request

    uasort($result, 'fifo_sort_by_time');
    return $result;
  } else return false;
  
}


function fifo_add_adm_manage_scripts() {

  if (is_user_logged_in()) {
    
    if ($_GET['page']==='manage-orders' )  {
      wp_enqueue_script ( 'fifo-countdown', plugins_url( '../js/countdown.min.js', __FILE__ ), array( 'jquery' ) );
    }
    
    if ($_GET['page']==='orders-graphics' )  {
      wp_enqueue_style  ( 'fifo-chartist-css', plugins_url( '../css/chartist.min.css', __FILE__ ) );
      wp_enqueue_script ( 'fifo-chartist', plugins_url( '../js/chartist.min.js', __FILE__ ) );
    }
    wp_enqueue_script ( 'fifo-admanage-script', plugins_url( '../js/admin_manage.js', __FILE__ ), array( 'jquery' ) );
        

  }      
}

add_action( 'admin_enqueue_scripts', 'fifo_add_adm_manage_scripts' );	

function fifo_render_orders($orders) {
  //@TODO - change to use mysql
  foreach ($orders as $pid => $values) {
    $author_id = get_post_field( 'post_author', $pid );
    $author_data = get_userdata($author_id); 
    $fiverr_order = get_field('order_number', $pid);
    ?>
    <div class="td td-order" data-pid="<?php echo $pid; ?>" data-last-changed="<?php echo $values['last_changed']; ?>">
      <a href="<?php echo admin_url('admin.php?page=fiverr-orders&gig=all-gigs&status=none&fuser=-1&orders_per_page=12&order_id='.$fiverr_order); ?>"><?php echo $fiverr_order;  ?></a>
      <br />
      <span class="oinfo">
        <span class="elapse-time" data-last-changed="<?php echo $values['last_changed']; ?>"></span> / <span class="assigned-user"><?php echo $author_data->display_name; ?></span>
      </span>
    </div>
<?php        
  }  
}


// Load the heartbeat JS
function fifo_heartbeat_enqueue_for_manage_orders( $hook_suffix ) {
    // Make sure the JS part of the Heartbeat API is loaded.
    wp_enqueue_script( 'heartbeat', false, array('jquery') );
    add_action( 'admin_print_footer_scripts', 'fifo_heartbeat_manage_orders_footer_js', 30 );
}
add_action( 'admin_enqueue_scripts', 'fifo_heartbeat_enqueue_for_manage_orders' );


function fifo_heartbeat_manage_orders_footer_js() {

    // Only proceed if on the dashboard
    if( $_GET['page'] !== 'manage-orders' ) 
        return;
    ?>
    <script>
        (function($){
            // Hook into the heartbeat-send
            $(document).on('heartbeat-send', function(e, data) {
                data['fifo_heartbeat_manage'] = new Array ();

                $('.td-order').each(function(){
                    data['fifo_heartbeat_manage'].push($(this).data('pid'));
                });
            });

            // Listen for the custom event "heartbeat-tick" on $(document).
            $(document).on( 'heartbeat-tick', function(e, data) {

                if ( ! data['manage_order'] )
                    return;

                var result = data['manage_order'];
                
                for (var key in result) {
                    // update task status
                    $order_td = $('.td-order[data-pid="'+key+'"]');
                    
                    if (result[key]['status'] === 'completed') {
                      $order_td.remove();
                    } else {
                      $parent = $order_td.parent();
                      
                      if ($parent.attr('id') !== result[key]['status']) {
                        $('#'+result[key]['status']).append($order_td);
                      }
                      $order_td.attr({'class' : 'td td-order '+ result[key]['class'], 'data-last-changed' : result[key]['last_changed'] })
                        .find('.elapse-time').attr({'data-last-changed' : result[key]['last_changed'] });                      
                    }
 
                }
                
                run_timelapser();
                
            });
        }(jQuery));
    </script>
<?php
}

function fifo_manage_orders_heartbeat_received( $response, $data ) {

    // Make sure we only run our query if the fifo_heartbeat key is present
    if( is_array($data['fifo_heartbeat_manage'])) {
        // data contains ids of the tasks we need to response with the statuses of files
        foreach($data['fifo_heartbeat_manage'] as $pid) {
            $last_changed = get_post_meta($pid,'last_changed',true);
            
            $status = wp_get_object_terms($pid, 'status' );
            if ( ! empty( $status ) ) {
            	if ( ! is_wp_error( $status ) ) {
            			foreach( $status as $term ) {
              			$o_status = $term->slug;
            			}
            	}
            }
            
            if (empty($last_changed)) {
              $last_changed = strtotime(get_field('form_created', $pid));
            }  
            
            $hours = ceil((time() - $last_changed)/60/60);
            
            if ($hours > 2) {
              $class = 'td-important';
            } elseif ($hours > 1) {
              $class = 'td-warning';
            } else {
              $class = 'td-ok';            
            }
            
            $response['manage_order'][$pid] = array(
              'class' => $class,
              'last_changed' => (int)$last_changed,
              'status' => $o_status,
            );
        }
    }

    return $response;
}
add_filter( 'heartbeat_received', 'fifo_manage_orders_heartbeat_received', 10, 2 );

function fifo_get_orders_for_graph_count($options = array()) {
  
  $user = ( !empty($_GET['fuser']) ) ? $_GET['fuser'] : $options['fuser'] ;
  
  $optsweek = (!empty($options['week'])) ? $options['week'] : $_GET['week']; 
  
  if (empty($optsweek)) {
    $oweek = gmdate("W", time());
    $oyear = gmdate("Y", time());
    $curr_week = $oyear.'-'.$oweek;
  } else {
    $curr_week = $optsweek; 
    $w = explode('-', $optsweek);
    $oweek = $w[1];
    $oyear = $w[0];
  }
  
  $week_range = $group_by = '';
  
  if ($curr_week !== 'all_time') {
    $year_week = explode('-', $curr_week);
    $unix_stamps = getStartAndEndDateInUnix($year_week[1], $year_week[0]);
    
    $week_range = " AND ( wp_postmeta.meta_key = 'last_changed' ".
                  "AND CAST(wp_postmeta.meta_value AS SIGNED) BETWEEN '$unix_stamps[0]'".
                  "AND '$unix_stamps[1]' ) ";
  } 
  
  if (!empty($user) && (int) $user >=0) {
    $where_user = " AND wp_posts.post_author IN (".intVal($user).")";
    $group_by = "GROUP BY post_author";
  }
  
  $cached_ids = get_option('status_to_id');
  
  global $wpdb;  
  
  $sql =<<<EEE
  SELECT post_author, COUNT(ID) as counter 
  FROM (
    SELECT wp_posts.post_author, wp_posts.ID
    FROM wp_posts 
    INNER JOIN wp_term_relationships
    ON (wp_posts.ID = wp_term_relationships.object_id)
    INNER JOIN wp_postmeta
    ON ( wp_posts.ID = wp_postmeta.post_id )
    WHERE wp_term_relationships.term_taxonomy_id IN (%d)
    
    $where_user 
    
    $week_range
    
    AND wp_posts.post_type = 'fiverr_order'
    AND wp_posts.post_status = 'publish'
    GROUP BY wp_posts.ID
    ORDER BY wp_posts.ID DESC 
  
  ) as orders_to_author
    
    $group_by
    
EEE;
    $results = $wpdb->get_results( $wpdb->prepare( $sql, array( $cached_ids[$options['order_status']] ) ), ARRAY_A );
//var_dump($wpdb->prepare( $sql, array( $cached_ids[$options['order_status']] )) );
    if (!empty($results)) {
    
      foreach ($results as $row) {
        if ((int)$row['post_author'] >= 0 ) {
          $author_to_count[(int)$row['post_author']] = (int) $row["counter"];
        }
      }  
      
      
      if ($user >=0) {
        return $author_to_count[$user];
      } else { // if all users
        return array_shift($author_to_count);
      }
    
    } 
  
}


function fifo_get_stat_day_by_day($options = array()) {
  $all_completed = fifo_get_orders_for_graph_count(array('order_status' => 'Completed'));
  
  if (empty($_GET['week'])) {
    $curr_week = gmdate("Y", time()).'-'.gmdate("W", time());
  } else $curr_week = $_GET['week'];  
  
  $completed_in_a_week = $all_completed[$curr_week];
  
  if (!empty($completed_in_a_week)) {
    foreach ($completed_in_a_week as $weekday => $orders) {
      $result[$weekday] = count($orders);
    }
  }
  if (!empty($result))
    ksort($result);
  return $result;
}

function fifo_get_statuses_stat($options = array()) {
  $count_inprogress = fifo_get_orders_for_graph_count(array('order_status' => 'In Progress'));
  $count_assigned = fifo_get_orders_for_graph_count(array('order_status' => 'Assigned'));
  $count_urgent = fifo_get_orders_for_graph_count(array('order_status' => 'Urgent'));
  $count_rejected = fifo_get_orders_for_graph_count(array('order_status' => 'Rejected'));
  $count_completed = fifo_get_orders_for_graph_count(array('order_status' => 'Completed'));
  
  if (!empty($count_inprogress)) {
    $result[] = '{"title": "In Progress '.$count_inprogress.'", "count": '.$count_inprogress.', "class": "inprogress" }';
  }
  if (!empty($count_assigned)) { 
    $result[] = '{"title": "Assigned '.$count_assigned.'", "count": '.$count_assigned.', "class": "assigned" }';
  }
  if (!empty($count_urgent))  {
    $result[] = '{"title": "Urgent '.$count_urgent.'", "count": '.$count_urgent.', "class": "urgent" }';
  } 
  if (!empty($count_rejected)) { 
    $result[] = '{"title": "Rejected '.$count_rejected.'", "count": '.$count_rejected.', "class": "rejected" }';
  }  
  if (!empty($count_completed)) { 
    $result[] = '{"title": "Completed '.$count_completed.'", "count": '.$count_completed.', "class": "completed" }';
  }  
  
  return $result;
  
}

function fifo_completed_average_stat($options = array()) {
  
  if (empty($_GET['week'])) {
    $curr_week = gmdate("Y", time()).'-'.gmdate("W", time());
  } else $curr_week = $_GET['week']; 
  
  $week_range = '';
  
  if ($curr_week !== 'all_time') {
    $year_week = explode('-', $curr_week);
    $unix_stamps = getStartAndEndDateInUnix($year_week[1], $year_week[0]);
    
    $week_range = ' and wpm1.meta_value BETWEEN '.$unix_stamps[0].' AND '.$unix_stamps[1].' '; 
  } 
  
  global $wpdb;

  $sql =<<<EEE
    SELECT post_author, AVG(duration) 
      FROM 
      (SELECT 
      	wpp.post_author, 
      	wpm1.meta_value as order_completed,
      	wpm2.meta_value as order_created,
      	(wpm1.meta_value - wpm2.meta_value) as duration
      FROM 
      	$wpdb->posts as wpp
      INNER JOIN 
      	$wpdb->postmeta as wpm1 
      ON 
      	wpm1.post_id = wpp.id and 
      	wpm1.meta_key='order_completed' and
      	wpm1.meta_value is not NULL
      INNER JOIN 
      	$wpdb->postmeta as wpm2
      ON 
      	wpm2.post_id = wpp.id and 
      	wpm2.meta_key='created_time' and
      	wpm2.meta_value is not NULL
      WHERE 
      	wpp.post_type='fiverr_order' and 
      	wpp.post_status='publish' 
      	$week_range
      ) as durations
      
      GROUP BY
      post_author
EEE;
    $results = $wpdb->get_results( $sql, ARRAY_A );

    if (!empty($results)) {
    
      foreach ($results as $row) {
        if ((int)$row['post_author'] > 0 ) {
          $author_to_avg[(int)$row['post_author']] = ceil(floatval($row["AVG(duration)"]));
        }
      }  
    
    }
  
  if (!empty($_GET['fuser']) && intval($_GET['fuser']) > 0) {
    
    $udata = get_userdata( $_GET['fuser'] );
    if (isset($author_to_avg[intval($_GET['fuser'])]))
      return array('labels' => array($udata->display_name), 'values' => array($author_to_avg[intval($_GET['fuser'])]) );
    
  } else {
    if (!empty($author_to_avg)) {
      $users = get_users(array('role' => 'contributor'));
      foreach ($users as $suser) {
        if ($author_to_avg[$suser->ID] > 0) {
          $labels[] = $suser->display_name;
          $values[] = $author_to_avg[$suser->ID];        
        }  
      }
      
      return array('labels' => $labels, 'values' => $values);
    }
  }
  
}

function fifo_completed_stat($options = array()) {
  
  if (empty($_GET['week'])) {
    $curr_week = gmdate("Y", time()).'-'.gmdate("W", time());
  } else $curr_week = $_GET['week'];  

  $week_range = '';

  if ($curr_week !== 'all_time') {
    $year_week = explode('-', $curr_week);
    $unix_stamps = getStartAndEndDateInUnix($year_week[1], $year_week[0]);
    
    $week_range = ' and wpm1.meta_value BETWEEN '.$unix_stamps[0].' AND '.$unix_stamps[1].' '; 
  } 
  
  global $wpdb;  

  $sql =<<<EEE
    SELECT post_author, count(order_completed) 
      FROM 
      (SELECT 
      	wpp.post_author, 
      	wpm1.meta_value as order_completed
      FROM 
      	$wpdb->posts as wpp
      INNER JOIN 
      	$wpdb->postmeta as wpm1 
      ON 
      	wpm1.post_id = wpp.id and 
      	wpm1.meta_key='order_completed' and
      	wpm1.meta_value is not NULL
      WHERE 
      	wpp.post_type='fiverr_order' and 
      	wpp.post_status='publish' 
      	$week_range
      ) as orders
      
      GROUP BY
      post_author
EEE;
    $results = $wpdb->get_results( $sql, ARRAY_A );
    
    if (!empty($results)) {
    
      foreach ($results as $row) {
        if ((int)$row['post_author'] > 0 ) {
          $author_to_count[(int)$row['post_author']] = $row["count(order_completed)"];
        }
      }  
    
    }  
  
  if (!empty($_GET['fuser']) && intval($_GET['fuser']) > 0) {
    $udata = get_userdata( $_GET['fuser'] );
    if (isset($author_to_count[$udata->ID]))
      return array('labels' => array($udata->display_name), 'values' => array($author_to_count[$udata->ID]) );
    
  } else {
    if (!empty($author_to_count)) {
      $users = get_users(array('role' => 'contributor'));
      foreach ($users as $suser) {
        if (isset($author_to_count[$suser->ID])) {
          $labels[] = $suser->display_name;
          $values[] = $author_to_count[$suser->ID];
        }
      }
      
      return array('labels' => $labels, 'values' => $values);
    }
  }
  
}



function fifo_count_orders($all_orders = array()) {
  $count = 0;
  if (!empty($all_orders)) {
    foreach ($all_orders as $weekday => $orders) {
      $count += count($orders);
    }
  }  
  
  return $count;
}

function fifo_week_options() {
  $start_year = 2015;
  $start_week = 45;
  
  $now_year = (int) gmdate("Y", time());
  $now_week = intVal(gmdate("W", time()));
  
  for($i=$now_year; $i>=$start_year; $i-- ) {
    for($j=$now_week; $j>=1; $j-- ) {
      if ($j === 1) $now_week = 53;
      if ($j === $start_week && $i === $start_year) break 2;
      $selected = (!empty($_GET['week']) && $_GET['week'] === $i.'-'.$j && ($_GET['week'] !== 'all_time')) ? 'selected="selected"' : '';
      echo '<option value="'.$i.'-'.$j.'" '.$selected.'>'.implode(' – ', getStartAndEndDate($j, $i)).'</option>';
    }
  }
  
  $selected = (isset($_GET['week']) && $_GET['week'] === 'all_time') ? 'selected="selected"' : '';
  echo '<option value="all_time" '.$selected.'>All time</option>';  
  
}

function getStartAndEndDate($week, $year) {
    
  $week_start = new DateTime();
  $week_start->setISODate($year,$week);
  $return[0] = $week_start->format('d-M-Y');
  $week_end = $week_start->format('U')+6*24*3600;
  $return[1] = date('d-M-Y', $week_end);
  
  return $return;
}

function getStartAndEndDateInUnix($week, $year) {
    
  $week_start = new DateTime();
  $week_start->setTime(0, 0, 0);
  $week_start->setISODate($year,$week);
  $return[0] = (int) $week_start->format('U');
  $return[1] = $return[0]+6*24*3600;
  
  return $return;
}


