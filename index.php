<?php
require_once __DIR__.'/header.php';

$doc = new healDocument('html');
$html = $doc->el('html');
$head = $html->el('head');
$head->el('meta',['charset'=>'utf-8']);
$head->el('title')->te(TITLE);
$head->el('link',['rel'=>'stylesheet','href'=>'css/reset.css']);
$head->el('link',['rel'=>'stylesheet','href'=>'css/style.css']);
$head->el('script',['src'=>'lib/ufo-ajax/ufo.js']);
$head->el('script',['src'=>'onload.js']);

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
