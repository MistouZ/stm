<?php
define('URLHOST','http://dev.bitwin.nc/');

include 'classes/class_db.php';
include 'classes/class_features.php';
include 'classes/class_company.php';
include 'classes/class_companiesmanager.php';
include 'classes/class_customers.php';
include 'classes/class_customersmanager.php';
include 'classes/class_contact.php';
include 'classes/class_contactmanager.php';
include 'classes/class_suppliers.php';
include 'classes/class_suppliersmanager.php';
include 'classes/class_users.php';
include 'classes/class_usersmanager.php';
include 'classes/class_folder.php';
include 'classes/class_foldersmanager.php';
include 'classes/class_tax.php';
include 'classes/class_taxmanager.php';
/*include 'classes/class_quotation.php';
include 'classes/class_quotationmanager.php';
include 'classes/class_description.php';
include 'classes/class_descriptionmanager.php';*/

global $bdd;
$bdd = new DB();
$bdd->connexion();

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra');

?>