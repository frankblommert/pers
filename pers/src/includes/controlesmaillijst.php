<?php
require_once('controlebedrijfid.php');
function ctrlMaillijstID($value){
	if (is_numeric($value)){
		return true;
	}
	return false;
}

function ctrlNaamMaillijst($value){
	if ($value == ''){
		return false;
	}
	return true;
}

function ctrlStatusMaillijst($value){
	if ($value == 'actief' || $value == 'in bewerking' || $value == 'vervallen'){
		return true;
	}
	return false;
}
?>