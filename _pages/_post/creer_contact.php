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
        $testCat = 'fournisseur';
        $customerId = $_POST["supplierId"];
    }else{
        $testCat = 'client';
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

    print_r($contact2);

    if($contact2->getIdContact()== 0)
    {
        if($testCat == 'client'){
            $contactmanager->addToCustomers($contact, $customerId);
            header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/ajout");
        }else{
            $contactmanager->addToSuppliers($contact, $customerId);
            header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$customerId."/ajout");
        }
    }
    elseif($contact2->getName() == "Contact" && $contact2->getFirstname() == "Supprimé" )
    {
        if($testCat == 'client'){
            $contactmanager->reactivate($contact2);
            $contactmanager->addToCustomers($contact2, $customerId);
            header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/ajout");
        }else{
            $contactmanager->reactivate($contact2);
            $contactmanager->addToSuppliers($contact2, $customerId);
            header('Location: '.URLHOST.$_COOKIE['company']."/fourniseur/afficher/".$customerId."/ajout");
        }

    }
    elseif($contact2->getName() != "Contact" && $contact2->getFirstname() != "Supprimé")
    {
        if($testCat == 'client'){
            $test = $contactmanager->addToCustomers($contact2, $customerId);
            if(!is_null($test)){
                header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/ajout");
            }
            else {
                header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/existe");
            }
        }else{
            $test = $contactmanager->addToSuppliers($contact2, $customerId);
            if(!is_null($test)){
                header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$customerId."/ajout");
            }
            else {
                header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$customerId."/existe");
            }
        }

    }
}