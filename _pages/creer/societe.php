<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$array = array();
$company = new Company($array);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

?>
<html>
    <body>
    <h1>Création d'une société</h1>
        <form name="inscription" method="post" action="<?php echo URLHOST."_pages/_post/creer_societe.php"; ?>" enctype="multipart/form-data">
            <label for="name">Nom de la société :</label><input type="text" name="name" id="name"/> <br/>
            <label for="physical_address">Adresse physique du client : </label><input type="text" name="address" id="address"/><br/>
            <label for="logo_company">Uploader le logo de la société : </label><input type="file" name="nameData" id="nameData"  accept="image/png, image/jpeg" /><br/>
            <input type="submit" name="valider" value="OK"/>
        </form>
    </body>
</html>