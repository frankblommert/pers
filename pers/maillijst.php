<?php	
require_once 'FuncClasses/clsMaillijst.php';
require_once 'FuncClasses/clsMaillijstEmailAdres.php';
require_once 'FuncClasses/clsEmailAdres.php';
require		 'src/includes/verwerkformulier.php';
require		 'src/includes/smartystart.php';

$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array();							// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';					// authenticatie en session start includen na new Smarty

$aVelden = definieer();		   						//ophalen formulier definitie

try {
	autorisatie('Bedrijf','Alle');					// controleer soort gebruiker en rechten
	switch(true){
			case (isset($_REQUEST['command_x'])):
				$objMaillijst = new clsMaillijst();			
				$aResult = verwerk($aVelden,$objMaillijst);	     // verwerk de ingevulde waardes
				$aVelden = $aResult['velden'];					// gecontroleerde waardes teruggeven in formulier definitie

				if ($aResult['ok']){								// waardes ok dus opslaan
					if($aVelden['MaillijstID']['waarde'] == '0'){			// sleutel 0 dus nieuw
						$objMaillijst->voegToe();
						$aVelden['MaillijstID']['waarde'] = $objMaillijst->getm_iMaillijstID();
					} else {
						$objMaillijst->wijzig();
						$smarty->assign('emailadressen',$objMaillijst->emailadressen());
					}				
				}
				break;
			case (isset($_REQUEST['command'])):
				switch($_REQUEST['command']) {	
					case "Wijzigen":
						if (isset($_REQUEST['sleutel'])) {
							$aVelden = ophalen($aVelden);			// ophalen gegevens voor het formulier
							$objMaillijst = new clsMaillijst($_SESSION['BedrijfID'],$_REQUEST['sleutel']);
							$smarty->assign('emailadressen',$objMaillijst->emailadressen());
						} else {
							throw new Exception('Geen ID bekend bij wijziging');
						}
						break;
					case "VerwijderenEmailAdres":
						if (isset($_REQUEST['sleutel'])  && isset($_REQUEST['emailid'])) {
							$aVelden = ophalen($aVelden);			// ophalen gegevens voor het formulier
							$objMaillijstEmailAdres = new clsMaillijstEmailAdres($_SESSION['BedrijfID'],$aVelden['MaillijstID']['waarde'],$_REQUEST['emailid']);
							$objMaillijstEmailAdres->verwijder();
							$objMaillijst = new clsMaillijst();
							$objMaillijst->laad($_SESSION['BedrijfID'],$aVelden['MaillijstID']['waarde']);
							$smarty->assign('emailadressen',$objMaillijst->emailadressen());
						} else {
							throw new Exception('Geen ID bekend bij verwijderen emailadres uit maillijst');
						}
						break;
					case "Nieuw":
						$aVelden['MaillijstID']['waarde'] = '0';
						$aVelden['BedrijfID']['waarde'] = $_SESSION['BedrijfID'];
						break;
				
				}
				break;
			case (isset($_REQUEST['importeer_x'])):
				$objMaillijst = new clsMaillijst();		
				$aResult = verwerk($aVelden,$objMaillijst);	     // verwerk de ingevulde waardes
				$aVelden = $aResult['velden'];					// gecontroleerde waardes teruggeven in formulier definitie
				
				if (isset($_REQUEST['bestand']) && $_REQUEST['bestand'] != null){
					importeer($objMaillijst);
				} else {
					throw new Exception('Er is geen bestand gelecteerd');
				}
				$smarty->assign('emailadressen',$objMaillijst->emailadressen());
				$_REQUEST['sleutel'] = $objMaillijst->getm_iMaillijstID();
				break;
			default:
				break;
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
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');
$objMaillijst = null;

function ophalen($aVelden){
		$objMaillijst = new clsMaillijst();
		$objMaillijst->laad($_SESSION['BedrijfID'],$_REQUEST['sleutel']);
		$aVelden['MaillijstID']['waarde'] = $objMaillijst->getm_iMaillijstID();
		$aVelden['BedrijfID']['waarde'] = $objMaillijst->getm_iBedrijfID();
		$aVelden['Naam']['waarde'] = $objMaillijst->getm_sNaam(); 
		foreach($aVelden['Status']['waarde'] as $waarde => $omschrijving){
			if($waarde == $objMaillijst->getm_sStatus()){
				$aVelden['Status']['waarde'][$waarde][1] = 'selected';
			} else {
				$aVelden['Status']['waarde'][$waarde][1] = '';
			}
		} 
		return $aVelden;
}

function definieer() {
$aVelden = array(
/*
 initiele waarde                 name			  type					value	status + css class			verplicht       controle                                 setter
 + css ID																		  ok||notok||init			true/false       functie
 */
'MaillijstID'  		=> array('naam' => 'id' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '40' , 'verplicht' => true, 'controle' => 'ctrlMaillijstID', 'setter' => 'setm_iMaillijstID'), 
'BedrijfID'  		=> array('naam' => 'bedrijfid' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '40' , 'verplicht' => true, 'controle' => 'ctrlBedrijfID', 'setter' => 'setm_iBedrijfID'), 
'Naam' 				=> array('naam' => 'naam' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '60' , 'verplicht' => true, 'controle' => 'ctrlNaamMaillijst', 'setter' => 'setm_sNaam'), 
'Status' 			=> array('naam' => 'status', 'type' => 'select','waarde' => array('actief' => array('Actief','selected'),'vervallen'=>array('Vervallen',''),'in bewerking'=>array('In bewerking','')), 'status' => 'ok' , 'size' => '1' , 'verplicht' => true, 'controle' => 'ctrlStatusMaillijst', 'setter' => 'setm_sStatus'),
'Opslaan'			=> array('naam' => 'command', 'type' => 'image','waarde' => 'img/knop_opslaan.png', 'status' => 'formbtn' , 'size' => '40' , 'verplicht' => false, 'controle' => '', 'setter' => ''),
'Bladeren'			=> array('naam' => 'bestand', 'type' => 'select','waarde' => importBestanden(), 'status' => 'ok' , 'size' => '2' , 'verplicht' => false, 'controle' => '', 'setter' => ''),  
'Importeer'			=> array('naam' => 'importeer', 'type' => 'image','waarde' => 'img/knop_importeren.png', 'status' => 'formbtn' , 'size' => '40' , 'verplicht' => false, 'controle' => '', 'setter' => '')
);

return $aVelden;
}

function importeer(&$objMaillijst){

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
$sQuery = '/personen/persoon/emailadres';
$nodeLijst = $objXpath->query($sQuery);

foreach($nodeLijst as $node){
	$objEmailadres = new clsEmailAdres();
	$objMaillijstEmailAdres = new clsMaillijstEmailAdres();
	
	$objEmailadres->setm_iBedrijfID($_SESSION['BedrijfID']);
	$objEmailadres->setm_sEmailAdres($node->nodeValue);
	
	if($objEmailadres->voegToe()){
		$objMaillijstEmailAdres->setm_iEmailAdresID($objEmailadres->getm_iEmailAdresID());
		$objMaillijstEmailAdres->setm_iBedrijfID($objMaillijst->getm_iBedrijfID());		
		$objMaillijstEmailAdres->setm_iMaillijstID($objMaillijst->getm_iMaillijstID());
		
		$objMaillijstEmailAdres->voegToe();
		
	}
	
}

return;
}

function importBestanden(){
	$aLijst = array(' ' =>array('','selected'));   
    $sDirNaam = 'Importfiles';
    if(file_exists($sDirNaam) && is_dir($sDirNaam)){
        $objDir = new DirectoryIterator($sDirNaam); 
		foreach($objDir as $objBestand) {
			if ( substr( $objBestand->getFileName(), -4) == '.xml'){
						$aEntry = $objBestand->getFileName().'=>array('.$objBestand->getFileName().',"")';
						array('actief' => array('Actief','selected'),'vervallen'=>array('Vervallen',''));
						$aLijst[$objBestand->getFileName()] = array($objBestand->getFileName(),'');
			}
		}

	}
	return $aLijst;
}
?>