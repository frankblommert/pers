<?php
require_once('controlebedrijfid.php');
require_once('controleemailadres.php');

function ctrlEmailAdresID($value){
	if (is_numeric($value)){
		return true;
	}
	return false;
}
?>