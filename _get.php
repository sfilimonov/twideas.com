<?
require_once './inc/config.php';

$main_tag_id = isset($_POST['main_tag_id']) ? intval($_POST['main_tag_id']) : 0;
$tag_id = isset($_POST['tag_id']) ? intval($_POST['tag_id']) : 0;
$featured = isset($_POST['featured']) ? intval($_POST['featured']) : 0;
$tweet_filter = isset($_POST['tweet_filter']) ? intval($_POST['tweet_filter']) : 0;
$start = isset($_POST['start']) ? intval($_POST['start']) - 30 : 0;
if ($start < 0) $start = 0;


$wheref = '';

if ($tweet_filter == 1) $wheref = " AND created_at >= '".(time() - 30*24*3600)."' ";
if ($tweet_filter == 2) $wheref = " AND retweets > 0 ";

$where = '';



if (!empty($tag_id)) $where .= " AND id IN (SELECT tweet_id FROM tag2tweet WHERE tag_id='{$tag_id}') ";

$query = "SELECT * FROM tweets WHERE (main_tag_id={$main_tag_id} OR main_tag_id=3) {$wheref} {$where} AND published=1 ORDER BY created_at DESC LIMIT {$start}, 30;";


$result = $db->select($query);

$i = 1;

while ($row = $result->FetchArray()) {
	echo '<div id="'.$row['id'].'" class="twideas">';
	echo '<div class="stream-item-header">';
	if (!empty($row['profile_image_url'])) echo '<img src="'.stripslashes($row['profile_image_url']).'" border="0" class="avatar" />';
	echo '<small class="time">'.date('d.m.Y H:i', $row['created_at']).'</small>';
	
	if (!empty($row['from_user_name'])) echo '<div class="un">'.stripslashes($row['from_user_name']).'</div>';
	if (!empty($row['from_user'])) echo '<div class="un2">@'.stripslashes($row['from_user']).'</div>';
	echo '<div class="t">'.stripslashes($row['text']).($row['retweets'] > 0 ? '<div class="retweeted">Retweeted: '.$row['retweets'].'</div>' : '').'</div>';
	
	echo '</div>';
	echo '</div>';
	
	$i++;
	if ($i % 30 == 0) {
		echo '<div id="'.$row['id'].'" class="twideas phrases">';
		echo $config['phrases'][rand(0, count($config['phrases']) - 1)];
		echo '</div>';
	}
}

?>