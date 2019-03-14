<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idContact = $_GET["idContact"];

$array = array();
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);
$contact->setIdContact($idContact);
$test = $contactmanager->reactivate($customer);
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/erroractivate");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/successactivate");
}

?>
