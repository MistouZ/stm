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
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companyNameData = $_POST["company"];
echo "companyNameData : ".$companyNameData;
$company = $companymanager->getByNameData($companyNameData);
echo "companyId : ".$companyId;
$companyId = $company->getIdcompany();

echo " Test ".$postSelection." / ";

$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation,'F',$companyId);

echo "j arrive ici";

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