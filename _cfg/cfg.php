<?php

include '_cfg/classes/class_db.php';
include '_cfg/classes/class_features.php';
include '_cfg/classes/class_company.php';
include '_cfg/classes/class_companiesmanager.php';
include '_cfg/classes/class_customers.php';
include '_cfg/classes/class_customersmanager.php';
include '_cfg/classes/class_contact.php';
include '_cfg/classes/class_contactmanager.php';
include '_cfg/classes/class_suppliers.php';
include '_cfg/classes/class_suppliersmanager.php';

$bdd = new DB();
$bdd->connexion();

define('URLHOST','http://dev.bitwin.nc/');

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra');

echo "CFG INCLUDE";
?>