<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");

$idQuotation = $_POST['quotationNumber'];

echo $idQuotation;

$today = date("Y-m-d");

$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companyNameData = $_POST["company"];
$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation,'D',$companyId);

$data = array(
    'idQuotation' => $quotation->getIdQuotation(),
    'quotationNumber' => $idQuotation,
    'status' => 'En cours',
    'label' => $quotation->getLabel(),
    'date' => $date,
    'validatedDate' => $today,
    'type' => 'AR'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeType($quotation);


if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorArchive');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/devis/afficher/archives/'.$idQuotation.'/successArchive');
}

?>