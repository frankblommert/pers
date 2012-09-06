<?php
/*
require('Smarty.class.php');
$smarty = new Smarty;
*/

require('../smarty/Smarty.class.php');

$smarty = new Smarty;
$smarty->setTemplateDir('smarty/templates');
$smarty->setCompileDir('smarty/templates_c');
$smarty->setCacheDir('persmail/smarty/cache');
$smarty->setConfigDir('smarty/configs');

?>