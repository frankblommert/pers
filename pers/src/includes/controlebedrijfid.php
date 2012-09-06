<?php
function ctrlBedrijfID($value){
	if (is_numeric($value) ){
		return true;
	}
	return false;
}
?>