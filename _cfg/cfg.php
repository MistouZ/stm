<?php
include_once('classes/class_db.php');
include_once('classes/class_features.php');
include_once('classes/class_customers.php');
include_once('classes/class_customersmanager.php');
include_once('classes/class_contact.php');
include_once('classes/class_contactsmanager.php');
include_once('classes/class_suppliers.php');
include_once('classes/class_suppliersmanager.php');

$bdd = new DB();
$bdd->connexion();

define('URLHOST','http://dev.bitwin.nc/');

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
?>