<?php 
// standaard smarty assignments include vlak voor de smarty display
require_once 'FuncClasses/clsAccount.php';
$smarty->assign('scriptnaam', $_SERVER['PHP_SELF'] );
$smarty->assign('stylesheets', stylesheets($aStylesheets)); // toekennen script specifieke stylesheets .css
$smarty->assign('javascripts', javascripts($aJavascripts)); // toekennen script specifieke javascripts .js
$smarty->assign('gebruikersnaam' , $_SESSION['Gebruikersnaam']);
$smarty->assign('naam' , $_SESSION['Naam']);
$smarty->assign('sessiontype' , $_SESSION['TypeSessie']);
$smarty->assign('melding' , $sMelding);
if($_SESSION['TypeSessie'] == 'Bedrijf'){
	$objAccountCredits = new clsAccount($_SESSION['BedrijfID']);
	$smarty->assign('aantalcredits' , $objAccountCredits->getm_iAantalCredits());
	$objAccountCredits = null;
}

$sTemplate = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1,-4);
if(!file_exists('smarty/templates/'.$sTemplate.'.tpl')){
	$sTemplate = 'default';
}
$smarty->assign('template' , $sTemplate);


function stylesheets($p_aStylesheets) {
	$aUitvoer = array();
	foreach($p_aStylesheets as $p_sStylesheet){
		$aCss[] = 'src/css/'.$p_sStylesheet.'.css';
	}	
	$aCss[] = 'src/css/'.substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1,-4).'.css'; // script specifieke css
	foreach($aCss as $css){
		if(file_exists($css)) {
			$aUitvoer[] = $css;
		}	
	}
	return $aUitvoer;
}

function javascripts($p_aJavascripts) {
	$aUitvoer = array();
	foreach($p_aJavascripts as $p_sJavascript){
		if(file_exists('src/js/'.$p_sJavascript.'.js')) {
			$aUitvoer[] = 'src/js/'.$p_sJavascript.'.js';
		}	
	}
	return $aUitvoer;
}

?>