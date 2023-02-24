<?php
require_once __DIR__.'/header.php';

$html = new healDocument();

$primary = LOCALES[0];
if(!empty($_GET['local'])) {
	$local = $mysqli->real_escape_string(trim($_GET['local']));
}
else {
	$local = LOCALES[1];
}

$form = $html->form();
$onsubmit = "Ufo.get('main','search.php?search='+document.getElementById('search').value+'&local='+document.getElementById('local').value);return false;";
$form->at(['onsubmit'=>$onsubmit]);

$form->label('Search: ','search');
$form->input('search','search',(isset($_GET['search'])) ? trim($_GET['search']) : '');
$form->el('br');

$form->label('Locale: ','local');
$select = $form->select('local','local');
$select->option(null);
foreach(array_slice(LOCALES,1) as $value) {
	$select->option($value,$value,$value==$local);
}

$form->el('br');
$form->label();
$form->submit('Search');

$html->el('br');

$table = $html->el('table');
$table->at(['class'=>'data']);

$tr = $table->el('tr');
$tr->el('th')->te('msgid');
$tr->el('th')->te($primary);
$tr->el('th')->te($local);

if(!empty($_GET['search'])) {
	$search = trim($mysqli->real_escape_string($_GET['search']));
	$where = "`primary`.`str` LIKE '%$search%' OR `local`.`str` LIKE '%$search%' OR `msgid`.`msgid` LIKE '%$search%'";
}
else {
	$where = 'TRUE';
}

$sql = "SELECT `msgid`.`id`,`msgid`.`msgid`,`primary`.`str` as 'primary',`local`.`str` as 'local'
	FROM `msgid`
	LEFT JOIN `msgstr` AS `primary` ON `msgid`.`id` = `primary`.`msgid_id` AND `primary`.`locale` = '$primary'
	LEFT JOIN `msgstr` AS `local` ON `msgid`.`id` = `local`.`msgid_id` AND `local`.`locale` = '$local'
	WHERE $where
	ORDER BY `msgid`.`id` DESC LIMIT 50";


$query = $mysqli->query($sql);

while($rs = $query->fetch_object()) {
	$tr = $table->el('tr');
	$tr->at(['onclick'=>"Ufo.get('dialog','entry_edit.php?msg_id=$rs->id')"]);
	$tr->at(['class'=>'clickable']);
	$tr->el('td')->te($rs->msgid);
	$tr->el('td')->te($rs->primary);
	$tr->el('td')->te($rs->local);
}

Ufo::output('main',$html);
