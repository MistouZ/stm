<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

$dateTab = explode("/",$_POST['date']);

$year = $dateTab[2];
$month = $dateTab[1];
$day = $dateTab[0];

$data = array(
    'status' => 'En cours',
    'label' => $label,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'type' => 'P'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->toProforma($quotation);

if(is_null($test))
{
    header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{
    header('Location: '.URLHOST.$_COOKIE['company']."/proforma/afficher/".$quotationNumber);
}

?>