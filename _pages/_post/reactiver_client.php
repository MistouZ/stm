<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idCustomer = $_GET["idCustomer"];

$array = array();
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$customer->setIdcustomer($idCustomer);
$test = $customermanager->reactivate($customer);
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/erroractivate");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/successactivate");
}

?>
