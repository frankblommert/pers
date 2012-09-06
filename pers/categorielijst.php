<?php
require_once 'FuncClasses/clsCategorielijst.php';
require		 'src/includes/smartystart.php';
$aStylesheets = array('persmailbeheerbedrijf');		// wordt in smartyassign.php doorgegeven
$aJavascripts = array();							// wordt in smartyassign.php doorgegeven

try {
	$objCategorielijst = new clsCategorielijst();
	$smarty->assign('Categorieen', $objCategorielijst->toon(4));
}

catch (PDOException $e) {
	echo ("Error: " . $e->getMessage());
}

catch (Exception $e) {
	echo ("Fatal Error: " );
}
require 'src/includes/smartyassign.php';				// standaard smarty assignments
$smarty->display('smarty/templates/categorielijst.tpl');
?>
