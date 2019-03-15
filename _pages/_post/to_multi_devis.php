<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

echo "Multi devis : ";
print_r($_POST['selection']);
$dateTab = explode("/",$_POST['date']);

foreach($_POST['selection'] as $postSelection){
$idQuotation = $postSelection;

$array = array();
$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation);

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
    'type' => 'D'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeType($quotation);
}
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorDevis');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/devis/afficher/cours/successDevis');
}
?>