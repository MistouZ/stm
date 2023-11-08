<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

echo "Multi avoir : ";
print_r($_POST['selection']);

foreach($_POST['selection'] as $postSelection){
$idQuotation = $postSelection;

$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companyNameData = $_GET["section"];
$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation,'F', $companyId);

$date = $_POST['date'];

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'status' => 'En cours',
    'label' => $label,
    'date' => $date,
    'type' => 'A'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeType($quotation);
}
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorAvoir');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/avoir/afficher/cours/successAvoir');
}
?>