<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 20/02/2019
 * Time: 13:38
 */

include("../../_cfg/cfg.php");


if(isset($_POST['valider'])){
    $label = $_POST["label"];
    $description = $_POST["description"];
    $seller = $_POST["seller-select"];
    $date = date("Y-m-d");
    $customerId = $_POST["customer-select"];
    $contactId = $_POST["contact-select"];
    $companyId = $_POST["idcompany"];

    $isActive = 1;

    $array = array(
        'label' => $label,
        'date' => $date,
        'isActive' => $isActive,
        'description' => $description,
        'seller' => $seller,
        'companyId' => $companyId,
        'customerId' => $customerId,
        'contactId' => $contactId
    );


    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);
    $test = $foldermanager->add($folder);

if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/error");
}else{

    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "folder",
        'action' => "creation",
        'id' => $test,
        'date' => $date
    );

    print_r($arraylogs);

    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/success");
}
    
}