<?php
require_once __DIR__.'/header.php';

if(empty($_GET['locale'])) exit;
$locale = $mysqli->real_escape_string($_GET['locale']);
$primary = LOCALES[0];
$fill = (bool) isset($_GET['fill']);

if($fill) {
	$where = "`msgstr`.`str` IS NULL OR `msgstr`.`str` = ''";
}
else {
	$where = "`msgstr`.`str` IS NOT NULL AND `msgstr`.`str` != ''";
}

$sql = "SELECT `msgid`.`msgid`,`msgstr`.`str`,fill.`str` as fill
	FROM `msgid`
	LEFT JOIN `msgstr` ON `msgid`.`id` = `msgstr`.`msgid_id` AND `msgstr`.`locale` = '$locale'
	LEFT JOIN `msgstr` as fill ON `msgid`.`id` = `fill`.`msgid_id` AND `fill`.`locale` = '$primary'
	WHERE $where
	ORDER BY `msgid`.`id`";
$query = $mysqli->query($sql);

$out = '';

while($rs = $query->fetch_object()) {
	$out .= utf8_decode($rs->msgid." => ");
	$out .= utf8_decode('"'.($fill ? $rs->fill : $rs->str).'"'.PHP_EOL);
}

header('Content-type: text/plain; charset=utf-8');
$filename = preg_replace("/[^a-z]+/",'',mb_strtolower(TITLE));
$filename .= '-'.$locale.'-'.date('ymd').($fill ? '-fill' : '-current').'.txt';
header('Content-disposition: attachment; filename="'.$filename.'"');

echo $out;
