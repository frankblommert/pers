<?php
require_once('controlesmaillijst.php');
require_once('controleemailadres.php');

function ctrlStatusMaillijstEmailAdres($value){
	if ($value == 'actief' ||  $value == 'vervallen'){
		return true;
	}
	return false;
}
?>