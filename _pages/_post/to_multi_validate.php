<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

echo "Multi Validation Facture : ";
print_r($_POST['selection']);

foreach($_POST['selection'] as $postSelection){
$idQuotation = $postSelection;

$today = date("Y-m-d");

$array = array();
$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation);

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'status' => 'Validated',
    'validatedDate' => $today
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeStatus($quotation);
}
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorFacture');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/facture/afficher/valides/successFacture');
}
?>