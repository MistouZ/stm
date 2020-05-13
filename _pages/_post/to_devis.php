<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");

$idQuotation = $_POST['quotationNumber'];
$type2 = $_POST['type'];

$array = array();
$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation);

$date = $_POST['date'];

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'status' => 'En cours',
    'label' => $label,
    'date' => $date,
    'type' => 'D'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeType($quotation);
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorDevis');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/devis/afficher/'.$type2.'/'.$idQuotation.'/successDevis');
}

?>