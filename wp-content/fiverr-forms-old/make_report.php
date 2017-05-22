<?php 
  
require_once 'GPageRank.php';

define('MOZ_API', 'mozscape-9b8687f7f3');                           // Write your moz API ID here.
define('MOZ_SECRET_KEY', 'ce4eb7e527539c9e025780dcbdd3fd3e');       // Write your moz Secret KEY here.

if (!file_exists(FIFO_PATH.'/reports')) {
    mkdir(FIFO_PATH.'/reports', 0755, true);
} 

if (!file_exists(FIFO_PATH.'/reports/index.php')) {
  file_put_contents(FIFO_PATH.'/reports/index.php', '<?php //silence is golden');
}

if (!file_exists(FIFO_PATH.'/reports/.htaccess')) {
  file_put_contents(FIFO_PATH.'/reports/.htaccess', 'Options -Indexes');
}

add_action( 'wp_ajax_make_report', 'fifo_make_report' );

function fifo_make_report( $pid = null ) {
  define('DOING_AJAX', true);
  $response['state'] = 'error';
  
  $order = (!empty($pid)) ? $pid : $_REQUEST['pid']; 

  $fastDelivery = false;
  $gigExtra = array();

  $acf_fields = get_fields($order);
  $orderID = $acf_fields['order_number'];
  $username = $acf_fields['fiverr_username'];
  $fullName = $acf_fields['full_name'];
  
  if (empty($fullName)) $fullName = $username;
  
  $gigsOrdered = (!empty($acf_fields['basic_gigs_ordered'])) ? $acf_fields['basic_gigs_ordered'] : 1;
  //error_log(PHP_EOL.date('Y-m-d H:i:s')." SSSSSSSSS website ".var_export($acf_fields['site_url'], 1).PHP_EOL, 3, FIFO_PATH.'/report-generator.log');  
  
  $website = null;
  
  if (isset($acf_fields['site_url'][0]['url']))
    $website = $acf_fields['site_url'][0]['url']; // get only first site.
  
  if (empty($website)) { // fix for old format for urls
    $site_url_text = $acf_fields['site_url_unformated'];
    preg_match_all('/(https?:\/\/?[^\s\,\;\t\r\n]*)/i',$site_url_text,$matches,PREG_PATTERN_ORDER);


    $urls = array();
    if(!empty($matches[0]) && is_array($matches[0])) {
      foreach($matches[0] as $url)
        $urls[] = array('url'=>$url);
      
      $website = $urls[0]['url'];    
    }
  }
  
  $keywords = array();
  foreach ($acf_fields['keywords'] as $key) {
    $keywords[] = $key['keyword'];
  }
  
  $keywords = implode(', ', $keywords);
  
  $backlink = $acf_fields['backlinks'];
  
  $registrations = get_post_meta($order, 'registrations', true);
  
  $profiles = '';
  if (!empty($registrations)) {
    foreach ($registrations as $sr) {
      $profiles .= $sr['profile_url']."\n";
    }
  }
  
  // add registered profiles urls  
  $backlink = $backlink."\n".$profiles;
  
  $full_url = $website;

  // get root website from url
  $urlParse = parse_url(trim($website));

  $domain = explode('.', $urlParse['host']);
  if(sizeof($domain) == 3){
      $root = $domain[1].'.'.$domain[2];
  }
  else{
      $root = $urlParse['host'];
  }
  $website = $root;
  // end get root website from url

  $gtb = new GTB_PageRank($website);
  $pageRank = (int) $gtb->getPageRank();
  
  update_post_meta($order, 'PR', $pageRank);
  
  $batchedDomains = array();
  $originalList = array();


  if($backlink)
  {
      $backlink = str_replace('http://', 'URL_SPCAE_http://', $backlink);
      $backlink = str_replace('https://', 'URL_SPCAE_https://', $backlink);
      $backlink = explode('URL_SPCAE_', $backlink);
      foreach($backlink as $singleLink)
      {
          if($singleLink && $singleLink != '')
          {
              $urlParse = parse_url(trim($singleLink));

              $domain = explode('.', $urlParse['host']);
              if(sizeof($domain) == 3){
                  $root = $domain[1].'.'.$domain[2];
              }
              else{
                  $root = $urlParse['host'];
              }
              $batchedDomains[] = $root;
              $originalList[] = $singleLink;
          }
      }
  }
  

  //error_log(date('Y-m-d H:i:s')." to check pr ".var_export($batchedDomains, 1).PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
  if($acf_fields['fast_delivery'] === true )
  {
      $fastDelivery = true;
  } 

  if($acf_fields['gig_extra'] && $acf_fields['gig_extra'] != 'Choose Extra GIG')
  {
      $gigExtra = $acf_fields['gig_extra'];
  } 
  
  ///////////////////////////////////
  
  $expires = time() + 300;
  $stringToSign = MOZ_API . "\n" . $expires;
  $binarySignature = hash_hmac('sha1', $stringToSign, MOZ_SECRET_KEY, true);
  $urlSafeSignature = urlencode(base64_encode($binarySignature));
  $cols = "103079231524";
  //$backCols = "103079231492";
  $limit = 2;
  
  $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/?Cols=".$cols."&AccessID=".MOZ_API."&Expires=".$expires."&Signature=".$urlSafeSignature;

  $encodedDomains = json_encode($batchedDomains);
  $options = array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POSTFIELDS     => $encodedDomains
  );
  $ch = curl_init($requestUrl);
  curl_setopt_array($ch, $options);
  $content = curl_exec($ch);
  curl_close( $ch );
  //error_log(date('Y-m-d H:i:s')." checked moz urls ".var_export($batchedDomains, 1).PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
  //error_log(date('Y-m-d H:i:s')." checked moz ".$content.PHP_EOL, 3, FIFO_PATH.'/report-generator.log');
  $givenBackLinks = json_decode($content);
  
  update_post_meta($order, 'given_backlinks', $givenBackLinks);
  
  //error_log(date('Y-m-d H:i:s')." Start PR checking ".PHP_EOL, 3, FIFO_PATH.'/fff.log');
  
  $givenBackLinkPR = array();
  if($batchedDomains){
      foreach($batchedDomains as $link)
      {
          $gtb = new GTB_PageRank($link);
          //error_log(date('Y-m-d H:i:s')." PR==== ".$gtb->getPageRank().' LINK ==='.$link.PHP_EOL, 3, FIFO_PATH.'/fff.log');
          $givenBackLinkPR[] = (int) $gtb->getPageRank();
      }
  }
  
  update_post_meta($order, 'given_backlinksPR', $givenBackLinkPR );
  
  $mainDomain = "http://lsapi.seomoz.com/linkscape/url-metrics/".$website."?Cols=".$cols."&Limit=".$limit."&AccessID=".MOZ_API."&Expires=".$expires."&Signature=".$urlSafeSignature;
  $options = array(
      CURLOPT_RETURNTRANSFER => true
  );
  $ch = curl_init($mainDomain);
  curl_setopt_array($ch, $options);
  $content = curl_exec($ch);
  curl_close($ch);
  $overView = json_decode($content);
  
  update_post_meta($order, 'overView', $overView);
  
  
