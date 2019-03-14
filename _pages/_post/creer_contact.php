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
    if(!empty($_POST['emailAddress'])){
        $emailAddress = $_POST['emailAddress'];
    }else{
        $emailAddress = "";
    }
    if(!empty($_POST['phoneNumber'])){
        $phoneNumber = $_POST['phoneNumber'];
    }else{
        $phoneNumber = "";
    }
    if(isset($_POST['categorie']) && !empty($_POST['categorie'])){
        $customerId = $_POST["supplierId"];
    }else{
        $customerId = $_POST["customerId"];
    }
    
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
    $contact2 = $contactmanager->getByName($contact->getName(),$contact->getFirstname());

    if($contact2->getIdContact()== 0)
    {
        $contactmanager->addToCustomers($contact, $customerId);
        header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/ajout");
    }
    elseif($contact2->getName() == "Contact" && $contact2->getFirstname() == "Supprimé" )
    {
        $contactmanager->reactivate($contact2);
        $contactmanager->addToCustomers($contact2, $customerId);
        header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/ajout");

    }
    elseif($contact2->getName() != "Contact" && $contact2->getFirstname() != "Supprimé")
    {
        $test = $contactmanager->addToCustomers($contact2, $customerId);
        if(!is_null($test)){
            header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/ajout");
        }
        else {
            header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/existe");
        }

    }
}