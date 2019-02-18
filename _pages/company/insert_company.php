<?php

session_start();
$path = "../";

include_once($path.'classes/class_db.php');
include_once($path.'classes/class_features.php');
include_once($path.'classes/class_company.php');
include_once($path.'classes/class_companiesmanager.php');

$bdd = new DB();
$bdd->connexion();

if(isset($_POST['valider'])) {
    $name=$_POST['name'];
    $address=$_POST['address'];
    $isActive = 1;
    $array = array(
        'name' => $name,
        'address' => $address,
        'isActive' => $isActive
    );

    $company = new Company($array);
    $companiesmanager = new CompaniesManager($bdd);
    $companiesmanager->add($company);

}

?>

<a href="saisie_company.php"> revenir à la création de Société </a>
