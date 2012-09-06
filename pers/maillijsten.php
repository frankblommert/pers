<?php

require_once 'FuncClasses/clsBedrijf.php';
require		 'src/includes/smartystart.php';

$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array();							// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';					// authenticatie en session start includen na new Smarty

$sMelding = '';

try {
	autorisatie('Bedrijf','Alle');					// controleer soort gebruiker en rechten
	if (isset($_REQUEST["command"])) {
		switch($_REQUEST["command"]){			
			case "Verwijderen":
				$objDBMaillijst = new clsDBMaillijst();			
				if($objDBMaillijst->delete($_SESSION['BedrijfID'] , $_REQUEST['sleutel'])){
					$sMelding = 'Maillijst verwijderd';
				}
				break;
			default:
				throw new Exception('Onbekende actie op formulier uitgevoerd');
				break;
		}
	} 
}
catch (PDOException $e) {
	$sMelding .= $e->getMessage().'<br />';
}
catch (Exception $e) {
	$sMelding .= $e->getMessage().'<br />';
}

$objBedrijf = new clsBedrijf($_SESSION['BedrijfID']);

$smarty->assign('Maillijsten' , $objBedrijf->maillijsten() );
$smarty->assign('Melding', $sMelding);
require 'src/includes/smartyassign.php';				// standaard smarty assignments			
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');

$objBedrijf = null;

?>