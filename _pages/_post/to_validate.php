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
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation,'F',$companyId);

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'status' => 'Validated',
    'validatedDate' => $today
);

$type2 = "valides";

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeStatus($quotation);


if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorFacture');
}else{
    header('Location: '.URLHOST.$_COOKIE['company'].'/facture/afficher/'.$type2.'/'.$idQuotation.'/successFacture');
}

?>