<?php
require_once __DIR__.'/header.php';

$html = new healDocument();
$form = $html->form(null);
$form->at(['enctype'=>'multipart/form-data']);
$onsubmit = "Ufo.post('main','upload.script.php',this);return false;";
$form->at(['onsubmit'=>$onsubmit]);

$form->label('Locale: ','locale');
$select = $form->select('locale');
$select->option(null);

foreach(LOCALES as $value) {
	$select->option($value,$value);
}
$form->el('br');
$form->label('File: ','file');
$form->file('file');

$form->el('br');
$form->label();
$form->submit('Upload');

$html->el('br');
$output = $html->el('div',['id'=>'output']);

Ufo::output('main',$html);
