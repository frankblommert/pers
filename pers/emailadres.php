<?php		
require_once 'FuncClasses/clsEmailAdres.php';
require_once 'src/includes/controlesemailadres.php';
require		 'src/includes/verwerkformulier.php';
require		 'src/includes/smartystart.php';

$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array();							// wordt in smartyassign.php doorgegeven

require 'src/includes/login.php';					// authenticatie en session start includen na new Smarty

$velden = definieer();		   						//ophalen formulier definitie

try {
	autorisatie('Bedrijf','Alle');					// controleer soort gebruiker en rechten
	if (isset($_REQUEST['command'])) {
		switch($_REQUEST['command']){
			case "Opslaan":

				$objEmailAdres = new clsEmailAdres();			
				$result = verwerk($velden,$objEmailAdres);	// verwerk de ingevulde waardes

				$velden = $result['velden'];					// gecontroleerde waardes teruggeven in formulier definitie

				if ($result['ok']){								// waardes ok dus opslaan
					if($velden['EmailAdresID']['waarde'] == '0'){			// sleutel 0 dus nieuw
						$objEmailAdres->voegToe();
						$velden['EmailAdresID']['waarde'] = $objEmailAdres->getm_iEmailAdresID();
					} else {
						$objEmailAdres->wijzig();
					}				
				}
				break;
			case "Wijzigen":
				if (isset($_REQUEST['sleutel'])) {
					$velden = ophalen($velden);			// ophalen gegevens voor het formulier
				} else {
					throw new Exception('Geen ID bekend bij wijziging');
				}
				break;
			case "Nieuw":
				$velden['EmailAdresID']['waarde'] = '0';
				$velden['BedrijfID']['waarde'] = $_SESSION['BedrijfID'];
				break;
			default:
				throw new Exception('Onbekende actie op formulier uitgevoerd');
				break;
		}
	} 	
}
catch (PDOException $e) {
	$melding .= $e->getMessage().'<br />';
}
catch (Exception $e) {
	$melding .= $e->getMessage().'<br />';
}
$velden = initNietIngevuld($velden);
$objEmailAdres = null;

require 'src/includes/smartyassign.php';				// standaard smarty assignments
$smarty->assign('formlist' , $velden );				
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');

function ophalen($velden){
		$objEmailAdres = new clsEmailAdres();
		$objEmailAdres->laad($_SESSION['BedrijfID'],$_REQUEST['sleutel']);
		$velden['EmailAdresID']['waarde'] = $objEmailAdres->getm_iEmailAdresID();
		$velden['BedrijfID']['waarde'] = $objEmailAdres->getm_iBedrijfID();
		$velden['EmailAdres']['waarde'] = $objEmailAdres->getm_sEmailAdres(); 

		return $velden;
}

function definieer() {
$velden = array(
/*
 initiele waarde                 name			  type					value	status + css class			verplicht       controle                                 setter
 + css ID																		  ok||notok||init			true/false       functie
 */
'EmailAdresID'  	=> array('naam' => 'id' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '40' , 'verplicht' => true, 'controle' => 'ctrlEmailAdresID', 'setter' => 'setm_iEmailAdresID'), 
'BedrijfID'  		=> array('naam' => 'bedrijfid' , 'type' => 'hidden','waarde' => '', 'status' => 'ok' , 'size' => '40' , 'verplicht' => true, 'controle' => 'ctrlBedrijfID', 'setter' => 'setm_iBedrijfID'), 
'EmailAdres' 		=> array('naam' => 'emailadres' , 'type' => 'text','waarde' => '', 'status' => 'ok' , 'size' => '120' , 'verplicht' => true, 'controle' => 'ctrlEmailAdres', 'setter' => 'setm_sEmailAdres'), 
'Opslaan'			=> array('naam' => 'command', 'type' => 'submit','waarde' => 'Opslaan', 'status' => 'formbtn' , 'size' => '40' , 'verplicht' => false, 'controle' => '', 'setter' => '')
);
return $velden;
}

?>