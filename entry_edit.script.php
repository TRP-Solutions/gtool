<?php
require_once __DIR__.'/header.php';

if(empty($_POST['msg_id'])) exit;
$msg_id = (int) $_POST['msg_id'];

$msgid = $mysqli->real_escape_string($_POST['msgid']);

$sql = "UPDATE `msgid` SET `msgid` = '$msgid' WHERE `id`='$msg_id'";
$mysqli->query($sql);

foreach(LOCALES as $value) {
	$name = strtolower($value);
	if(!empty($_POST[$name])) {
		$str = $mysqli->real_escape_string(trim($_POST[$name]));
		$sql = "INSERT INTO `msgstr` (`msgid_id`,`locale`,`str`) VALUES ('$msg_id','$value','$str')
			ON DUPLICATE KEY UPDATE `str`='$str'";
	}
	else {
		$sql = "DELETE FROM `msgstr` WHERE `msgstr`.`msgid_id`='$msg_id' AND `msgstr`.`locale`='$value'";
	}
	$mysqli->query($sql);
}

Ufo::update('main');
Ufo::abort('dialog');
