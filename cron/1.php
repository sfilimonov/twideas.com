<?
require_once '/var/www/vhosts/twideas.com/httpdocs/inc/config.php';


$query = "SELECT * FROM tags ORDER BY id;";
$result = $db->select($query);
$tags = array();
while ($row = $result->FetchArray()) $tags[stripslashes($row['name'])] = $row['id'];











$query = "select * from tweets order by id asc";
$result = $db->select($query);
while ($row = $result->FetchArray()) {
preg_match_all('/(#[\w\d]+)/', $row['text'], $out);
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
	$query = "UPDATE tweets SET main_tag_id='{$main_tag_id}' WHERE id='{$row['id']}';";
	echo $query.'<br>';
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
			
			$query = "INSERT IGNORE INTO tag2tweet (tag_id, main_tag_id, tweet_id) VALUES ('{$tag_id}', '{$main_tag_id}', '{$row['id']}')";
			$db->ExecSQL($query);
			
			if (!empty($main_tag_id)) {

				$query = "UPDATE tags SET c1=(SELECT COUNT(*) FROM tag2tweet WHERE tag_id=tags.id AND (main_tag_id=1 OR main_tag_id=3)), c2=(SELECT COUNT(*) FROM tag2tweet WHERE tag_id=tags.id AND (main_tag_id=2 OR main_tag_id=3)) WHERE id='{$tag_id}';";
				$db->ExecSQL($query);
			
			}
		}
	}
	

	
}
		
}		
		
	



?>