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
$companymanager = new CompaniesManager($bdd);
$company->setIdcompany($companyId);
$test = $companymanager->reactivate($company);
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher/erroractivate");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher/successactivate");
}

?>
