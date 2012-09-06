<?php
		
require_once 'FuncClasses/clsBedrijf.php';
require_once 'src/includes/controlesbedrijf.php';
require		 'src/includes/verwerkformulier.php';
require		 'src/includes/smartystart.php';					

$aStylesheets = array('persmailbeheerbedrijf');					// wordt in smartyassign.php doorgegeven
$aJavascripts = array('persmailform');							// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';								// authenticatie en session start includen na new Smarty
$aVelden = definieer();		   									//ophalen formulier definitie

try {
	autorisatie('Bedrijf','Alle');								// controleer soort gebruiker en rechten
	if (isset($_POST['command_x'])) {
		$objBedrijf = new clsBedrijf($_SESSION['BedrijfID']); 	// object laden omdat niet iedere member variabele op het formulier staat		
		$aResult = verwerk($aVelden,$objBedrijf);				// verwerk de ingevulde waardes
		$aVelden = $aResult['velden'];							// gecontroleerde waardes teruggeven in formulier definitie
		if ($aResult['ok']){									// waardes ok dus opslaan
			$objBedrijf->wijzig();

		}
	} else {
		$aVelden = ophalen($aVelden);							// ophalen gegevens voor het formulier
	} 	
}
catch (PDOException $e) {
	$sMelding .= $e->getMessage().'<br />';
}
catch (Exception $e) {
	$sMelding .= $e->getMessage().'<br />';
}
$aVelden = initNietIngevuld($aVelden);


require 'src/includes/smartyassign.php';						// standaard smarty assignments
$smarty->assign('formlist' , $aVelden );			
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');	
$objBedrijf = null;


function ophalen($aVelden){
		$objBedrijf = new clsBedrijf($_SESSION['BedrijfID']);
		$objHoofdGebruiker = new clsGebruikerBedrijf();
		$objHoofdGebruiker->hoofdGebruiker($_SESSION['BedrijfID']);
		$aVelden['ID']['waarde'] = $objBedrijf->getm_iBedrijfID();
		$aVelden['Bedrijfsnaam']['waarde'] = $objBedrijf->getm_sBedrijfsnaam();
		$aVelden['Voornaam']['waarde'] = $objHoofdGebruiker->getm_sVoornaam();
		$aVelden['Tussenvoegsel']['waarde'] = $objHoofdGebruiker->getm_sTussenvoegsel();
		$aVelden['Achternaam']['waarde'] = $objHoofdGebruiker->getm_sAchternaam();
		$aVelden['Telefoon']['waarde'] = $objHoofdGebruiker->getm_sTelefoonnummer();
		$aVelden['Email']['waarde'] = $objHoofdGebruiker->getm_sEmailAdres();
		$aVelden['Straatnaam']['waarde'] = $objBedrijf->getm_sStraatnaam();
		$aVelden['Huisnummer']['waarde'] = $objBedrijf->getm_iHuisnummer();
		$aVelden['Toevoeging']['waarde'] = $objBedrijf->getm_sHuisnummerToev();
		$aVelden['Postcode']['waarde'] = $objBedrijf->getm_sPostcode();
		$aVelden['Plaats']['waarde'] = $objBedrijf->getm_sPlaats();
		$aVelden['Land']['waarde'] = $objBedrijf->getm_sLand();	
		$aVelden['StraatnaamPost']['waarde'] = $objBedrijf->getm_sStraatnaamPost();
		$aVelden['HuisnummerPost']['waarde'] = $objBedrijf->getm_iHuisnummerPost();
		$aVelden['ToevoegingPost']['waarde'] = $objBedrijf->getm_sHuisnummerToevPost();
		$aVelden['PostcodePost']['waarde'] = $objBedrijf->getm_sPostcodePost();
		$aVelden['PlaatsPost']['waarde'] = $objBedrijf->getm_sPlaatsPost();
		$aVelden['LandPost' ]['waarde'] = $objBedrijf->getm_sLandPost();
		$aVelden['BtwNummer']['waarde'] = $objBedrijf->getm_sBtwNummer();
		$aVelden['KvkNummer' ]['waarde'] = $objBedrijf->getm_sKvkNummer();
		$aVelden['Rekeningnummer']['waarde'] = $objBedrijf->getm_sRekeningnummer();

		return $aVelden;
}

