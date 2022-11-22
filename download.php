<?php
require_once __DIR__.'/header.php';

$html = new htmlDesign();
$form = $html->form(null);

foreach(LOCALES as $value) {
	$form->label($value.': ');
	$onclick = "location.href='download.script.php?locale=$value'";
	$form->button('Download CSV',$onclick);
	$form->el('br');
}

Ufo::output('main',$html);
