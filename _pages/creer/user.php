<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$array = $array();
$company = new Company($array);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

?>

<html>
<head><title>Ma page d'accueil</title></head>
<body>
<h1>Création d'un utilisateur </h1>
<form name="inscription" method="post" action="<?php echo URLHOST."_pages/_post/creer_user.php"; ?>">
    <label for="login">Login :</label><input type="text" name="username" id="login" autofocus required/> <br/>
    <label for="passwd">Mot de passe : </label><input type="password" name="password" id="passwd" required/><br/>
    <label for="name">Nom : </label><input type="text" name="name" id="name" required/><br/>
    <label for="first_name">Prénom : </label><input type="text" name="firstname" id="firstname" required/><br/>
    <label for="ad_mail">Adresse mail : </label><input type="email" name="email_address"id="ad_mail" required/><br/>
    <label for="phone_number">Téléphone : </label><input type="tel" name="phone_number" id="phone_number" required/><br/>
    <label for="company">Société :</label> <?php
    foreach ($companies as $company)
    {
        echo'<input type="checkbox" name="case[]" value="'.$company->getIdCompany().'" />';
        echo $company->getName();
    }
    ?> <br/>
    <label for="credential">Droits d'accès : </label>
    <select name="credential" id="credential" required>
        <option value="U">Utilisateur</option>
        <option value="C">Compta</option>
        <option value="F">Facturation</option>
        <option value="A">Administrateur</option>
    </select><br/>
    <!--<label for="rights">Type Utilisateurs</label><input type="range" min="1" max="4" step="1" list="user_right"/>
    <datalist id="user_right">
      <option value="U" label="Utilisateur"></option>
      <option value="C" label="Compta"></option>
      <option value="F" label="Facturation"></option>
      <option value="A" label="Administrateur"></option>
    </datalist>-->
    <br />
    <label for="is_seller"></label>Commercial : <input type="checkbox" id"=is_seller" name="is_seller" value="is_seller" /> <br />
    <input type="submit" name="valider" value="Send"/>
</form>
</body>
</html>
