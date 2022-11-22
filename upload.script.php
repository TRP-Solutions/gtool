<?php
require_once __DIR__.'/header.php';

if(empty($_POST['locale'])) exit;
$locale = $mysqli->real_escape_string($_POST['locale']);

$output = new healDocument();
$output->te('Locale: '.$locale)->el('br');

if($locale) {
	if($_FILES['file']['tmp_name']) {
		$tmp_name = $_FILES['file']['tmp_name'];
		$output->te('File: '.$_FILES['file']['name'])->el('br');
		
		$file = fopen($tmp_name, 'r');
		$count = 1;
		
		while(!feof($file)) {
			$line = trim(utf8_encode(fgets($file)));
			
			if(trim($line)) {
				$linearray = explode(" => \"",$line);
				if(sizeof($linearray)==2) {
					$msgid = $mysqli->real_escape_string($linearray[0]);
					$str = trim(substr(trim($linearray[1]),0,-1));
					$sql = "SELECT `id` FROM `msgid` WHERE `msgid`='$msgid'";
					$query = $mysqli->query($sql);
					if($rs = $query->fetch_object()) {
						if(!empty($str)) {
							$str = $mysqli->real_escape_string($str);
							$sql = "INSERT INTO `msgstr` (`msgid_id`,`locale`,`str`) VALUES ('$rs->id','$locale','$str')
								ON DUPLICATE KEY UPDATE `str`='$str'";
							$mysqli->query($sql);
						}
					}
					else {
						if($msgstr) {
							$output->te('Unknown code found('.$count.'): '.$msgid)->el('br');
						}
					}
				}
				else {
					$output->te('Separator invalid('.$count.'): '.$line)->el('br');
				}
			}
			$count++;
		}
		fclose($file);	
	}
}

$output->te('Done')->el('br');
Ufo::output('output',(string) $output);
