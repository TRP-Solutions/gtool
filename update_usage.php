<?php
require_once __DIR__.'/header.php';

$exec = 'cd ';
$exec .= PATH_SOURCE;
$exec .= ' && ';
$exec .= PATH_BIN.'/';
$exec .= 'xgettext';
$exec .= ' --omit-header';
$exec .= ' --sort-output';
$exec .= ' --keyword=lnr';
$exec .= ' --keyword=ln';
$exec .= ' --output=-';
$exec .= ' $(find . | grep -v "\.svn" | grep -e "\.php" -e "\.js")';

exec($exec,$output);
$undefined = [];

if($output) {
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

if($undefined) {
	$html = new healDocument();
	foreach($undefined as $key => $undef) {
		$html->te('Unknown msgid: '.$key)->el('br');
		$html->te('Files: '.implode(', ',$undef))->el('br');
		$html->el('br');
	}
	
	Ufo::output('output',$html);
}
