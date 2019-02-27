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
$customer->setIdcustomer($idCustomer);
$customermanager = new CustomersManager($bdd);
$customermanager->delete($customer->getIdCustomer());
header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher");

?>
