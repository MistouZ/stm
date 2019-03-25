<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");
include "../../_cfg/fonctions.php";

$quotationNumber = $_POST['quotationNumber'];
$dateTab = explode("/",$_POST['date']);
$type2 = $_POST['type'];
$percent = $_POST["shattered_percent"];

echo $percent;

$array = array();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber);

$year = $dateTab[2];
$month = $dateTab[1];
$day = $dateTab[0];

if($_POST["shattered"] == "full" || $percent == 100)
{
    $data = array(
        'idQuotation' => $quotationGet->getIdQuotation(),
        'status' => 'En cours',
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'type' => 'P'
    );

    $quotation = new Quotation($data);

    $test = $quotationmanager->changeType($quotation);
    $test2 = "ok";
    $test3 ="ok";
    $test4 = "ok";
}
elseif ($_POST["shattered"] == "partial" && $percent < 100)
{
    $descriptionmanager = new DescriptionManager($bdd);
    $description = new Description($array);

    $shatteredQuotationManager = new ShatteredQuotationManager($bdd);

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
    //$newquotationNumber = $quotationmanager->add($duplicate);
    $getDescription = $descriptionmanager->getByQuotationNumber($quotationGet->getQuotationNumber());
    echo $quotationGet->getQuotationNumber();
    print_r($getDescription);
    $i = 0;
    $descriptions= array();
    foreach ($getDescription as $description)
    {
      //  $description->setQuotationNumber($newquotationNumber);
        $descriptions[$i] = $description;
        $i++;
    }
    // Duplication des descriptions pour garder l'original sur le reste du devis partiel
    //$test = $descriptionmanager->add($descriptions,$newquotationNumber);
    $rest = 100 - $percent;

    $dataShattered = array(
     //   'quotationNumber' => $newquotationNumber,
        'percent' => $rest
    );
    print_r($dataShattered);
    $shatteredQuotation = new ShatteredQuotation($dataShattered);
   // $test2 = $shatteredQuotationManager->add($shatteredQuotation);

    //Copie effectuée sur la description, on a créé l'object devis partiel et on a stocké le pourcentage à facturer

    $j = 0;
    $descriptionsReduced= array();
    $descriptionReduced = new Description($array);
    print_r($getDescription);
    foreach ($getDescription as $descriptionReduced)
    {
        $value = getPercentOfNumber($descriptionReduced->getPrice(),$percent);
        echo $value;
        $descriptionReduced->setPrice(round($value));
        echo $descriptionReduced->getPrice();
        $descriptionsReduced[$j] = $descriptionReduced;
        $j++;
    }
    print_r($descriptionsReduced);
    //$test3 = $descriptionmanager->update($descriptionsReduced,$quotationNumber);

    $data = array(
        'idQuotation' => $quotationGet->getIdQuotation(),
        'status' => 'En cours',
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'type' => 'P'
    );

    $quotation = new Quotation($data);
    //$test4 = $quotationmanager->changeType($quotation);
}
/*
if(is_null($test) || is_null($test2) || is_null($test3) || is_null($test4)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorProforma');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/proforma/afficher/'.$type2.'/'.$quotationNumber.'/successProforma');
}
*/
?>