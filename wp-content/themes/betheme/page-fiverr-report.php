<?php
/**
Template Name: Fiverr Report
 */

//get_header(); 

require_once FIFO_PATH.'/GPageRank.php';

define('MOZ_API', 'mozscape-9b8687f7f3');                           // Write your moz API ID here.
define('MOZ_SECRET_KEY', 'ce4eb7e527539c9e025780dcbdd3fd3e');       // Write your moz Secret KEY here.

function fifo_show_report( $pid = null ) {
  $order = (!empty($pid)) ? $pid : $_REQUEST['pid']; 
  if (empty($order)) return;

  $fastDelivery = false;
  $gigExtra = array();

  $acf_fields = get_fields($order);
  $orderID = $acf_fields['order_number'];
  
  if ($orderID !== $_REQUEST['fo']) return;
  
  $username = $acf_fields['fiverr_username'];
  $fullName = $acf_fields['full_name'];
  
  if (empty($fullName)) $fullName = $username;
  
  $gigsOrdered = (!empty($acf_fields['basic_gigs_ordered'])) ? $acf_fields['basic_gigs_ordered'] : 1;
  $website = null;
  if(isset($acf_fields['site_url'][0]['url'])){
  $website = $acf_fields['site_url'][0]['url']; // get only first site.
  }
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
  
  $full_url = $website;
  
  // get root website from url
  $urlParse = parse_url($website);

  $domain = explode('.', $urlParse['host']);
  if(sizeof($domain) == 3){
      $root = $domain[1].'.'.$domain[2];
  }
  else{
      $root = $urlParse['host'];
  }
  $website = $root;
  // end get root website from url
  
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

  
  $pageRank = get_post_meta($order, 'PR', true);
  
  if (empty($pageRank)) {

    $pageRank = fifo_get_url_pr($website);
    
    update_post_meta($order, 'PR', $pageRank);
  
  }
  
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
              $originalList[] = trim($singleLink);
          }
      }
  }

  if($acf_fields['fast_delivery'] === true )
  {
      $fastDelivery = true;
  } 

  if($acf_fields['gig_extra'] && $acf_fields['gig_extra'] != 'Choose Extra GIG')
  {
      $gigExtra = $acf_fields['gig_extra'];
  } 
  
  ///////////////////////////////////
  $givenBackLinks = get_post_meta($order, 'given_backlinks', true);
  
  if (empty($givenBackLinks)) {
    $expires = time() + 300;
    $stringToSign = MOZ_API . "\n" . $expires;
    $binarySignature = hash_hmac('sha1', $stringToSign, MOZ_SECRET_KEY, true);
    $urlSafeSignature = urlencode(base64_encode($binarySignature));
    $cols = "103079231524";
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
  
    $givenBackLinks = json_decode($content);
    
    update_post_meta($order, 'given_backlinks', $givenBackLinks);
  
  }
  
  $givenBackLinkPR = get_post_meta($order, 'given_backlinksPR', true);

  if (empty($givenBackLinkPR)) {
  
    $givenBackLinkPR = array();
    if($batchedDomains){
        foreach($batchedDomains as $link)
        {
          $givenBackLinkPR[] = fifo_get_url_pr($link);
        }
    }
    
    update_post_meta($order, 'given_backlinksPR', $givenBackLinkPR );
  
  }
  
  
  
  $overView = get_post_meta($order, 'overView', true);
  if (empty($overView)) {
  
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
  
  }
  
/*
  if (!file_exists(FIFO_PATH.'/reports/'.$orderID.'_back_link_list.csv')) {
    
    //generate backlinks.csv
    $output = fopen(FIFO_PATH.'/reports/'.$orderID.'_back_link_list.csv', 'w');
    fputcsv($output, array('URL'));
    foreach ($originalList as $line) {
      fputcsv($output, array($line));
    }  
    
    fclose($output);  
    @chown(FIFO_PATH.'/reports/'.$orderID.'_back_link_list.csv', SERVERUSER);
    //end generate backlinks.csv
    
  }
*/
  
/*
$fullName 
$username  
$orderID
$gigsOrdered
$website
$keywords
$gigExtra
$overView +
$pageRank +
$givenBackLinks +
$givenBackLinkPR +
$originalList 
*/
  

  require FIFO_PATH.'/template.php';
  
}

fifo_show_report();
