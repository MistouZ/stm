<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/02/2019
 * Time: 09:12
 */

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