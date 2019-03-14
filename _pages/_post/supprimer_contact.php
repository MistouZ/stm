<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$contactId = $_GET["idContact"];

$array = array();
$contact = new Contact($array);
$contact->setIdContact($contactId);
$contactmanager = new ContactManager($bdd);

if(isset($_GET["idCustomer"]))
{
    $customerId = $_GET["idCustomer"];
    $contactmanager->deleteToCustomer($contact, $customerId);
    header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/supprime");
}
elseif (isset($_GET["idSupplier"]))
{
    $supplierId = $_GET["idSupplier"];
    $contactmanager->deleteToSupplier($contact, $supplierId);
    header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$supplierId."/supprime");
}

?>
