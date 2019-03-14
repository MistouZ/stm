<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idSupplier = $_GET["idSupplier"];

$array = array();
$supplier = new Suppliers($array);
$supplier->setIdsupplier($idSupplier);
$suppliermanager = new SuppliersManager($bdd);
$test = $suppliermanager->reactivate($supplier);
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/erroractivate");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/successactivate");
}

?>
