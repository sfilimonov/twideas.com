<?
require_once './inc/config.php';



$main_tag_id = isset($_POST['main_tag_id']) ? intval($_POST['main_tag_id']) : 1;
$featured = isset($_POST['featured']) ? intval($_POST['featured']) : 0;

$query = "SELECT * FROM tags WHERE c{$main_tag_id} > 0 AND name NOT IN (".implode(',', $config['badtags']).") ".(empty($featured) ? '' : " AND name IN (".implode(',', $config['featured'][$main_tag_id]).")")." ORDER BY c{$main_tag_id} DESC LIMIT 40;";

$result = $db->select($query);
while ($row = $result->FetchArray()) echo '<li><a href="'.$config['maintags'][$main_tag_id].'#'.$row['name'].'" rel="'.$row['id'].'" class="tagpost">#'.stripslashes($row['name']).'</a></li> ';

?>