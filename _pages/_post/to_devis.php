<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");

$quotationNumber = $_POST['quotationNumber'];
$type2 = $_POST['type'];
$currentType = $_POST['currentType'];

print_r($_POST);

$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companyNameData = $_POST["company"];
$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$quotation = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotation = $quotationmanagerNumber->getByQuotationNumber($quotationNumber,$currentType, $companyId);

$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$descriptions = $descriptionmanager->getByQuotationNumber($quotationNumber,$currentType, $companyId);

$costGet = new Cost($array);
$costmanager = new CostManager($bdd);

$date = $_POST['date'];

$data = array(
    'idQuotation' => $quotation->getIdQuotation(),
    'quotationNumber' => $quotation->getQuotationNumber(),
    'status' => 'En cours',
    'date' => $date,
    'type' => 'D'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeType($quotation);

$test2 = $descriptionmanager->update($descriptions,$test,"D",$companyId);
$test3 = $costmanager->UpdateCostType($test,$quotationNumber,"D",$companyId);

/*
if(is_null($test) || is_null($test2) || is_null($test3)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorDevis');
}else{

    //Ajout d'un objet logs pour tracer l'action de passage en devis de la facture
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "quotation",
        'action' => "to_devis",
        'id' => $quotationNumber,
        'date' => $date
    );

    print_r($arraylogs);

    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);
    header('Location: '.URLHOST.$_COOKIE['company'].'/devis/afficher/'.$type2.'/'.$quotationNumber.'/successDevis');
}
*/
?>