/*
  //generate backlinks.csv
  $output = fopen(FIFO_PATH.'/back_link_list.csv', 'w');
  fputcsv($output, array('URL'));
  foreach ($originalList as $line) {
    fputcsv($output, array($line));
  }  
  
  fclose($output);  
  chown(FIFO_PATH.'/back_link_list.csv', SERVERUSER);
  //end generate backlinks.csv
*/

  
  ob_start();

  require('template.php');

  if ( ob_get_length() > 0 )
  {
    $report = ob_get_contents();
    file_put_contents(FIFO_PATH."/$orderID.html", $report);
    chown(FIFO_PATH."/$orderID.html", SERVERUSER);
  }

  ob_end_clean(); 
  
  // create zip archive for report
  //$files_to_zip = array_diff(fifo_getDirContents(FIFO_PATH.'/assets'), array('..', '.'));
  //$files_and_dirs = fifo_getDirContents(FIFO_PATH.'/assets');

  //$files_to_zip = $files_and_dirs['files'];

  
  $files_to_zip[] = FIFO_PATH."/$orderID.html";
  //$files_to_zip[] = FIFO_PATH.'/back_link_list.csv';
  
  $result = fifo_create_zip($files_to_zip, FIFO_PATH."/reports/$orderID.zip", $orderID, FIFO_PATH, true);
  
  unlink(FIFO_PATH."/$orderID.html");
  //@unlink(FIFO_PATH.'/back_link_list.csv');
  @chown(FIFO_PATH."/reports/$orderID.zip", SERVERUSER);
  
  $response['path'] = FIFO_PATH."/reports/$orderID.zip";
  
  $response['state'] = 'ok';
  
  // end create zip archive for report            

  if (empty($pid)) { // if called as ajax

    header( "Content-Type: application/json" );
    echo json_encode($response);
  
    exit; 
  } else {
    return array( 'url' => FIFO_URL."/reports/$orderID.zip", 'path' => FIFO_PATH."/reports/$orderID.zip" );
  }
}

add_action( 'wp_ajax_fiverr_update_stats', 'fifo_update_stats' );
add_action( 'wp_ajax_nopriv_fiverr_update_stats', 'fifo_update_stats' );

function fifo_update_stats() {
  
  define('DOING_AJAX', true);
  
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');  
  header( "Content-Type: application/json" );
  
  $url = $_REQUEST['url'];
  //echo $url;

  $response['path'] = $_REQUEST['url'];


  $expires = time() + 300;
  $stringToSign = MOZ_API . "\n" . $expires;
  $binarySignature = hash_hmac('sha1', $stringToSign, MOZ_SECRET_KEY, true);
  $urlSafeSignature = urlencode(base64_encode($binarySignature));
  $cols = "103079215136";
  $limit = 21;
  
  $mainDomain = "http://lsapi.seomoz.com/linkscape/url-metrics/" . $url . "?Cols=" . $cols . "&Limit=" . $limit . "&AccessID=" . MOZ_API . "&Expires=" . $expires . "&Signature=" . $urlSafeSignature;
  $options = array(
      CURLOPT_RETURNTRANSFER => true
  );
  $ch = curl_init($mainDomain);
  curl_setopt_array($ch, $options);
  $content = curl_exec($ch);
  curl_close($ch);
  $content = json_decode($content);
  
  if($content) {
    $gtb = new GTB_PageRank($url);
    $pageRank = (int) $gtb->getPageRank();
    $pageRank = (int) $gtb->getPageRank();
  
    $data = array(
        'page_auth' => number_format($content->upa, 2),
        'domain_auth' => number_format($content->pda, 2),
        'page_rank' => $pageRank,
        'backlink' => $content->ueid,
    );
    
    echo json_encode($data);
  }
  exit; 
  
}

add_action('acf/save_post', 'fifo_generate_report');

function fifo_generate_report( $post_id ) {
	
	// bail early if not a fiverr_order
	if( get_post_type($post_id) !== 'fiverr_order' ) 	return;	
	$full_name = get_field('full_name', $post_id);
	if (!empty($full_name))	{	
  	fifo_make_report($post_id);
    update_post_meta($post_id, '_generated', 'yes');
  }
	
}
