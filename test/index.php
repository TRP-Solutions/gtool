<?php
$language = 'en_US';

bindtextdomain('messages', __DIR__.'/../language/');
textdomain('messages');

putenv('LC_MESSAGES='.$language.'.utf-8');
setlocale(LC_MESSAGES,$language.'.utf-8');

echo _('success').': '._('yes');
