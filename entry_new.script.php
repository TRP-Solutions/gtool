<?php
require_once __DIR__.'/header.php';

if(empty($_POST['msgid'])) exit;
$msgid = $mysqli->real_escape_string(trim($_POST['msgid']));

$sql = "SELECT `id` FROM `msgid` WHERE `msgid`='$msgid'";
if($mysqli->query($sql)->num_rows!==0) {
	Ufo::abort('dialog');
	exit;
}

$sql = "INSERT INTO `msgid` (`msgid`) VALUES ('$msgid')";
$mysqli->query($sql);

$msgid_id = $mysqli->insert_id;

if(!empty($_POST['msgstr']) && $msgid_id) {
	$primary = LOCALES[0];
	$msgstr = $mysqli->real_escape_string(trim($_POST['msgstr']));

	$sql = "INSERT INTO `msgstr` (`msgid_id`,`locale`,`str`) VALUES ('$msgid_id','$primary','$msgstr');";
	$mysqli->query($sql);
}

Ufo::abort('dialog');
