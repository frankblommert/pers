<?php
require_once('controlebedrijfid.php');
require_once('controlesgebruiker.php');

function ctrlHoofdgebruiker($value){
	if ($value == 'j' || $value == 'n'){
		return true;
	}
	return false;
}

function ctrlRechten($value){
	if ($value == 'Alle' ||  $value == 'Berichten' ){
		return true;
	}
	return false;
}

function ctrlPersoneelsnummer($value){
	if($value == null){
		return true;
	}
	
	if (preg_match('"[A-Z0-9a-z]"',$value)) {
			return true;		
	}
	return false;
}
?>