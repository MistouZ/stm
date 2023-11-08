<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");

$companyNameData = $_GET["section"];
$idQuotation = $_POST['quotationNumber'];
$dateTab = explode("/",$_POST['date']);
$type2 = $_POST['type'];
$currentType = $_POST['currentType'];

$array = array();
$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);

$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation,$currentType, $companyId);

$date = $_POST['date'];

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'date' => $date,
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