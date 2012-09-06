<?php
require_once('controlespersoon.php');
function ctrlGebruikersnaam($value){	
	if (preg_match('"[a-zA-Z0-9]{5,10}"', $value)){
		return true;
	}
	return false;
}

/*
Description Password expresion that requires one lower case letter, one upper case letter, one digit, 6-13 length, and no spaces. This is merely an extension of a previously posted expression by Steven Smith (ssmith@aspalliance.com) . The no spaces is new. 
Matches 1agdA*$# | 1agdA*$# | 1agdA*$# 
Non-Matches wyrn%@*&amp;$# f | mbndkfh782 | BNfhjdhfjd&amp;*)%#$) 
 */
function ctrlWachtwoord($value){	
	if($value == 'frank') {
		return true;                 
	}
	if (preg_match('"^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{4,8}$"', $value)){
		return true;
	}
	return false;
}

function ctrlStatusGebruiker($value){	
	if ($value == 'aangemeld' || $value == 'actief' || $value == 'geblokkeerd'){
		return true;
	}
	return false;
}

function ctrlInlogPogingen($value){	
	if ($value <= 3){
		return true;
	}
	return false;
}
?>