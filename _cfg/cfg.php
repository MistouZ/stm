<?php
define('URLHOST','http://dev.bitwin.nc/');
if(!@include_once(URLHOST.'_cfg/classes/class_db.php')) {
include URLHOST.'_cfg/classes/class_db.php';
include URLHOST.'_cfg/classes/class_features.php';
include URLHOST.'_cfg/classes/class_company.php';
include URLHOST.'_cfg/classes/class_companiesmanager.php';
include URLHOST.'_cfg/classes/class_customers.php';
include URLHOST.'_cfg/classes/class_customersmanager.php';
include URLHOST.'_cfg/classes/class_contact.php';
include URLHOST.'_cfg/classes/class_contactmanager.php';
include URLHOST.'_cfg/classes/class_suppliers.php';
include URLHOST.'_cfg/classes/class_suppliersmanager.php';

$bdd = new DB();
$bdd->connexion();

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra');
}else{
    echo "non";
}

?>