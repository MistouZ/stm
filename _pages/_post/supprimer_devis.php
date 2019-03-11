<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idQuotation = $_GET["idQuotation"];

$array = array();
$quotation = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$test = $quotationmanager->delete($idQuotation);

$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$test = $descriptionmanager->delete($idQuotation);

if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER']."/errorsuppr");
}else{
    header('Location: '.$_SERVER['HTTP_REFERER']."/successsuppr");
}

?>
