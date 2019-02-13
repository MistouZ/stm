<?php

session_start();
$path = "../";

include_once($path.'classes/class_db.php');
include_once($path.'classes/class_features.php');
include_once($path.'classes/class_company.php');
include_once($path.'classes/class_companiesmanager.php');
$idcompany = $_SESSION["idcompany"];

$bdd = new DB();
$bdd->connexion();

if(isset($_POST['valider'])) {
    $name=$_POST['name'];
    $address=$_POST['address'];
    $isActive = 1;
    $array = array(
        'idcompany' => $idcompany,
        'name' => $name,
        'address' => $address,
        'isActive' => $isActive
    );

    $company = new Company($array);
    $companiesmanager = new CompaniesManager($bdd);
    $companiesmanager->update($company);

    echo "Mise à jour effectuée <br />";

}

?>

<a href="show_company.php"> Revenir à la liste des Sociétés</a>
