<?php

require_once 'FuncClasses/clsBedrijf.php';
require_once 'FuncClasses/clsAccount.php';
require_once 'src/includes/controlesbedrijf.php';


require		 'src/includes/smartystart.php';

$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array('persmailform');				// wordt in smartyassign.php doorgegeven

$aVelden = definieer();		   						//ophalen formulier definitie
$sMelding = null;

try {
    if (isset($_POST['inloggen_x'])){
    	require ('src/includes/login.php');
    	header( "Location: http://".$_SERVER['SERVER_NAME'].substr($_SERVER['REQUEST_URI'],0,strripos($_SERVER['REQUEST_URI'],'/'))."/bedrijf.php?".$sessionID );
    }
	if (isset($_POST['command_x'])) {
		$objBedrijf = new clsBedrijf();	
		$objHoofdGebruiker = new clsGebruikerBedrijf();	
		$objAccount = new clsAccount();
		
		$aResult = verwerk($aVelden,$objBedrijf,$objHoofdGebruiker);	// verwerk de ingevulde waardes
		$aVelden = $aResult['velden'];								// gecontroleerde waardes teruggeven in formulier definitie

	
		$aVelden = initNietIngevuld($aVelden);

		if ($aResult['ok']){											// waardes ok dus opslaan
			$objBedrijf->voegToe();
			
			$objHoofdGebruiker->setm_iBedrijfID($objBedrijf->getm_iBedrijfID());
			$objHoofdGebruiker->setm_sRechten('Alle');
			$objHoofdGebruiker->setm_sHoofdgebruiker('j');
			$objHoofdGebruiker->setm_sStatus('actief');
			$objHoofdGebruiker->setm_iInlogPogingen('0');
			$objHoofdGebruiker->voegToe();
			
			$objAccount->setm_iBedrijfID($objBedrijf->getm_iBedrijfID());
			
			$objAccount->setm_iAccountID('1');
			$objAccount->setm_sStatus('actief');
			$objAccount->setm_iAantalCredits('0');
			
			$objAccount->voegToe();
			
			if(isset($_POST['betalen'])){											//direct betalen
				$objBedrijf->koopAbonnement();
			}
			
			session_set_cookie_params(600); 										//automatische inlog
			session_start();
			$sessionID = 'PHPSESSID='.session_id();
			$_SESSION['TypeSessie'] = 'Bedrijf';
			$_SESSION['Gebruikersnaam']=$objHoofdGebruiker->getm_sGebruikernaam();
			$_SESSION['Wachtwoord']=md5($objHoofdGebruiker->getm_sWachtwoord());
			$_SESSION['BedrijfID']=$objHoofdGebruiker->getm_iBedrijfID();
			$_SESSION['Rechten']=$objHoofdGebruiker->getm_sRechten();
			$_SESSION['Naam']=$objHoofdGebruiker->getNaam(); 
			
			header( "Location: http://".$_SERVER['SERVER_NAME'].substr($_SERVER['REQUEST_URI'],0,strripos($_SERVER['REQUEST_URI'],'/'))."/bedrijf.php?".$sessionID );
			exit;
		}
	} else {
		$aVelden = initNietIngevuld($aVelden);
	} 	
}
catch (PDOException $e) {
	$sMelding .= $e->getMessage().'<br />';
	$objBedrijf->verwijder();
}
catch (Exception $e) {
	$sMelding .= $e->getMessage().'<br />';
	$objBedrijf->verwijder();
}




require 'src/includes/smartyassign.php';				// standaard smarty assignments

$smarty->assign('formlist' , $aVelden );				
$smarty->display('smarty/templates/persmailabonneren.tpl');

$objBedrijf = null;
$objHoofdGebruiker = null;
$objAccount = null;

