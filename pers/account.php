<?php
		
require_once 'FuncClasses/clsAccount.php';
require_once 'src/includes/controlesaccount.php';
require		 'src/includes/verwerkformulier.php';
require		 'src/includes/smartystart.php';

$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array();							// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';					// authenticatie en session start includen na new Smarty
$sMelding = '';
$aVelden = definieer();		   						//ophalen formulier definitie

try {
	autorisatie('Bedrijf','Alle');					// controleer soort gebruiker en rechten
	switch(true){
		case (isset($_REQUEST['command_x'])):
			$objAccount = new clsAccount($_SESSION['BedrijfID'],'1');			
			if (isset($_POST['credits'])){								
				if($_POST['credits'] > 0){	// aantal credits > 0?						
					if($objAccount->koopCredits($_POST['credits'])){
						$objAccount->wijzig();
					} else {
						throw new Exception('Er is een fout opgetreden met da aankoop van credits');
					}						
				}
			}
			break;
		case (isset($_REQUEST['exporteer_x'])):								// op exporteren gedrukt
			$objAccount = new clsAccount($_SESSION['BedrijfID'],'1');
			if ($sExportBestand = exporteer($objAccount)){
				nop;
			} else { 
				throw new Exception('Export betalingen mislukt');
			}
			break;
		default:	
			$objAccount = new clsAccount($_SESSION['BedrijfID'],'1');
			$aVelden['AccountID']['waarde'] = $objAccount->getm_iAccountID();
			$aVelden['BedrijfID']['waarde'] = $objAccount->getm_iBedrijfID();
	}
}
catch (PDOException $e) {
	$sMelding .= $e->getMessage().'<br />';
}
catch (Exception $e) {
	$sMelding .= $e->getMessage().'<br />';
}

$aVelden = initNietIngevuld($aVelden);

require 'src/includes/smartyassign.php';				// standaard smarty assignments
$smarty->assign('formlist' , $aVelden );	
$smarty->assign('exportbestand' , $sExportBestand );	
$smarty->assign('credits' , $objAccount->getm_iAantalCredits());	
$smarty->assign('betalingen' , $objAccount->betalingen() );		
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');
$objAccount = null;

function definieer() {
$aVelden = array(
/*
 initiele waarde                 name			  type					value	status + css class			verplicht       controle                                 setter
 + css ID																		  ok||notok||init			true/false       functie
 */
'AccountID'  	=> array('naam' => 'accountid' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '40' , 'verplicht' => true, 'controle' => '', 'setter' => 'setm_iAccountID'), 
'BedrijfID'  	=> array('naam' => 'bedrijfid' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '40' , 'verplicht' => true, 'controle' => '', 'setter' => 'setm_iBedrijfID'),
'Credits'		=> array('naam' => 'credits' , 'type' => 'select','waarde' => array('500'=>array('500','selected'),'1000'=>array('1000',''),'2000'=>array('2000',''),'5000'=>array('5000',''),'10000'=>array('10000','')), 'status' => 'ok' , 'size' => '120' , 'verplicht' => true, 'controle' => 'ctrlNumeriek', 'setter' => ''), 
'KoopCredits'	=> array('naam' => 'command', 'type' => 'image','waarde' => 'img/knop_kopen_groen.png', 'status' => 'formbtn' , 'size' => '40' , 'verplicht' => false, 'controle' => '', 'setter' => ''),
'Exporteer'		=> array('naam' => 'exporteer', 'type' => 'image','waarde' => 'img/knop_exporteren.png', 'status' => 'formbtn' , 'size' => '40' , 'verplicht' => false, 'controle' => '', 'setter' => '')
);
return $aVelden;
}

//exporteer betalingen 
function exporteer(&$objAccount){
$objDom = new DOMDocument();
$objDom->encoding = 'UTF-8' ;
$objDom->formatOutput = 'true' ;
$objRoot = $objDom->createElement('PersmailTransacties');

$objDom->appendChild($objRoot);
$objBetalingen = $objDom->createElement('Betalingen');
$objRoot->appendChild($objBetalingen);

foreach($objAccount->betalingen() as $objBetaling){
	$objXmlBetaling = $objDom->createElement('Betaling');
	$objBetalingen->appendChild($objXmlBetaling);	
	$objDatum = $objDom->createElement('Datum');
	$objText = $objDom->createTextNode($objBetaling->getm_dDatumTijd());
	$objDatum->appendChild($objText);
	$objXmlBetaling->appendChild($objDatum);	
	$objOmschrijving = $objDom->createElement('Omschrijving');
	$objText = $objDom->createTextNode($objBetaling->getm_sOmschrijving());
	$objOmschrijving->appendChild($objText);
	$objXmlBetaling->appendChild($objOmschrijving);
	$objBedrag = $objDom->createElement('Bedrag');
	$objText = $objDom->createTextNode($objBetaling->getm_iBedrag());
	$objBedrag->appendChild($objText);
	$objXmlBetaling->appendChild($objBedrag);	
	
	$objStatus = $objDom->createElement('Status');
	$objText = $objDom->createTextNode($objBetaling->getm_sStatus());
	$objStatus->appendChild($objText);
	$objXmlBetaling->appendChild($objStatus);
} 

$objOutput = $objDom->saveXML();
$sBestand = 'Exportfiles/PersmailTransacties'.date(YmdHis).'.xml';
if(!$objDom->save($sBestand)){
	return 'Export mislukt! '.$sBestand.' niet aangemaakt';
}
return $sBestand.' is aangemaakt.';
	
}
?>