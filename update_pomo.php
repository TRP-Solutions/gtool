<?php
require_once __DIR__.'/header.php';

$output = new healDocument();
foreach(LOCALES as $locale) {
	$output->te('Locale: '.$locale)->el('br');
	make_po($locale,$output);
	$output->el('br');
}
Ufo::output('output',$output);

function make_po($locale,$output) {
	global $mysqli;

	$output->te('Making PO file')->el('br');

	$file = '# '.TITLE.' - Translation file ('.$locale.')'.PHP_EOL.PHP_EOL;
	$primary = LOCALES[0];

	$sql = "SELECT `msgid`.`id`,`msgid`.`msgid`,`local`.`str` as 'local',`backup`.`str` as 'backup'
		FROM `msgid`
		LEFT JOIN `msgstr` AS `local` ON `msgid`.`id` = `local`.`msgid_id` AND `local`.`locale` = '$locale'
		LEFT JOIN `msgstr` AS `backup` ON `msgid`.`id` = `backup`.`msgid_id` AND `backup`.`locale` = '$primary'
		ORDER BY `msgid`.`msgid`";
	$query = $mysqli->query($sql);
	while($rs = $query->fetch_object()) {
		if(!empty($rs->local)) {
			$str = $rs->local;
		}
		else {
			$str = $rs->backup;
			$output->te('!!! Filled from primary: '.$rs->msgid)->el('br');
		}
		$file .= 'msgid "'.$rs->msgid.'"'.PHP_EOL;
		$file .= 'msgstr "'.str_replace('"','""',$str).'"'.PHP_EOL.PHP_EOL;
	}

	$file_po = tempnam(sys_get_temp_dir(), 'gtoolpo_');
	$output->te('Saving temp PO ('.$file_po.')')->el('br');

	try {
		$fh = fopen($file_po, 'w');
		fwrite($fh, $file);
		fclose($fh);
	}
	catch (\Exception $e) {
		$output->te('Error: '.$e->getMessage())->el('br');
		return;
	}

	$dir = PATH_OUTPUT.'/'.$locale.'/LC_MESSAGES';

	if(!is_dir($dir)) {
		$output->te('No output dir ('.$dir.')')->el('br');
		if(!mkdir($dir,0777,true)) {
			$output->te('Unable to create output dir ('.$dir.')')->el('br');
			return;
		}

	}

	if(!is_writable($dir)) {
		$output->te('Not writable ('.$dir.')')->el('br');
		return;
	}

	$file_mo = $dir.'/messages.mo';

	$output->te('Compiling MO ('.$file_mo.')')->el('br');
	$exec = PATH_BIN."/msgfmt $file_po -o $file_mo";
	system($exec, $retval);

	if($retval) {
		$output->te('Error: messages.mo not created')->el('br');
		$output->te($exec)->el('br');
	}
	unlink($file_po);
	$output->te('Done')->el('br');
}
