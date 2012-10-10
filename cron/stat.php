<?
require_once '/var/www/vhosts/twideas.com/httpdocs/inc/config.php';
set_time_limit(0);

$query = "SELECT id FROM tweets WHERE created_at >= '".(time() - 3*24*3600)."' AND published=1 ORDER BY created_at ASC;";
$result = $db->select($query);

$ids = array();
while ($row = $result->FetchArray()) $ids[] = $row['id'];

$query = "SELECT id FROM tweets WHERE id IN (".implode(',', $ids).") ORDER BY retweets_time ASC LIMIT 20;";
$result = $db->select($query);


while ($row = $result->FetchArray()) {
	
	$url = "https://api.twitter.com/1/statuses/show.json?id={$row['id']}&include_entities=true";
	//echo $url.'<br>';
	
	$handle = @curl_init($url);
	if (!$handle) {
		echo 'error';
		continue;
	}
		

	curl_setopt($handle, CURLOPT_HEADER, 0);
	curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($handle, CURLOPT_TIMEOUT, 30);
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);


	$response = curl_exec($handle);

	curl_close($handle);

	if (!empty($response)) {

		$response = json_decode($response);
		//print_r($response);
		$query = "UPDATE tweets SET retweets='{$response->retweet_count}', retweets_time='".time()."' WHERE id='{$row['id']}';";
		echo $query.'<br>';
		$db->ExecSQL($query);
		
	}
	
}



echo 'end';




?>