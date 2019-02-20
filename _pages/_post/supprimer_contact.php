<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$_GET[""];

$array = array();
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);
$contactmanager->addToCustomers($contact, $customerId);
echo "New contact added successfully </br/>";
