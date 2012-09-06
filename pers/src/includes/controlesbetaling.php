<?php
require_once('controlebedrijfid.php');
require_once('controledatumtijd.php');
require_once('controlenumeriek.php');

function ctrlStatusBetaling($value){
	if ($value == 'Uitgevoerd' || $value == 'Wacht op bevestiging' ||  $value == 'Afgekeurd'){
		return true;
	}
	return false;
}

function ctrlOmschrijving($value){
	if (preg_match('"[A-Za-z\s]+[0-9]* Persmail$"',$value)) {
			return true;		
	}
	return false;
}
?>