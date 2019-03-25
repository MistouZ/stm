<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");

$quotationNumber = $_POST['quotationNumber'];
$dateTab = explode("/",$_POST['date']);
$type2 = $_POST['type'];
$percent = $_POST["shattered_percent"];


$array = array();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanagerNumber->getByQuotationNumber($quotationNumber);


$year = $dateTab[2];
$month = $dateTab[1];
$day = $dateTab[0];

if($_POST["shattered"] == "full" || $percent = 100)
{
    $data = array(
        'idQuotation' => $quotationGet->getIdQuotation(),
        'status' => 'En cours',
        'label' => $label,
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'type' => 'P'
    );

    $quotation = new Quotation($data);

    $test = $quotationmanager->changeType($quotation);
}
elseif ($_POST["shattered"] == "partial" && $percent < 100)
{
    $descriptionmanager = new DescriptionManager($bdd);
    $description = new Description($array);

    $folderId = $quotationGet->getFolderId();
    $companyId = $quotationGet->getCompanyId();
    $customerId = $quotationGet->getCustomerId();
    $contactId = $quotationGet->getContactId();
    $comment = $quotationGet->getComment();
    $label = $quotationGet->getLabel();

    $year = date("Y");
    $month = date("m");
    $day = date("d");
    $status = "En cours";
    $type = "S"; // shattered quotation

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
    $newquotationNumber = $quotationmanager->add($duplicate);
    $getDescription = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());

    $i = 0;
    $descriptions= array();
    foreach ($getDescription as $description)
    {
        $description->setQuotationNumber($newquotationNumber);
        $descriptions[$i] = $description;
        $i++;
    }
    // Duplication des descriptions pour garder l'original sur le reste du devis partiel
    $test2 = $descriptionmanager->add($descriptions,$newquotationNumber);
    $rest = 100 - $percent;


    /*$value = getPercentOfNumber($description->getPrice(),$shattered);
    $description->setPrice(round($value));*/

}
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorProforma');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/proforma/afficher/'.$type2.'/'.$quotationNumber.'/successProforma');
}

?>