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
        'phoneNumber' => $phoneNumber
    );

    print_r($array);
    $contact = new Contact($array);
    $contactmanager = new ContactManager($bdd);
    $contactmanager->update($contact);
}

header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/update");

?>
