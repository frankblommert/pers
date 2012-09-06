<?php
require_once('controlebedrijfid.php');
require_once('controlenumeriek.php');

function ctrlStatusAccount($value){
	if ($value == 'actief' ||  $value == 'geblokkeerd'){
		return true;
	}
	return false;
}
?>