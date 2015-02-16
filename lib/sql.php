<?

include "configs.php";

header("Content-type: text/plain; charset=utf-8");
$vars = explode("%%%",file_get_contents("text.txt"));
array_shift($vars);

$i=0;
foreach($vars as $key=>$val) {

	if ($key%2 !== 0) {	$i--; $contents[$i] = $val; }
	else $ids[$val] .= "";
	$i++;
}

$i=0;

foreach($ids as $key=>$val) {

mysql_query("UPDATE `madcms_pages` SET `content_de` = \"" . trim($contents[$i]) . "\" WHERE `id` = '" . trim($key) . "';");
mysql_error();

$i++;
}

// print_r($ids);
// print_r($contents);

?>