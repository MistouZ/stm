<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idQuotation = $_GET["idQuotation"];
$quotationNumber = $_GET['quotationNumber'];

$array = array();
$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$cost = new Cost($array);
$costmanager = new CostManager($bdd);
$test = $descriptionmanager->delete($quotationNumber);
$test2 = $costmanager->deleteByQuotationNumber($quotationNumber);

if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER']."/errorsuppr");
}else{
    $quotation = new Quotation($array);
    $quotationmanager = new QuotationManager($bdd);
    echo "id : ".$idQuotation." / Number : ".$quotationNumber;
    $test = $quotationmanager->delete($idQuotation);
    if(is_null($test)){
        header('Location: '.$_SERVER['HTTP_REFERER']."/errorsuppr2");
    }else{
        header('Location: '.$_SERVER['HTTP_REFERER']."/successsuppr");
  }
}

?>
