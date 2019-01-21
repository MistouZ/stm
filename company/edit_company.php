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
    $companiesmanager = new CompaniesManager($bdd);

    $company = $companiesmanager->get($_GET["idcompany"]);
    $_SESSION["idcompany"] = $_GET["idcompany"];


?>

<html>
    <head><title>Ma page d'accueil</title></head>
    <body>
        <h1>Bienvenue sur le site de modification de société STM-Compta pour Moy par Moy </h1>
        <h2>Commencez-donc par vous inscrire :</h2>
        <form name="inscription" method="post" action="update_company.php">
            Nom de la société : <input type="text" name="name" value="<?php echo $company->getName(); ?>"/> <br/>
            Adresse de la société : <input type="text" name="address" value="<?php echo $company->getAddress(); ?>"/><br/>
            <input type="submit" name="valider" value="Modifier"/>
        </form>
    </body>
</html>
