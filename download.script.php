<?php
require_once __DIR__.'/header.php';

if(empty($_GET['locale'])) exit;
$locale = $mysqli->real_escape_string($_GET['locale']);

$sql = "SELECT `msgid`.`msgid`,`msgstr`.`str`
	FROM `msgid`
	LEFT JOIN `msgstr` ON `msgid`.`id` = `msgstr`.`msgid_id` AND `msgstr`.`locale` = '$locale'
	WHERE `msgstr`.`str` IS NULL OR `msgstr`.`str` = ''
	ORDER BY `msgid`.`id`";
$query = $mysqli->query($sql);

$out = '';

while($rs = $query->fetch_object()) {
	$out .= utf8_decode($rs->msgid." => ");
	$out .= utf8_decode('"'.$rs->str.'"'.PHP_EOL);
}

header('Content-type: text/plain; charset=utf-8');
header('Content-disposition: attachment; filename="locale-'.$locale.'-'.date('ymd').'.txt"');

echo $out;
