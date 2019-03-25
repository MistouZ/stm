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

$array = array();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanagerNumber->getByQuotationNumber($quotationNumber);

$year = $dateTab[2];
$month = $dateTab[1];
$day = $dateTab[0];

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'status' => 'En cours',
    'label' => $label,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'type' => 'P'
);

$quotation = new Quotation($data);

$test = $quotationmanager->changeType($quotation);
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorProforma');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/proforma/afficher/'.$type2.'/'.$idQuotation.'/successProforma');
}

?>