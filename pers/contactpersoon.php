<?php		
require_once 'FuncClasses/clsContactpersoon.php';
require_once 'src/includes/controlescontactpersoon.php';
require		 'src/includes/verwerkformulier.php';
require		 'src/includes/smartystart.php';

$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array('persmailform');				// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';					// authenticatie en session start includen na new Smarty

$aVelden = definieer();		   						//ophalen formulier definitie

try {
	autorisatie('Bedrijf','Alle');					// controleer soort gebruiker en rechten
	switch(true){
		case (isset($_REQUEST['opslaan_x'])):

			$objContactpersoon = new clsContactpersoon();			
			$aResult = verwerk($aVelden,$objContactpersoon);	// verwerk de ingevulde waardes
			$aVelden = $aResult['velden'];					// gecontroleerde waardes teruggeven in formulier definitie

			if ($aResult['ok']){								// waardes ok dus opslaan
				if($aVelden['ID']['waarde'] == '0'){			// sleutel 0 dus nieuw
					$objContactpersoon->voegToe();
					$aVelden['ID']['waarde'] = $objContactpersoon->getm_iID();
				} else {
					$objContactpersoon->wijzig();
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
$objContactpersoon = null;

require 'src/includes/smartyassign.php';				// standaard smarty assignments
$smarty->assign('formlist' , $aVelden );				
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');



function ophalen($aVelden){
		$objContactpersoon = new clsContactpersoon();
							
		$aVelden['ID']['waarde'] = $_REQUEST['sleutel'];
		$objContactpersoon->laad($aVelden['ID']['waarde']);
		$aVelden['ID']['waarde'] = $objContactpersoon->getm_iID();
		$aVelden['BedrijfID']['waarde'] = $objContactpersoon->getm_iBedrijfID();
		$aVelden['Afdeling']['waarde'] = $objContactpersoon->getm_sAfdeling(); 
		$aVelden['Voornaam']['waarde'] = $objContactpersoon->getm_sVoornaam(); 
		$aVelden['Tussenvoegsel']['waarde'] = $objContactpersoon->getm_sTussenvoegsel();
		$aVelden['Achternaam']['waarde'] = $objContactpersoon->getm_sAchternaam();
		$aVelden['Telefoon']['waarde'] = $objContactpersoon->getm_sTelefoonnummer();
		$aVelden['Email']['waarde'] = $objContactpersoon->getm_sEmailAdres();

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
'Afdeling' 			=> array('naam' => 'afdeling' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '80' , 'verplicht' => true, 'controle' => 'ctrlAfdeling', 'setter' => 'setm_sAfdeling'), 
'Opslaan'			=> array('naam' => 'opslaan', 'type' => 'image','waarde' => 'img/knop_opslaan.png', 'status' => 'formbtn' , 'size' => '40' , 'verplicht' => false, 'controle' => '', 'setter' => '')
);
return $aVelden;
}

?>