<?php
require_once __DIR__.'/header.php';

if(empty($_GET['msg_id'])) exit;
$msg_id = (int) $_GET['msg_id'];

$join = '';
$field = [];
foreach(LOCALES as $value) {
	$name = 'tbl_'.strtolower($value);
	$field[] = "`$name`.`str` as ".strtolower($value);
	$join .= "LEFT JOIN `msgstr` as $name ON `$name`.`msgid_id`=`msgid`.`id` AND `$name`.`locale`='$value'".PHP_EOL;
}

$field = implode(',',$field);
$sql = "SELECT `msgid`,`usage`,$field
	FROM `msgid`
	$join
	WHERE `id` = $msg_id";
$query = $mysqli->query($sql);
$rs = $query->fetch_object();

$html = new htmlDesign();
$form = $html->form(null);
$onsubmit = "Ufo.post('dialog','entry_edit.script.php',this);return false;";
$form->at(['onsubmit'=>$onsubmit]);

$form->hidden('msg_id',$msg_id);

$form->label('msgid: ','msgid');
$form->input('msgid','msgid',$rs->msgid)->at(['required']);

foreach(LOCALES as $value) {
	$name = strtolower($value);

	$form->el('br');
	$form->label($value.": ",$name);
	$form->textarea($name,$rs->$name);
}

$form->el('br');

$form->label('Usage: ','usage');
$form->textarea('usage',$rs->usage)->at(['disabled']);

$form->el('br');

$form->label();
$form->submit('Save');
$form->button('Close',"Ufo.abort('dialog')");

Ufo::output('dialog',$html);
