<?php
require_once __DIR__.'/header.php';

$html = new healDocument();
$form = $html->form(null);
$form->button('Update usage',"Ufo.get('action','update_usage.php')");
$form->button('Update PO/MO',"Ufo.get('action','update_pomo.php')");

$html->el('br');
$output = $html->el('div',['id'=>'output']);

Ufo::output('main',$html);
