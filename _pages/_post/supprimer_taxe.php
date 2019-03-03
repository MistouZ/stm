<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idTax = $_GET["idTax"];

$array = array();
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$tax->setIdTax($idTax);
$test = $taxmanager->delete($tax);
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/taxe/afficher/error");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/taxe/afficher/delete");
}

?>
