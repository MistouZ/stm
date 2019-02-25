<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$companyId = $_GET["idCompany"];

$array = array();
$company = new Company($array);
$companiesmanager = new CompaniesManager($bdd);
$companiesmanager->delete($companyId);
header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher");

?>
