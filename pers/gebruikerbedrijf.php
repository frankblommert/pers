<?php		
require_once 'FuncClasses/clsGebruikerBedrijf.php';
require_once 'src/includes/controlesgebruikerbedrijf.php';
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
				$objGebruikerBedrijf = new clsGebruikerBedrijf();			
				$aResult = verwerk($aVelden,$objGebruikerBedrijf);	// verwerk de ingevulde waardes
				$aVelden = $aResult['velden'];						// gecontroleerde waardes teruggeven in formulier definitie
				if ($aResult['ok']){								// waardes ok dus opslaan
					if($aVelden['ID']['waarde'] == '0'){			// sleutel 0 dus nieuw
						$objGebruikerBedrijf->voegToe();
						$aVelden['ID']['waarde'] = $objGebruikerBedrijf->getm_iID();
					} else {
						$objGebruikerBedrijf->wijzig();
					}
				}
				break;
			case (isset($_REQUEST['command'])):
				switch($_REQUEST['command']){
					case "Wijzigen":
						if (isset($_REQUEST['sleutel'])) {
							$aVelden = ophalen($aVelden);			// ophalen gegevens voor het formulier
						} else {
							throw new Exception('Geen ID bekend bij wijziging');
						}
						break;
					case "Nieuw":
						$aVelden['ID']['waarde'] = '0';
						$aVelden['Inlogpogingen']['waarde'] = '0';
						$aVelden['BedrijfID']['waarde'] = $_SESSION['BedrijfID'];
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

$aVelden = initNietIngevuld($aVelden);
$objGebruikerBedrijf = null;

require 'src/includes/smartyassign.php';				// standaard smarty assignments
$smarty->assign('formlist' , $aVelden );				
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');



function ophalen($aVelden){
	
		$objGebruikerBedrijf = new clsGebruikerBedrijf($_REQUEST['sleutel']);	
		$aVelden['ID']['waarde'] = $objGebruikerBedrijf->getm_iID();
		$aVelden['BedrijfID']['waarde'] = $objGebruikerBedrijf->getm_iBedrijfID();
		$aVelden['Voornaam']['waarde'] = $objGebruikerBedrijf->getm_sVoornaam(); 
		$aVelden['Tussenvoegsel']['waarde'] = $objGebruikerBedrijf->getm_sTussenvoegsel();
		$aVelden['Achternaam']['waarde'] = $objGebruikerBedrijf->getm_sAchternaam();
		$aVelden['Telefoon']['waarde'] = $objGebruikerBedrijf->getm_sTelefoonnummer();
		$aVelden['Email']['waarde'] = $objGebruikerBedrijf->getm_sEmailAdres();
		$aVelden['Personeelsnummer']['waarde'] = $objGebruikerBedrijf->getm_sPersoneelsnummer();
		$aVelden['Gebruikersnaam']['waarde'] = $objGebruikerBedrijf->getm_sGebruikernaam();
		$aVelden['Wachtwoord']['waarde'] = $objGebruikerBedrijf->getm_sWachtwoord();
		foreach($aVelden['Rechten']['waarde'] as $waarde => $omschrijving){
			if($waarde == $objGebruikerBedrijf->getm_sRechten()){
				$aVelden['Rechten']['waarde'][$waarde][1] = 'selected';
			} else {
				$aVelden['Rechten']['waarde'][$waarde][1] = '';
			}
		}

		foreach($aVelden['Status']['waarde'] as $waarde => $omschrijving){
			if($waarde == $objGebruikerBedrijf->getm_sStatus()){
				$aVelden['Status']['waarde'][$waarde][1] = 'selected';
			} else {
				$aVelden['Status']['waarde'][$waarde][1] = '';
			}
		}

		foreach($aVelden['Hoofdgebruiker']['waarde'] as $waarde => $omschrijving){
			if($waarde == $objGebruikerBedrijf->getm_sHoofdgebruiker()){
				$aVelden['Hoofdgebruiker']['waarde'][$waarde][1] = 'selected';
			} else {
				$aVelden['Hoofdgebruiker']['waarde'][$waarde][1] = '';
			}
		}
		$aVelden['Inlogpogingen']['waarde'] = $objGebruikerBedrijf->getm_iInlogpogingen();
		return $aVelden;
}


function definieer() {
$aVelden = array(
/*
 initiele waarde                 name			  type					value	status + css class			verplicht       controle                                 setter
 + css ID																		  ok||notok||init			true/false       functie
 */

'ID'  				=> array('naam' => 'id' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlID', 'setter' => 'setm_iID'), 
'BedrijfID'  		=> array('naam' => 'bedrijfid' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => '', 'setter' => 'setm_iBedrijfID'), 
'Voornaam' 			=> array('naam' => 'voornaam', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlVoornaam', 'setter' => 'setm_sVoornaam'),
'Tussenvoegsel'		=> array('naam' => 'tussenvoegsel', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => false, 'controle' => 'ctrlTussenvoegsel', 'setter' => 'setm_sTussenvoegsel'),
'Achternaam' 		=> array('naam' => 'achternaam', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlAchternaam', 'setter' => 'setm_sAchternaam'),
'Telefoon' 			=> array('naam' => 'telefoon', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => false, 'controle' => 'ctrlTelefoonnummer', 'setter' => 'setm_sTelefoonnummer'),
'Email' 			=> array('naam' => 'email', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlEmailAdres', 'setter' => 'setm_sEmailAdres'),
'Personeelsnummer'	=> array('naam' => 'personeelsnummer' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => false, 'controle' => 'ctrlPersoneelsnummer', 'setter' => 'setm_sPersoneelsnummer'),
'Gebruikersnaam'	=> array('naam' => 'gebruikersnaam' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlGebruikersnaam', 'setter' => 'setm_sGebruikernaam'),
'Wachtwoord'		=> array('naam' => 'wachtwoord' , 'type' => 'password','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlWachtwoord', 'setter' => 'setm_sWachtwoord'),
'Rechten'			=> array('naam' => 'Rechten' , 'type' => 'select','waarde' => array('Alle' => array('Alle',''),'Berichten'=>array('Berichten','selected')) , 'status' => 'ok' , 'size' => '120' , 'verplicht' => true, 'controle' => 'ctrlRechten', 'setter' => 'setm_sRechten'),
'Status'			=> array('naam' => 'status' , 'type' => 'select','waarde' => array('actief' => array('Actief',''),'geblokkeerd'=>array('Geblokkeerd','selected')), 'status' => 'ok' , 'size' => '120' , 'verplicht' => true, 'controle' => 'ctrlStatusGebruiker', 'setter' => 'setm_sStatus'),
'Hoofdgebruiker'	=> array('naam' => 'hoofdgebruiker' , 'type' => 'select','waarde' =>  array('j' => array('Ja',''),'n'=>array('Nee','selected')), 'status' => 'ok' , 'size' => '120' , 'verplicht' => true, 'controle' => 'ctrlHoofdgebruiker', 'setter' => 'setm_sHoofdgebruiker'),
'Inlogpogingen'		=> array('naam' => 'inlogpogingen' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlInlogpogingen', 'setter' => 'setm_iInlogpogingen'),

'Opslaan'			=> array('naam' => 'command', 'type' => 'image','waarde' => 'img/knop_opslaan.png', 'status' => 'formbtn' , 'size' => '40' , 'verplicht' => false, 'controle' => '', 'setter' => '')

);
return $aVelden;
}

?>