<?php
require_once __DIR__.'/header.php';

$html = new htmlDesign();
$form = $html->form(null);
$onsubmit = "Ufo.post('dialog','entry_new.script.php',this);return false;";
$form->at(['onsubmit'=>$onsubmit]);

$form->label('msgid: ','msgid');
$form->input('msgid','msgid')->at(['required']);
$form->el('br');

$primary = LOCALES[0];
$form->label($primary.': ','msgstr');
$form->textarea('msgstr','')->at(['required']);
$form->el('br');

$form->label();
$form->submit('Create');
$form->button('Cancel',"Ufo.abort('dialog')");

Ufo::output('dialog',$html);
