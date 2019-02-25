<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$companyId = $_GET["idCompany"];

echo "Test : ".$companyId;

$array = array();
$company = new Company($array);
$company->setIdcompany($_GET["idcompany"]);
$companiesmanager = new CompaniesManager($bdd);
$companiesmanager->delete($company);
header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher");

?>
