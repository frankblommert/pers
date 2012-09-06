<?php

require_once 'controlespersoon.php';
require_once 'controlebedrijfid.php';
function ctrlAfdeling($value){
	if (preg_match('"[!@#$%^&*()_]"',$value)){
		return false;
	}
	return true;
}
?>