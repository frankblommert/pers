<?php
		
require_once 'FuncClasses/clsBedrijf.php';
require_once 'src/includes/controlesbedrijf.php';
require		 'src/includes/verwerkformulier.php';
require		 'src/includes/smartystart.php';					

$aStylesheets = array('persmailbeheerbedrijf');					// wordt in smartyassign.php doorgegeven
$aJavascripts = array('persmailform');							// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';								// authenticatie en session start includen na new Smarty

require 'src/includes/smartyassign.php';						// standaard smarty assignments
$smarty->assign('formlist' , $aVelden );			
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');	

?>