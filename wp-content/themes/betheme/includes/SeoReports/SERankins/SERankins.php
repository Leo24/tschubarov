<?php

/**
 * @return mixed
 */
function loginToSERanking(){
	$apiCreads = getSeoApiCreads();
	$login = $apiCreads['se_ranking_username'];
	$password = md5($apiCreads['se_ranking_password']);

	$loginUrl = 'http://online.seranking.com/structure/clientapi/v2.php?method=login&login='.$login.'&pass='.$password;

	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	$ch = curl_init($loginUrl);
	curl_setopt_array($ch, $options);
	$authData = curl_exec($ch);
	curl_close($ch);
	$authData = json_decode($authData, true);
	return $authData['token'];
}

/**
 * @param $websiteUrl
 *
 * @return array|mixed|object
 */
function addSiteToSERanking($websiteUrl){
	$authToken  = loginToSERanking();
	$apiUrl = 'http://online.seranking.com/structure/clientapi/v2.php?method=addSite&token='.$authToken;
	$curlHandler = curl_init($apiUrl);
	curl_setopt($curlHandler, CURLOPT_POST, 1);
	$data = [
		'url' => $websiteUrl,
		'title' => removehttp($websiteUrl),
	];
	curl_setopt($curlHandler, CURLOPT_POSTFIELDS, http_build_query(array('data' => json_encode($data))));
	curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($curlHandler);
	return json_decode($result, true);
}

/**
 * @param $siteID
 * @param $keywords
 *
 * @return array|mixed|object
 */

function addSiteKeywordsToSERanking($siteID, $keywords){
	$authToken  = loginToSERanking();
	$apiUrl = 'http://online.seranking.com/structure/clientapi/v2.php?method=addSiteKeywords&token='.$authToken;
	$curlHandler = curl_init($apiUrl);
	curl_setopt($curlHandler, CURLOPT_POST, 1);
	$data = [
		'siteid' => $siteID,
		'keywords' => $keywords,
	];
	curl_setopt($curlHandler, CURLOPT_POSTFIELDS, http_build_query(array('data' => json_encode($data))));
	curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($curlHandler);
	return json_decode($result, true);
}

/**
 * @param $siteID
 *
 * @return array|mixed|object
 */

function serankingKeywordsData($siteID){
	$authToken = loginToSERanking();
	$regions = searchVolumeRegions();
	$keywordsUrl = 'http://online.seranking.com/structure/clientapi/v2.php?method=siteKeywords&siteid='.$siteID.'&token='.$authToken;
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	$ch = curl_init($keywordsUrl);
	curl_setopt_array($ch, $options);
	$siteKeywords = curl_exec($ch);
	curl_close($ch);
	return json_decode($siteKeywords, true);
}

/**
 * @return array|mixed|object
 */
function searchVolumeRegions(){
	$authToken = loginToSERanking();
	$keywordsUrl = ' http://online.seranking.com/structure/clientapi/v2.php?method=searchVolumeRegions&token='.$authToken;
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	$ch = curl_init($keywordsUrl);
	curl_setopt_array($ch, $options);
	$regions = curl_exec($ch);
	curl_close($ch);
	return json_decode($regions, true);
}

function keywordStats($siteID, $dateStart, $dateEnd){
	$authToken = loginToSERanking();
	$keywordsUrl = 'http://online.seranking.com/structure/clientapi/v2.php?method=stat&siteid='.$siteID.'&dateStart='.$dateStart.'&dateEnd='.$dateEnd.'&token='.$authToken;
	$options = array(
		CURLOPT_RETURNTRANSFER => true
	);
	$ch = curl_init($keywordsUrl);
	curl_setopt_array($ch, $options);
	$stats = curl_exec($ch);
	curl_close($ch);
	$stats = json_decode($stats, true);
	$keywordsNames = serankingKeywordsData($siteID);
	foreach($stats[0]['keywords'] as $key => &$value){
		foreach($keywordsNames as $k => $v){
			if($value['id'] == $v['id']){
				$value['keyword_name'] = $v['name'];
			}
		}
	}
	return $stats;
}


/**
 * @param $text
 *
 * @return array
 */

function textareaToArray($text){
	$textAr = explode("\n", $text);
	$textAr = array_filter($textAr, 'trim');

	foreach ($textAr as $line) {
		$result[] = $line;
	}
	return $result;
}


/**
 * @param $url
 *
 * @return string
 */
function addhttp($url) {
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
		$url = "http://" . $url;
	}
	return $url;
}

/**
 * @param $url
 *
 * @return mixed
 */
function removehttp($url) {
	$disallowed = array('http://', 'https://');
	foreach($disallowed as $d) {
		if(strpos($url, $d) === 0) {
			return str_replace($d, '', $url);
		}
	}
	return $url;
}