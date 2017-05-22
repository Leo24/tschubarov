<?php
  
$wp_path = substr(__DIR__, 0, strpos(__DIR__, '/wp-content/plugins'));
require($wp_path.'/wp-load.php');    
  
require 'vendor/autoload.php';

$rep_queue = 'rabbit_gen_report';
$rep_connection = new \PhpAmqpLib\Connection\AMQPConnection('localhost', 5672, 'guest', 'secret2005');
$rep_channel = $rep_connection->channel();
$rep_channel->queue_declare($rep_queue, false, true, false, false);

//echo ' [*] Waiting for messages. To exit press CTRL+C' . PHP_EOL;

function rep_callback($msg)
{

    try {
      //echo ' [x] Received ' . $msg->body . ' (try: ' . $msg->get('priority') . ')' . PHP_EOL;
      //$file_abs_path.'=-='.$fname.'=-='.$order_id.'=-='.$wp_post_id  
      $work_array = explode('=-=', $msg->body); 
      
      
      $file_abs_path = array_shift($work_array);
      $fname = array_shift($work_array);
      $order_id = array_shift($work_array);
      $wp_post_id = array_shift($work_array);
      $pid = array_shift($work_array);
      
      error_log(date('Y-m-d H:i:s ').' pid='.$pid.' wp_post_id='.$wp_post_id.' order_id='.$order_id."__-+-__"." ".PHP_EOL, 3, FIFO_PATH.'/report_worker.log'); //debug
    
      $zip = fifo_generate_single_report($wp_post_id);
      
      //put results in redis  
      $redis_client = new Predis\Client();
      $redis_client->set($pid.'_'.$order_id, serialize( array(
          'fiverr_order_id' => $order_id , 
          'fname' => $fname,
          'abs_path' => $file_abs_path, 
          'wp_order_id' => $wp_post_id, 
          'zip' => $zip['url'],
          'zip_path' => $zip['path'],
          'html' => '<code>'.$fname.'</code> <span>Report generated</span> <a href="/report?pid='.$wp_post_id.'&fo='.$order_id.'" target="_blank">View</a><br />',
          ) ) );
      $redis_client->expire($pid.'_'.$order_id, 60*60*12);
      
      //error_log(date('Y-m-d H:i:s')." SAVE ZIP PATH === ".$zip['path'].PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
      
      $redis_client->hSet($pid.'paths', $order_id, $zip['path']);
        
      //error_log(date('Y-m-d H:i:s ').$wp_id.'_'.$filename.'_'.md5($url)."__-+-__".$retcode." ".PHP_EOL, 3, FIFO_PATH.'/worker.log'); //debug

      $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
      //echo PHP_EOL.' [+] Done' . PHP_EOL;
      
    } catch (Exception $ex) {
      $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
      echo ' [!] ERROR: ' . $ex->getMessage() . PHP_EOL . PHP_EOL;
    }
};

$rep_channel->basic_qos(null, 1, null);
$rep_channel->basic_consume($rep_queue, '', false, false, false, false, 'rep_callback');

function rep_shutdown($rep_channel, $rep_connection)
{
  $rep_channel->close();
  $rep_connection->close();
}

register_shutdown_function('rep_shutdown', $rep_channel, $rep_connection);

while (count($rep_channel->callbacks)) { 
  $rep_channel->wait();
}
