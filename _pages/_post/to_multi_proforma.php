<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

echo "Multi proforma : ";
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
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation,'D',$companyId);

$date = $_POST['date'];

$today = date("Y-m-d");

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'status' => 'En cours',
    'label' => $label,
    'date' => $date,
    'validatedDate' => $today,
    'type' => 'P'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeType($quotation);
}
if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorProforma');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/proforma/afficher/cours/successProforma');
}
?>