<?php
require_once __DIR__.'/../header.php';

$doc = new healDocument('html');
$html = $doc->el('html');
$head = $html->el('head');
$head->el('meta',['charset'=>'utf-8']);
$head->el('title')->te(TITLE);
$head->el('link',['rel'=>'stylesheet','href'=>'../css/reset.css']);
$head->el('link',['rel'=>'stylesheet','href'=>'../css/style.css']);

$body = $html->el('body');

$wrapper = $body->el('wrapper');
$main = $wrapper->el('main');

$title = TITLE.' - Browser test';

$nav = $wrapper->el('nav');
$nav->te($title);

$string = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

$main->label('Language: ','string');
$main->input('string','string',$string);
$main->el('br');
$main->label('Base64: ','base64');
$main->input('base64','base64',base64_encode($string));
$main->el('br');

$body = '';
$body .= 'Time: '.(new DateTime())->format('Y-m-d H:i').PHP_EOL;
$body .= 'Language: '.$string.PHP_EOL;
$body .= 'Base64: '.base64_encode($string).PHP_EOL;
$js = "window.location = 'mailto:".rawurlencode(EMAIL)."?subject=".rawurlencode($title)."&body=".rawurlencode($body)."'";
$main->button('E-mail',$js);

echo $doc;
