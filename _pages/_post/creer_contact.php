<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 20/02/2019
 * Time: 13:38
 */

include("../../_cfg/cfg.php");


if(isset($_POST['valider'])){
    $name=$_POST['name'];
    $firstname=$_POST['firstname'];
    $emailAddress = $_POST['emailAddress'];
    $phoneNumber = $_POST['phoneNumber'];

    $is_active =1;

    $array = array(
        'name' => $name,
        'firstname' => $firstname,
        'emailAddress' => $emailAddress,
        'phoneNumber' => $phoneNumber,
        'isActive' => $is_active
    );

    $contact = new Contact($array);
    $contactmanager = new ContactManager($bdd);
    $contactmanager->add($contact, $_POST["case"]);
    echo "New customer created successfully </br/>";

    if($supplier == 1)
    {
        $supplier = new Suppliers($array);
        $suppliermanager = new SuppliersManager($bdd);
        $suppliermanager->add($supplier,$_POST["case"]);
        echo "New provider created successfully <br />";
    }

}