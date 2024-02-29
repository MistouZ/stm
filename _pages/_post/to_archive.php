<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Nicolas
 * @copyright 2019
 */
 
include("../../_cfg/cfg.php");

$idQuotation = $_GET['quotationNumber'];

echo $idQuotation;

$today = date("Y-m-d");

$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companyId = $_GET["compId"];
/*$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();*/

$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation,'D',$companyId);

$data = array(
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'quotationNumber' => $idQuotation,
    'status' => 'En cours',
    'label' => $quotationNumber->getLabel(),
    'date' => $date,
    'validatedDate' => $today,
    'type' => 'AR'
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->changeType($quotation);
$test2 = $descriptionmanager->update($descriptions,$test,$currentType,"D",$companyId);
$test3 = $costmanager->UpdateCostType($test,$quotationNumber,"D",$companyId);

if(is_null($test) || is_null($test2) || is_null($test3)){
    header('Location: '.$_SERVER['HTTP_REFERER'].'/errorArchive');
}else{

    //Ajout d'un objet logs pour tracer l'action de passage en devis de la facture
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "quotation",
        'action' => "to_archive",
        'id' => $quotationNumber,
        'date' => $date
    );

    //print_r($arraylogs);

    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);
    header('Location: '.URLHOST.$_COOKIE['company'].'/devis/afficher/archives/'.$idQuotation.'/successArchive');
}
?>