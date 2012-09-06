<?php

require_once('controleemailadres.php');

function ctrlVoornaam($value){
	if (!preg_match('"(^[A-Z][a-zA-Z\-\' \']*$)"',$value)) {
		return false;	
	}	
	return true;
}

function ctrlTussenvoegsel($value){
	if (!preg_match('"(^[a-z\-\' \']*$)"',$value)) {
		return false;	
	}	
	return true;
}

function ctrlAchternaam($value){
	if (!preg_match('"(^[A-Z][a-zA-Z\-\' \']*$)"',$value)) {
		return false;	
	}	
	return true;
}

function ctrlTelefoonnummer($value){
	if ($value != ''){
		if (!preg_match('"(^\+[0-9]{2}|^\+[0-9]{2}\(0\)|^\(\+[0-9]{2}\)\(0\)|^00[0-9]{2}|^0)([0-9]{9}$|[0-9\-\s]{10}$)"',$value)) {
			return false;		
		}
	}
	return true;
}

function ctrlID($value){
	if (is_numeric($value)){
		return true;
	}
	return false;
}
?>
