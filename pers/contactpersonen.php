<?php
require_once 'FuncClasses/clsBedrijf.php';
require		 'src/includes/smartystart.php';

$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array();							// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';					// authenticatie en session start includen na new Smarty

$sMelding = '';

try {
	autorisatie('Bedrijf','Alle');					// controleer soort gebruiker en rechten
	switch(true){			
		case (isset($_REQUEST["command_x"])):								
			$objDBContactpersoon = new clsDBContactpersoon();			
			if($objDBContactpersoon->delete($_REQUEST['sleutel'])){
				$sMelding = 'Contactpersoon verwijderd<br />';
			}
			break; 
		case (isset($_REQUEST["importeer_x"])):
			if (isset($_REQUEST['bestand']) && $_REQUEST['bestand'] != null){
				importeer();
			} else {
				throw new Exception('Er is geen bestand geselecteerd');
			}
			break;		
 		case (isset($_REQUEST["command"])):
			if ($_REQUEST["command"] == "Verwijderen"){
				$objDBContactpersoon = new clsDBContactpersoon();			
				if($objDBContactpersoon->delete($_REQUEST['sleutel'])){
					$sMelding = 'Contactpersoon verwijderd<br />';
				}
			}
			break; 
		default:
			nop;
			break;
	} 
}
catch (PDOException $e) {
	$sMelding .= $e->getMessage().'<br />';
}
catch (Exception $e) {
	$sMelding .= $e->getMessage().'<br />';
}

$objBedrijf = new clsBedrijf($_SESSION['BedrijfID']);
$smarty->assign('lijst',importBestanden());
$smarty->assign('contactpersonen' , $objBedrijf->contactpersonen() );
require 'src/includes/smartyassign.php';				// standaard smarty assignments			
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');

$objBedrijf = null;

// importeer bestand
function importeer(){
	$objDom = new DOMDocument();
	$objDom->preserveWhiteSpace = false;
	if(file_exists('Importfiles/'.$_POST['bestand'])){
		if($objDom->load('Importfiles/'.$_POST['bestand'])){
			nop;
		} else {
			throw new Exception('Het geselecteerde bestand kon niet worden gelezen');
		}
	} else {
		throw new Exception('Het geselecteerde bestand kon niet worden gevonden');
	}
	$objXpath = new DOMXpath($objDom);
	$sQuery = '/personen/persoon';
	$objNodeLijst = $objXpath->query($sQuery);
	foreach($objNodeLijst as $objNode){
		$objContactpersoon = new clsContactpersoon();
		$objContactpersoon->setm_iBedrijfID($_SESSION['BedrijfID']);
		foreach($objNode->childNodes as $objChild){
			switch($objChild->nodeName){
				case 'naam':
					foreach($objChild->childNodes as $objElement){
						switch($objElement->nodeName){
							case 'voornaam':
								$objContactpersoon->setm_sVoornaam($objElement->nodeValue);
								break;
							case 'tussenvoegsel':
								$objContactpersoon->setm_sTussenvoegsel($objElement->nodeValue);
								break;
							case 'achternaam':
								$objContactpersoon->setm_sAchternaam($objElement->nodeValue);
								break;
							default:
								nop;
						}
					}
					break;
				case 'telefoon':
					$objContactpersoon->setm_sTelefoonnummer($objChild->nodeValue);
					break;
				case 'emailadres':
					$objContactpersoon->setm_sEmailAdres($objChild->nodeValue);
					break;
				case 'afdeling':
					$objContactpersoon->setm_sAfdeling($objChild->nodeValue);
					break;
				default:
					nop;	
			}
		}
		$objContactpersoon->voegToe();
	}
return;
}

// maak een lijst van xml bestanden in de inport directory
function importBestanden(){
	$aLijst = array();
    $sDirNaam = 'Importfiles';
    if(file_exists($sDirNaam) && is_dir($sDirNaam)){ 
        $objDir = new DirectoryIterator($sDirNaam); 
		foreach($objDir as $objBestand) {
			if ( substr($objBestand->getFilename(), -4) == '.xml'){					
				$aLijst[] = $objBestand->getFilename(); 
			}
		} 

	} else {
		throw new exception('Import directory niet gevonden');
	}
	return $aLijst;
}
?>