<?php 
  
  //update_option('order_report_queue', array(7833 => 7833));
  //update_option('run_reports_generator', 'stopped');
  //update_option('run_backlinks_checker', 'stopped');
  //var_dump(get_option('run_reports_generator'));
  
  set_time_limit(0);
  
  $wp_path = substr(__DIR__, 0, strpos(__DIR__, '/wp-content/plugins'));
  require($wp_path.'/wp-load.php');  

  fifo_get_status();
  fifo_reports_status();
  
  fifo_check_registering_status();