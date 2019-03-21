<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");


$array = array();
$descriptionmanager = new DescriptionManager($bdd);
$quotationmanager = new QuotationManager($bdd);
$description = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$quotation = $quotationmanager->getByQuotationNumber($_GET["quotationNumber"]);
$folderId = $quotation->getFolderId();
$companyId = $quotation->getCompanyId();
$customerId = $quotation->getCustomerId();
$contactId = $quotation->getContactId();


$year = date("Y");
$month = date("m");
$day = date("d");
$status = "En cours";
$type = "D";

$data = array(
    'status' => $status,
    'label' => $label,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'type' => $type,
    'comment' => $comment,
    'folderId' => $folderId,
    'companyId' => $companyId,
    'customerId' => $customerId,
    'contactId' => $contactId
);

$duplicate = new Quotation($data);
$quotationNumber = $quotationmanager->add($quotation);

if($quotationNumber != NULL){
    echo "j'ai réussi à insérer mon devis ".$quotationNumber;
}
else{
    echo "erreur j'ai rien créé";
}

//récupération des descriptions du devis en cours
$getDescription = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());

$i = 1;
$descriptions= array();
foreach ($getDescription as $description)
{
    $descriptions[$i] = $description;
    $i++;
}

print_r($getDescription);
print_r($descriptions);

//$test = $descriptionmanager->add($descriptions,$quotationNumber);

/*
if(is_null($test) || is_null($test2) || is_null($test3))
{
    header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{
    header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/".$quotationNumber);
}*/

?>