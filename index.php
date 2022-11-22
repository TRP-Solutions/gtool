<?php
require_once __DIR__.'/header.php';

$doc = new htmlDesign('html');
$html = $doc->el('html');
$html->el('title')->te(TITLE);
$html->el('link',['rel'=>'stylesheet','href'=>'css/reset.css']);
$html->el('link',['rel'=>'stylesheet','href'=>'css/style.css']);
$html->el('script',['src'=>'lib/ufo-ajax/ufo.js']);
$html->el('script',['src'=>'onload.js']);

$onload = "bodyload();Ufo.get('main','search.php');";
$body = $html->el('body',['onload'=>$onload]);

$wrapper = $body->el('wrapper');

$nav = $wrapper->el('nav');
$nav->te(TITLE.' - ');
$nav->button('Search',"Ufo.get('main','search.php')");
$nav->button('New',"Ufo.get('dialog','entry_new.php')");
$nav->button('Action',"Ufo.get('main','action.php')");
$nav->button('Download',"Ufo.get('main','download.php')");
$nav->button('Upload',"Ufo.get('main','upload.php')");

$wrapper->el('main',['id'=>'main']);
$wrapper->el('dialog',['id'=>'dialog']);

echo $doc;
