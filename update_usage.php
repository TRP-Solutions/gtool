<?php
require_once __DIR__.'/header.php';

$exec = PATH_BIN.'/';
$exec .= 'xgettext';
$exec .= ' --omit-header';
$exec .= ' --keyword=lnr';
$exec .= ' --keyword=ln';
$exec .= ' --from-code=UTF-8';
$exec .= ' --output=-';
$exec .= " $(find ".PATH_SOURCE." -name '*.js' -or -name '*.php' | grep -v ' ')";
// Spaces in filenames unsupported by xgettext

exec($exec,$output,$retval);
$undefined = [];

if($retval!==0) {
	\Ufo::call('alert','Returned = '.$retval);
}
elseif($output) {
	$usage = [];
	foreach($output as $line) {
		if(strpos($line,'#: ')===0) {
			$line = substr($line, 3);
			$usage = array_merge($usage,explode(' ',$line));
		}
		else if(strpos($line,'msgid "')===0) {
			$msgid = substr($line, 7, -1);
			$msgid = $mysqli->real_escape_string($msgid);
			$sql = "SELECT `id` FROM `msgid` WHERE `msgid`='$msgid'";
			$query = $mysqli->query($sql);
			if($rs = $query->fetch_object()) {
				$usage = $mysqli->real_escape_string(implode(PHP_EOL,$usage));
				$sql = "UPDATE `msgid` SET `usage` = '$usage' WHERE `id`='$rs->id'";
				$mysqli->query($sql);
			}
			else {
				$undefined[$msgid] = $usage;
			}
			$usage = [];
		}
	}
}
else {
	Ufo::call('alert','No output');
}

$html = new healDocument();
if($undefined) {
	foreach($undefined as $key => $undef) {
		$html->te('Unknown msgid: '.$key)->el('br');
		$html->te('Files: '.implode(', ',$undef))->el('br');
		$html->el('br');
	}
}
else {
	$html->te('Done')->el('br');
}
Ufo::output('output',$html);
