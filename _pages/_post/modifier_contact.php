<?php
include("../../_cfg/cfg.php");



if(isset($_POST['valider'])){
    $name=$_POST['name'];
    $firstname=$_POST['firstname'];

    if(!empty($_POST['emailAddress']))
    {
        $emailAddress = $_POST['emailAddress'];
    }
    else
    {
        $emailAddress = "";
    }
    if(!empty($_POST['phoneNumber']))
    {
        $phoneNumber = $_POST['phoneNumber'];
    }
    else
    {
        $phoneNumber = "";
    }

    $contactId = $_POST["contactId"];

    $array = array(
        'idContact' => $contactId,
        'name' => $name,
        'firstname' => $firstname,
        'emailAddress' => $emailAddress,
        'phoneNumber' => $phoneNumber,
        'isActive' => 1
    );

    $contact = new Contact($array);
    $contactmanager = new ContactManager($bdd);

    print_r($contact);

    if(isset($_POST["customerId"]))
    {
        $customerId = $_POST["customerId"];
        $test = $contactmanager->update($contact);
        if(!is_null($test))
        {
            header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/update");
        }
        else{
            header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/existe");
        }
    }
    elseif (isset($_POST["supplierId"]))
    {
        $supplierId = $_POST["supplierId"];
        $contactmanager->update($contact);
        if(!is_null($test)) {
            header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$supplierId."/udpate");
        }
        else{
            header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$supplierId."/existe");
        }
    }
}


?>
