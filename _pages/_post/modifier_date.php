<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");

$idQuotation = $_POST['quotationNumber'];
$dateTab = explode("/",$_POST['date']);
$type2 = $_POST['type'];

$array = array();
$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation);

$year = $dateTab[2];
$month = $dateTab[1];
$day = $dateTab[0];

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'year' => $year,
    'month' => $month,
    'day' => $day,
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeDate($quotation);
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorDate');
}else{
    header('Location: '.$_SERVER['HTTP_REFERER'].'/successDate');
}

?>