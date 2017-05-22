<?php
require 'vendor/autoload.php';
$queue = 'check_url';
$connection = new \PhpAmqpLib\Connection\AMQPConnection('localhost', 5672, 'guest', 'secret2005'); //('10.133.136.54', 5672, 'Administrator', 'z1CpTPIXU6BL');
$channel = $connection->channel();
$channel->queue_declare($queue, false, true, false, false);

//echo ' [*] Waiting for messages. To exit press CTRL+C' . PHP_EOL;

function callback($msg)
{
    global $stop_words;

    try {
        //echo ' [x] Received ' . $msg->body . ' (try: ' . $msg->get('priority') . ')' . PHP_EOL;
        if ((int) $msg->get('priority') > 3) {
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);            
            
            $work_array = explode('_', $msg->body);
            
            $wp_id = array_shift($work_array);
            $filename = array_shift($work_array);
            $url =  implode('_', $work_array);
            
            $redis_client = new Predis\Client();
            $redis_client->set($wp_id.'_'.$filename.'_'.md5($url), 11);
            $redis_client->expire($wp_id.'_'.$filename.'_'.md5($url), 60*60*12);
            
            //echo ' [!] Maximum retries reached at ' . $msg->get('priority') . ' retries' . PHP_EOL;
        } else {
          
            $work_array = explode('_', $msg->body);
            
            $wp_id = array_shift($work_array);
            $filename = array_shift($work_array);
            
            //print_r($work_array);
            $url =  implode('_', $work_array);
  
              $proxy ='';
              
              if (empty($url)) return;
              
              $url = trim($url);
              
              $is_https = (strpos($url, 'https:') !== false) ? true : false;
              
              $ch = curl_init();

              curl_setopt($ch, CURLOPT_URL,$url);
              curl_setopt($ch, CURLOPT_NOBODY, true);
              
              curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36');
              curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); // Time out for a single connection
              curl_setopt($ch, CURLOPT_TIMEOUT, 240); // Curl Process Timeout
              curl_setopt($ch, CURLOPT_MAXREDIRS, 30);
              
              if (!empty($proxy)) {
                curl_setopt($ch, CURLOPT_PROXY, $proxy);
                //curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);
              }
              
              if ($is_https)
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
              
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Follow Redirects If 302
              curl_setopt($ch, CURLOPT_MAXREDIRS, 30); // Max Redirects Allowed
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_HEADER, 1);
              
              $response = curl_exec($ch);  
              
              curl_exec($ch);
              $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              // $retcode >= 400 -> not found, $retcode = 200, found.
              curl_close($ch);  
              #echo "[".$retcode."] ".$url."\r\n";
              //put results in redis  
              $redis_client = new Predis\Client();
              $redis_client->set($wp_id.'_'.$filename.'_'.md5($url), $retcode);
              $redis_client->expire($wp_id.'_'.$filename.'_'.md5($url), 60*60*12);
              
              //error_log(date('Y-m-d H:i:s ').$wp_id.'_'.$filename.'_'.md5($url)."__-+-__".$retcode." ".PHP_EOL, 3, FIFO_PATH.'/worker.log'); //debug

              //echo $wp_id.'_'.$filename.'_'.md5($url)."__-+-__".$retcode.PHP_EOL; //serialize(array($retcode, $url));

            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            //echo PHP_EOL.' [+] Done' . PHP_EOL;
         }
    } catch (Exception $ex) {
          
        $channel = $msg->get('channel');
        $queue = $msg->delivery_info['routing_key'];
        $new_msg = new \PhpAmqpLib\Message\AMQPMessage($msg->body, array(
            'delivery_mode' => 2,
            'priority' => 1 + $msg->get('priority'),
            'timestamp' => time(),
            'expiration' => strval(1000 * (strtotime('+1 day midnight') - time() - 1))
        ));
        $channel->basic_publish($new_msg, '', $queue);

        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        //echo ' [!] ERROR: ' . $ex->getMessage() . PHP_EOL . PHP_EOL;
    }
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume($queue, '', false, false, false, false, 'callback');

function shutdown($channel, $connection)
{
    $channel->close();
    $connection->close();
}

register_shutdown_function('shutdown', $channel, $connection);

while (count($channel->callbacks)) { //
    $channel->wait();
}
