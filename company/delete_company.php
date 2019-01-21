<?php

    session_start();
    $path = "../";

    include_once($path.'classes/class_db.php');
    include_once($path.'classes/class_features.php');
    include_once($path.'classes/class_company.php');
    include_once($path.'classes/class_companiesmanager.php');


    $bdd = new DB();
    $bdd->connexion();
    $array = array();
    $company = new Company($array);
    $company->setIdcompany($_GET["idcompany"]);
    $companiesmanager = new CompaniesManager($bdd);
    $companiesmanager->delete($company);

    echo "Société supprimée avec succès <br />";


?>

<a href="show_company.php"> Revenir à la liste des Sociétés</a>
