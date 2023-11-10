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
$type = $_GET["type"];
$companyId = $_GET["compId"];

$array = array();
$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$cost = new Cost($array);
$costmanager = new CostManager($bdd);
$test = $descriptionmanager->delete($quotationNumber, $type, $companyId);
$test2 = $costmanager->deleteByQuotationNumber($quotationNumber, $type, $companyId);

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
        //Ajout d'un objet logs pour tracer l'action sur le devis
        $date = date('Y-m-d H:i:s');
        $arraylogs = array(
            'username' => $_COOKIE["username"],
            'company' => $companyId,
            'type' => "quotation",
            'action' => "deleted",
            'id' => $quotationNumber,
            'date' => $date
        );

        print_r($arraylogs);

        $log = new Logs($arraylogs);
        $logsmgmt = new LogsManager($bdd);
        $logsmgmt = $logsmgmt->add($log);
        header('Location: '.$_SERVER['HTTP_REFERER']."/successsuppr".$type);
  }
}

?>
