<?php
// deze module includen na new Smarty

require_once 'FuncClasses/clsGebruikerBedrijf.php';
require_once 'DBClasses/clsDBGebruikerOntvanger.php';
session_set_cookie_params(600); 
session_start();
$sessionID = 'PHPSESSID='.session_id();
$smarty->assign('session', $sessionID);
try {
	switch(true){
		case (isset($_SESSION['Gebruikersnaam']) && authenticatie($_SESSION['Gebruikersnaam'],$_SESSION['Wachtwoord'])):
			break;
		case isset($_POST['inloggen_x']):
			if ( isset($_POST['naam']) && $_POST['naam'] != '') {
				if(authenticatie($_POST['naam'],md5($_POST['ww']))){
					break;
				}
			} 
			throw new Exception('U dient in te loggen met een geautoriseerde gebruikersnaam');			
			break;
		default:
			throw new Exception('U dient in te loggen met een geautoriseerde gebruikersnaam');
		}
}
catch (Exception $e) {
			$sMelding .= $e->getMessage().'<br />';
			session_set_cookie_params(1);
			session_start();		
			unset($_SESSION['TypeSessie']);
			unset($_SESSION['Gebruikersnaam']);
			unset($_SESSION['Wachtwoord']);
			unset($_SESSION['BedrijfID']);
			unset($_SESSION['Rechten']);
			unset($_COOKIE['PHPSESSID']);
			unset($_REQUEST['PHPSESSID']);
			unset($_GET['PHPSESSID']);
			$_SESSION = array();
			$_COOKIE = array();
			$_REQUEST = array();
			$_GET = array();
			sleep(1); 	
 		    require 'src/includes/smartyassign.php';
		    $smarty->assign('template' , 'login');   // overwrite van de standaard template 
		    $smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');
		    exit;
}

function authenticatie($naam, $wachtwoord) {
	
	$objGebbruikerBedrijf = new clsGebruikerBedrijf();
	if ($objGebbruikerBedrijf->GebruikerGebruikersnaam($naam) ) { 
		if ($wachtwoord == md5($objGebbruikerBedrijf->getm_sWachtwoord())&&
			$objGebbruikerBedrijf->getm_sStatus() == 'actief') {
			$_SESSION['TypeSessie'] = 'Bedrijf';
			$_SESSION['Gebruikersnaam']=$objGebbruikerBedrijf->getm_sGebruikernaam();
			$_SESSION['Wachtwoord']=md5($objGebbruikerBedrijf->getm_sWachtwoord());
			$_SESSION['BedrijfID']=$objGebbruikerBedrijf->getm_iBedrijfID();
			$_SESSION['Rechten']=$objGebbruikerBedrijf->getm_sRechten();
			$_SESSION['Naam']=$objGebbruikerBedrijf->getNaam();
			$objGebbruikerBedrijf->setm_iInlogPogingen(0);
			$objGebbruikerBedrijf->wijzig();
			$objGebbruikerBedrijf = null;
			unset($objGebbruikerBedrijf);
			return true;
		}
		
		if ($objGebbruikerBedrijf->getm_sStatus() == 'actief'){
			$objGebbruikerBedrijf->setm_iInlogPogingen($objGebbruikerBedrijf->getm_iInlogPogingen() + 1);
			$objGebbruikerBedrijf->wijzig();					 
		}
	}
	$objGebbruikerBedrijf = null;
	unset($objGebbruikerBedrijf);
	throw new Exception('U dient in te loggen met een geautoriseerde gebruikersnaam');
	/*
	$objDBGebbruikerBedrijf = new clsDBGebruikerBedrijf();

	$rs = $objDBGebbruikerBedrijf->selectGebruikersnaam($naam);
	
	$objDBGebbruikerBedrijf = null;
	unset($objDBGebbruikerBedrijf);
	
	if (isset($rs['Gebruikersnaam']) && md5($rs['Wachtwoord']) == $wachtwoord) {
		$_SESSION['TypeSessie'] = 'Bedrijf';
		$_SESSION['Gebruikersnaam']=$rs['Gebruikersnaam'];
		$_SESSION['Wachtwoord']=md5($rs['Wachtwoord']);
		$_SESSION['BedrijfID']=$rs['BedrijfID'];
		$_SESSION['Rechten']=$rs['Rechten'];
		$rs = null;
		unset($rs);
		return true;
	}
	$objDBGebbruikerOntvanger = new clsDBGebruikerOntvanger();
	$rs = $objDBGebbruikerOntvanger->selectGebruikersnaam($naam);
	$objDBGebbruikerOntvanger = null;
	unset($objDBGebbruikerOntvanger);
	if (isset($rs['Gebruikersnaam']) && md5($rs['Wachtwoord']) == $wachtwoord) {
		$_SESSION['TypeSessie'] = 'Ontvanger';
		$_SESSION['Gebruikersnaam']= $rs['Gebruikersnaam'];
		$_SESSION['Wachtwoord']= md5($rs['Wachtwoord']);
		$_SESSION['BedrijfID']= null;
		$_SESSION['Rechten']= null;
		unset($_SESSION['BedrijfID']);
		unset($_SESSION['Rechten']);
		$rs = null;
		unset($rs);
		return true;
	} else {
		return false;
	}  */
}

function autorisatie($p_sTypeSessie,$p_sRechten) {


	if($p_sTypeSessie == $_SESSION['TypeSessie'] && $p_sRechten == $_SESSION['Rechten']){
		return true;
	}
	if($p_sTypeSessie == $_SESSION['TypeSessie'] && 'Alle' == $_SESSION['Rechten']){
		return true;
	}
	if('Ontvanger' == $_SESSION['TypeSessie'] && !isset($_SESSION['Rechten'])){
		return true;
	}
	throw new Exception('U dient in te loggen met een geautoriseerde gebruikersnaam');
}

?>