function definieer() {
$aVelden = array(
/*
 initiele waarde                 name			  type					value	status + css class			verplicht       controle                                 setter
 + css ID																		  ok||notok||init			true/false       functie
 */
'Bedrijfsnaam' 		=> array('naam' => 'bedrijf' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '110' , 'verplicht' => true, 'controle' => 'ctrlBedrijfsnaam', 'setter' => 'setm_sBedrijfsnaam'), 
'Voornaam' 			=> array('naam' => 'voornaam', 'type' => 'text','waarde' => '', 'status' => 'readonly' , 'size' => '20' , 'verplicht' => true, 'controle' => 'ctrlVoornaam', 'setter' => 'setm_sVoornaam'),
'Tussenvoegsel'		=> array('naam' => 'tussenvoegsel', 'type' => 'text','waarde' => '', 'status' => 'readonly' , 'size' => '15' , 'verplicht' => false, 'controle' => 'ctrlTussenvoegsel', 'setter' => 'setm_sTussenvoegsel'),
'Achternaam' 		=> array('naam' => 'achternaam', 'type' => 'text','waarde' => '', 'status' => 'readonly' , 'size' => '62' , 'verplicht' => true, 'controle' => 'ctrlAchternaam', 'setter' => 'setm_sAchternaam'),
'Telefoon' 			=> array('naam' => 'telefoon', 'type' => 'text','waarde' => '', 'status' => 'readonly' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlTelefoonnummer', 'setter' => 'setm_sTelefoonnummer'),
'Email' 			=> array('naam' => 'email', 'type' => 'text','waarde' => '', 'status' => 'readonly' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlEmailAdres', 'setter' => 'setm_sEmailAdres'),
'Straatnaam' 		=> array('naam' => 'straat', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlStraatnaam', 'setter' => 'setm_sStraatnaam'),
'Huisnummer'		=> array('naam' => 'huisnummer', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlHuisnummer', 'setter' => 'setm_iHuisnummer'),
'Toevoeging'		=> array('naam' => 'toevoeging', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '14' , 'verplicht' => false, 'controle' => 'ctrlToevoeging', 'setter' => 'setm_sHuisnummerToev'),
'Postcode' 			=> array('naam' => 'postcode', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlPostcode', 'setter' => 'setm_sPostcode'),
'Plaats' 			=> array('naam' => 'plaats', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlPlaats', 'setter' => 'setm_sPlaats'),
'Land' 				=> array('naam' => 'land', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => false, 'controle' => 'ctrlLand', 'setter' => 'setm_sLand'),
'BtwNummer'			=> array('naam' => 'btw', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlBtwNummer', 'setter' => 'setm_sBtwNummer'),
'KvkNummer' 		=> array('naam' => 'kvk', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlKvkNummer', 'setter' => 'setm_sKvkNummer'),
'Rekeningnummer'	=> array('naam' => 'rekeningnummer', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlRekeningnummer', 'setter' => 'setm_sRekeningnummer'),
'StraatnaamPost'	=> array('naam' => 'straatpost', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => false, 'controle' => 'ctrlStraatnaam', 'setter' => 'setm_sStraatnaamPost'),
'HuisnummerPost'	=> array('naam' => 'huisnummerpost', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => false, 'controle' => 'ctrlHuisnummer', 'setter' => 'setm_iHuisnummerPost'),
'ToevoegingPost'	=> array('naam' => 'toevoegingpost', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '14' , 'verplicht' => false, 'controle' => 'ctrlToevoeging', 'setter' => 'setm_sHuisnummerToevPost'),
'PostcodePost' 		=> array('naam' => 'postcodepost', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => false, 'controle' => 'ctrlPostcode', 'setter' => 'setm_sPostcodePost'),
'PlaatsPost' 		=> array('naam' => 'plaatspost', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => false, 'controle' => 'ctrlPlaats', 'setter' => 'setm_sPlaatsPost'),
'LandPost' 			=> array('naam' => 'landpost', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => false, 'controle' => 'ctrlLand', 'setter' => 'setm_sLandPost'),
'Opslaan'			=> array('naam' => 'command', 'type' => 'image','waarde' => 'img/knop_opslaan.png', 'status' => 'formbtn' , 'size' => '42' , 'verplicht' => false, 'controle' => '', 'setter' => ''),
'ID'  				=> array('naam' => 'id' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '40' , 'verplicht' => true, 'controle' => '', 'setter' => 'setm_iBedrijfID')
);															
return $aVelden;
}
?>