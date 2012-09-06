<?php
$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array();							// wordt in smartyassign.php doorgegeven

require		 'src/includes/smartystart.php';
try {
	if (isset($_REQUEST['command'])) {
		switch($_REQUEST['command']){
			case "Inloggen":
				require('src/includes/login.php');
				break;
			case "Uitloggen":
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
require 'src/includes/smartyassign.php';				// standaard smarty assignments			
$smarty->display('smarty/templates/persmailbeheerbedrijf.tpl');
?>