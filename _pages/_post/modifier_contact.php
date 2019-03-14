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
        echo "Customer Update".$customerId;
        $contactmanager->update($contact);
        echo "Contact Updated".$customerId;
        header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/update");
    }
    elseif (isset($_POST["supplierId"]))
    {
        $supplierId = $_POST["supplierId"];
        echo "Supplier Update".$supplierId;
        $contactmanager->update($contact);
        echo "Contact Updated".$supplierId;
        header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$supplierId."/udpate");
    }
}


?>