function definieer() {
$aVelden = array(
/*
 initiele waarde                 name			  type					value	status + css class			verplicht       controle                                 setter
 + css ID																		  ok||notok||init			true/false       functie
 */
'Bedrijfsnaam' 		=> array('naam' => 'bedrijf' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '110' , 'verplicht' => true, 'controle' => 'ctrlBedrijfsnaam', 'setter' => 'setm_sBedrijfsnaam'), 
'Voornaam' 			=> array('naam' => 'voornaam', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '20' , 'verplicht' => true, 'controle' => 'ctrlVoornaam', 'setter' => 'setm_sVoornaam'),
'Tussenvoegsel'		=> array('naam' => 'tussenvoegsel', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '15' , 'verplicht' => false, 'controle' => 'ctrlTussenvoegsel', 'setter' => 'setm_sTussenvoegsel'),
'Achternaam' 		=> array('naam' => 'achternaam', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '62' , 'verplicht' => true, 'controle' => 'ctrlAchternaam', 'setter' => 'setm_sAchternaam'),
'Telefoon' 			=> array('naam' => 'telefoon', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlTelefoonnummer', 'setter' => 'setm_sTelefoonnummer'),
'Email' 			=> array('naam' => 'email', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlEmailAdres', 'setter' => 'setm_sEmailAdres'),
'Gebruikersnaam'	=> array('naam' => 'gebruikersnaam', 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlGebruikersnaam', 'setter' => 'setm_sGebruikernaam'),
'Wachtwoord' 		=> array('naam' => 'wachtoord', 'type' => 'password','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => 'ctrlWachtwoord', 'setter' => 'setm_sWachtwoord'),
'Wachtwoordcheck'	=> array('naam' => 'wachtwoordcheck', 'type' => 'password','waarde' => '', 'status' => 'ok' , 'size' => '42' , 'verplicht' => true, 'controle' => '', 'setter' => ''),
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
'Voorwaarden'		=> array('naam' => 'voorwaarden', 'type' => 'checkbox','waarde' => array('Ik accepteer de algemene voorwaarden van Persmail',''), 'status' => 'ok' , 'size' => '110' , 'verplicht' => true, 'controle' => 'ctrlAlgVoorwaarden', 'setter' => 'setm_sAlgVoorwaarden'),
'Machtiging'		=> array('naam' => 'machtiging', 'type' => 'checkbox','waarde' => array('Ik machtig Persmail het jaarlijkse abonnenment automatisch te incasseren',''), 'status' => 'ok' , 'size' => '110' , 'verplicht' => true, 'controle' => 'ctrlIncasso', 'setter' => 'setm_sIncasso'),
'Betalen'			=> array('naam' => 'betalen', 'type' => 'checkbox','waarde' => array('Het eerste jaar betaal ik direct',''), 'status' => 'ok' , 'size' => '110' , 'verplicht' => true, 'controle' => '', 'setter' => ''),
'Opslaan'			=> array('naam' => 'command', 'type' => 'image','waarde' => 'img/knop_opslaan.png', 'status' => 'formbtn' , 'size' => '42' , 'verplicht' => false, 'controle' => '', 'setter' => '')
);															
return $aVelden;
}

function verwerk($invoer,&$objBedrijf,&$objHoofdGebruiker){

		$aResult = array(ok => true, velden => '');												// algemene status ok, terug te geven velden initialiseren 

		foreach($invoer as $init => $inhoud){															// voor ieder veld op formulier
			if($_POST[$invoer[$init]['naam']] == $init && $inhoud['type'] != 'submit' ){ 	            // geen waarde ingevuld?															
				$_POST[$invoer[$init]['naam']] = "";													// leegmaken voor controle (tekst met omschrijving weg)
			}
			if($invoer[$init]['controle'] != ''){														// controle functie
				if(!$invoer[$init]['controle']($_POST[$invoer[$init]['naam']])){						// controle fout?
					$invoer[$init]['status'] = 'notok';													// status veld notok
					$aResult['ok'] = false;																// algemene status notok
				}
			}
			
			if($invoer[$init]['status'] == 'ok'){														// veld goed?
				if ($invoer[$init]['setter'] != ''){													// setter ingevuld?
					switch($init){																		// rubrieken uit anderobjecten in case bedrijf in default
						case 'Voornaam' :   
						case 'Tussenvoegsel':	
						case 'Achternaam':
						case 'Telefoon':
						case 'Email':
						case 'Gebruikersnaam':
						case 'Wachtwoord':
							$objHoofdGebruiker->$invoer[$init]['setter']($_POST[$invoer[$init]['naam']]);	// set waarde in object
							break;
						default:
							$objBedrijf->$invoer[$init]['setter']($_POST[$invoer[$init]['naam']]);		// set waarde in object
					}					
				}	
			}
			switch($invoer[$init]['type']){	
				case 'image':
					break;				
				case 'submit':
					break;
				case 'select':
					foreach($invoer[$init]['waarde'] as $waarde => $omschrijving){							
						if ($waarde == $_POST[$invoer[$init]['naam']]){								// vergelijk mogelijke waarde met invoer
							$invoer[$init]['waarde'][$waarde][1] = 'selected';						// indien gelijk zet selected
						} else {
							$invoer[$init]['waarde'][$waarde][1] = '';								// indien ongelijk selected op null
						}
					}
					break;
				case 'checkbox':					
					if ($invoer[$init]['waarde'][0] == $_POST[$invoer[$init]['naam']]){				// vergelijk mogelijke waarde met invoer
						$invoer[$init]['waarde'][1] = 'checked="checked"';							// indien gelijk zet checked
					} else {
						$invoer[$init]['waarde'][1] = '';											// indien ongelijk checked op null
					}
					break;
				default:
					$invoer[$init]['waarde'] = $_POST[$invoer[$init]['naam']];						// zet waarde op het formulier				
			}
													
			
		}
		if ($invoer['Wachtwoord']['waarde'] != $_POST['wachtwoordcheck']){			// vergelijk beide wachtwoorden met elkaar
			$invoer['Wachtwoord']['status'] = 'notok';
			$invoer['Wachtwoordcheck']['status'] = 'notok';
			$aResult['ok'] = false;
		}
		$aResult['velden'] = $invoer;																// invoer velden naar result tabel
		return $aResult;
}

function initNietIngevuld($invoer){

		foreach($invoer as $init => $inhoud){															 // voor veld op formuier
			if(($inhoud['waarde'] == "" || $inhoud['waarde'] == $init) 
			&& $inhoud['type'] != 'submit' && $inhoud['type'] != 'select' ){ // als niet ingevuld og gelijk omschrijving en geen button
				$invoer[$init]['waarde'] = $init;														 // waarde wordt omschrijving
				$invoer[$init]['status'] = 'init';														 // status wordt init
				if ($inhoud['verplicht'] && isset($_POST['command_x'])){									 // verplicht veld?
					$aResult['ok'] = false;																 // zo ja fout
					$invoer[$init]['status'] = 'notok';													 // status veld = fout
				} 
			}
		}
;
												
		return $invoer;;
}

?>
