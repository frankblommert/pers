<?php

require_once('controlespersoon.php');
require_once('controlebedrijfid.php');

function ctrlBedrijfsnaam($value){
	if (preg_match('"^[^A-Z0-9a-z]"',$value)) {
			return false;		
	}
	return true;
}

function ctrlStraatnaam($value){
	if ($value != '') {
		if (preg_match('"[!@#$%^&*()_]"',$value)){
			return false;
		}
	}
	return true;
}

function ctrlHuisnummer($value){
	if ($value != '') {
		if (preg_match('"^[^0-9]$"',$value)) {
				return false;		
		}
	}
	return true;
}

function ctrlToevoeging($value){
	if ($value != '') {
		if (!preg_match('"[a-zA-Z0-9]{1,10}"',$value)){
			return false;
		}
	}
	return true;
}

function ctrlPostcode($value){
	if ($value != '') {
		if (!preg_match('"[1-9][0-9]{3}\s?[a-zA-Z]{2}"',$value)){
			return false;
		}
	}
	return true;
}
function ctrlPlaats($value){
	if ($value != '') {
		if (preg_match('"[0-9!@#$%^&*()_]"',$value)){
			return false;
		}
	}
	return true;
}
function ctrlLand($value){
	if ($value != '') {
		if (preg_match('"[0-9!@#$%^&*()_]"',$value)){
			return false;
		}
	}
	return true;
}

function ctrlKvknummer($value){
	if (!preg_match('"[0-9]{7,10}"',$value)){
		return false;
	}
	return true;
}
function ctrlBtwnummer($value){
	if (!preg_match('"[0-9]{7,10} || NL[0-9]{7}B[0-9]{2}"',$value)){
		return false;
	}
	return true;
}
function ctrlRekeningnummer($value){
	if (!preg_match('"[0-9]{7,10}"',$value)){
		return false;
	}
	return true;
}
function ctrlStatusBedrijf($value){
	if ($value == 'actief' || $value == 'aangemeld' || $value == 'afgemeld'){
		return true;
	}
	return false;
}


function ctrlAlgVoorwaarden($value){
	if ($value == 'Ik accepteer de algemene voorwaarden van Persmail'){
		return true;
	}
	return false;
}

function ctrlIncasso($value){
	if ($value == 'Ik machtig Persmail het jaarlijkse abonnenment automatisch te incasseren'){
		return true;
	}
	return false;
}
?>