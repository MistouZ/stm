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
    $year = date("Y");
    $month = date("m");
    $day = date("d");
    $customerId = $_POST["customer-select"];
    $contactId = $_POST["contact-select"];
    $companyId = $_POST["idcompany"];

    $status ="O";

    $array = array(
        'label' => $label,
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'status' => $status,
        'description' => $description,
        'seller' => $seller,
        'companyId' => $companyId,
        'customerId' => $customerId,
        'contactId' => $contactId
    );

    print_r($array);
    
    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);
    $foldermanager->add($folder);


    
    //header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId);

}