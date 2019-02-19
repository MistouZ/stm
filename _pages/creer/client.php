<?php

/**
 * @author Amaury
 * @copyright 2019
 */


session_start();
$path ="../../";
include_once($path.'_cfg/classes/class_db.php');
include_once($path.'classes/class_features.php');
include_once ($path.'classes/class_company.php');
include_once ($path.'classes/class_companiesmanager.php');

$bdd = new DB();
$bdd->connexion();
$array = array();
$company = new Company($array);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

 ?>
<html>
    <head><title>Création d'un nouveau Client / Fournisseur</title></head>
    <body>
        <h1>Bienvenue sur le site de création de clients STM-Compta pour Moy par Moy </h1>
        <h2>Commencez-donc par vous inscrire :</h2>
        <form name="inscription" method="post" action="insert_customers.php">
            <label for="name">Nom de la société : </label><input type="text" name="name" id="name"/> <br/>
            <label for="physical_address">Adresse phyisque du client : </label><input type="text" name="physical_address" id="physical_address"/><br/>
            <label for="invoice_address">Adresse de facturation du client : (si différente de l'adresse physique) </label><input type="text" name="invoice_address" id="invoice_address"/><br/>
            <label for="is_supplier">Le client est-il aussi un fournisseur ? </label> <input type="checkbox" id"=is_supplier" name="is_supplier" value="is_supplier" /> <br />
            <label for="company">Société :</label> <?php
            foreach ($companies as $company)
            {
                echo'<input type="checkbox" name="case[]" value="'.$company->getIdCompany().'" />';
                echo $company->getName();
            }
            ?> <br/>
            <input type="submit" name="valider" value="OK"/>
        </form>
    </body>
</html>
