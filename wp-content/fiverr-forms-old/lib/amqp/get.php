<?php 
require 'vendor/autoload.php';

$redis_client = new Predis\Client();
//$redis_client->flushAll();

/*
$zip_paths = $redis_client->hGetAll('11947paths');
var_dump($zip_paths);
die;

$allKeys = $redis_client->keys('*'); 
echo '<pre>';
var_dump($allKeys);


foreach ($allKeys as $kkk) {
  
  echo $kkk.'==';
  $type = $redis_client->type($kkk);
  //echo $type;
  if ($type == 'string') {
    echo $redis_client->get($kkk).PHP_EOL;
  } else {
   var_dump($redis_client->hGetAll($kkk));
  } 
}

die; 


$source = array(
  'http://www.gaiaonline.com/journal/?mode=view&post_id=38024057&u=37944047' => '',
  'http://www.gaiaonline.com/journal/?mode=view&post_id=38024053&u=37944047' => '',
  'http://www.gaiaonline.com/journal/?mode=view&post_id=38024045&u=37908129' => '',
  'http://www.gaiaonline.com/journal/?mode=view&post_id=38024061&u=37908129' => '',
  'http://www.blackplanet.com/your_page/blog/manage/posting_list.html?pp=1' => '',
  'https://www.reddit.com/user/JackNellsen111' => '',
);
*/


$allKeys = $redis_client->keys('18049_*'); 
//$allKeys = $redis_client->keys('13921_*'); 
var_dump($allKeys);


foreach ($allKeys as $kkk) {
  echo $redis_client->get($kkk);
}

die; 

$i = 0;
echo '<pre>';
foreach ($source as $url => $data) {
  $ex[]='8528_badlinkstest_'.md5($url);
  if ($redis_client->get('8528_badlinkstest_'.md5($url))) {
    $i++;
    echo $url.'<br />'.PHP_EOL;
    
  } else {
    echo $url.' source=== '.$redis_client->get('8527_badlinkstest_'.md5($url)).'<br />';
  }
}

die; 

foreach ($allKeys as $r) {
 if (!in_array($r, $ex)) echo '<<====>>'.$r;
 //else echo $r; 
}


var_dump($i);

foreach ($allKeys as $key) {
  echo $redis_client->get($key).'<br />';
}
var_dump($allKeys);