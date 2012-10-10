<?



require_once '/var/www/vhosts/twideas.com/httpdocs/inc/config.php';


$words_bad_arr = array('bitch', 'lol', 'dick', 'fuck', 'fack', 'sex', 'doll', '!!', 'Vodafone', 'IDEA%20ads', 'tits', 'Dairymilk', 'Wanna', 'shit'); 
$exceptions_arr = array('-http', '-RT ');

$words = implode(' OR ', $config['maintags']);
$exceptions = implode(' ', $exceptions_arr);


$query = "SELECT MAX(id) FROM tweets";
$result = $db->select($query);
$since_id = $result->Value();
//$since_id = 0;


$search_url = "http://search.twitter.com/search.json?q=".urlencode("{$words} {$exceptions} lang:en")."&result_type=recent&rpp=100&include_entities=false&since_id={$since_id}";

//echo $search_url;

$handle = @curl_init($search_url);
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

$query = "SELECT * FROM tags ORDER BY id;";
$result = $db->select($query);
$tags = array();
while ($row = $result->FetchArray()) $tags[stripslashes($row['name'])] = $row['id'];

	$result = json_decode($response);

	foreach ($result->results as $k => $v) {
	
		if (strpos($v->text, 'http') !== false || strpos($v->text, '@') !== false) continue;
		
		if (preg_match('/'.implode('|', $words_bad_arr).'/i', $v->text)) continue;
		
		$query = "SELECT id FROM tweets WHERE `text`='".addslashes($v->text)."'";
		$result = $db->select($query);
		$id = $result->Value();
		
		if (!empty($id)) continue;
		
		
		$query = "SELECT id FROM tweets WHERE from_user_id='".addslashes($v->from_user_id)."' AND created_at>'".(time() - 3600*12)."';";
		$result = $db->select($query);
		while ($row = $result->FetchArray()) {
			$query = "UPDATE tweets SET published=0 WHERE id='{$row['id']}';";
			$db->ExecSQL($query);
		}
		
		if (count(explode(' ', $v->text)) < 4) continue;
		
		preg_match_all('/(#[\w\d]+)/', $v->text, $out);

		$parsed_date = strtotime($v->created_at);
		
		
		
		if (count($out[1]) > 4) continue;
		
		$tag_len = 0;
		
		foreach ($out[1] as $v2) $tag_len += strlen($v2);
		
		if (round(100 * $tag_len / strlen($v->text)) > 50) continue;
		
		

		$query = "INSERT IGNORE INTO tweets (id, from_user, from_user_id, from_user_name, profile_image_url, created_at, `text`) VALUES ('{$v->id_str}', '".addslashes($v->from_user)."', '".addslashes($v->from_user_id)."', '".addslashes($v->from_user_name)."', '".addslashes($v->profile_image_url)."', '{$parsed_date}', '".addslashes($v->text)."')";
		
		
		
		$db->ExecSQL($query);
		
		

		$main_tags = array();
		
		if (!empty($out[1])) {
		
			foreach ($out[1] as $v2) {
				$v2 = strtolower($v2);
				if (in_array($v2, $config['maintags'])) {
					$t = array_search($v2, $config['maintags']);
					$main_tags[$t] = true;
				}
			}
			
			$main_tag_id = 0;
			foreach (array_keys($main_tags) as $v2) $main_tag_id += $v2;
			$query = "UPDATE tweets SET main_tag_id='{$main_tag_id}' WHERE id='{$v->id_str}';";
			$db->ExecSQL($query);
		
			foreach ($out[1] as $v2) {
				$v2 = strtolower($v2);
				if (!in_array($v2, $config['maintags'])) {
					$v2 = preg_replace('/#/', '', $v2);
					if (isset($tags[$v2])) $tag_id = $tags[$v2];
					else {
						$query = "INSERT INTO tags (name) VALUES ('".addslashes($v2)."')";
						$db->ExecSQL($query);
						$tag_id = $db->GetInsertID();
						$tags[$v2] = $tag_id;
					}
					
					$query = "INSERT IGNORE INTO tag2tweet (tag_id, main_tag_id, tweet_id) VALUES ('{$tag_id}', '{$main_tag_id}', '{$v->id_str}')";
					$db->ExecSQL($query);
					
					if (!empty($main_tag_id)) {

						$query = "UPDATE tags SET c1=(SELECT COUNT(*) FROM tag2tweet WHERE tag_id=tags.id AND (main_tag_id=1 OR main_tag_id=3)), c2=(SELECT COUNT(*) FROM tag2tweet WHERE tag_id=tags.id AND (main_tag_id=2 OR main_tag_id=3)) WHERE id='{$tag_id}';";
						$db->ExecSQL($query);
					
					}
				}
			}
			

			
		}
		
		
		
	}

}


?>