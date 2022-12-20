<?php
if(file_exists(__DIR__.'/config.php')) {
	require_once __DIR__.'/config.php';
}
if(file_exists(__DIR__.'/../gtool-config.php')) {
	require_once __DIR__.'/../gtool-config.php';
}
if(!defined('LOCALES') || !is_array(LOCALES)) throw new \Exception('LOCALES not configured');

require_once __DIR__.'/lib/heal-document/HealDocument.php';
require_once __DIR__.'/lib/ufo-ajax/ufo.php';
require_once __DIR__.'/design.php';

$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_BASE);
$mysqli->set_charset('utf8mb4');
