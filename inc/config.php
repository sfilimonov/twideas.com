<?

define ("_DBHOST", "localhost");
define ("_DBNAME", "twideas");
define ("_DBUSER", "twideas");
define ("_DBPASS", "hard39");

$config['path']['home'] = '/var/www/vhosts/twideas.com/httpdocs';
$config['path']['inc']  = $config['path']['home']."/inc/";

$config['maintags'] = array(1 => '#idea', 2=> '#twidea');
$config['featured'] = array(
1 => array("'Startup'", "'Business'", "'Music'", "'Space'", "'App'", "'Website'"),
2 => array("'romney'", "'germany'", "'syrian'", "'europe'", "'japan'", "'libya'", "'2012gc'", "'news'", "'bahrain'")
);
 
$config['badtags'] = array("'i'", "'lol'", "'no'", "'bad'", "'good'", "'ideas'", "'hashtag'", "'worst'", "'best'", "'crazy'", "'dream'", "'great'", "'fail'", "'wtf'", "'3g'", "'sex'", "'fuck'", "'Vodafone'", "'emergingtalk!'", "'emergingtalk'", "'intellij'", "'fb'", "'a'", "'ipl'", "'ipl5'", "'docomo'", "'airtel'", "'gonna'", "'goood'");

$config['phrases'] = array(
0 => "People who are crazy enough to think they can change the world<br> are the ones who do. – Apple's Commercial",
1 => 'Fail but fall forward. – Denzel Washington',
2 => 'If you want something you never had, do something you never did.',
3 => 'Innovation distinguishes between a leader and a follower. – Steve Jobs',
4 => 'Insanity: doing the same thing over and over again <br>and expecting different results. – Albert Einstein',
5 => "I can't understand why people are frightened of new ideas. <br>I'm frightened of the old ones. – John Cage",
6 => 'The more you think, the more you stink',
7 => 'You can accomplish anything in life, provided that you do not mind who gets the credit. – Harry S. Truman',
8 => 'A man may die, nations may rise and fall, but an idea lives on. Ideas have endurance without death. – John F. Kennedy',

);


require_once $config['path']['inc'].'db_sql.php';
$db = new db(_DBHOST, _DBNAME, _DBUSER, _DBPASS);

?>