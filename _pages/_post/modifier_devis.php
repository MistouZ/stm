<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

$quotationNumber = $_POST['quotationNumber'];
$type2 = $_POST['type'];


$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$descriptionmanager = new DescriptionManager($bdd);
$folder = $foldermanager->get($_POST["folder"]);
$folderId = $folder->getIdFolder();
$companyId = $folder->getCompanyId();
$customerId = $folder->getCustomerId();
$contactId = $folder->getContactId();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber);

if(empty($_POST["label"]))
{
    $label = $folder->getLabel();
}
else{
    $label = $_POST["label"];
}

if(!empty($_POST['comment'])){
    $comment = $_POST['comment'];
}else{
    $comment = "";
}

$dateTab = explode("/",$_POST['date']);

$year = $dateTab[2];
$month = $dateTab[1];
$day = $dateTab[0];

$status = "En cours";
$type = "D";

$data = array(
    'idQuotation' => $quotationGet->getIdQuotation(),
    'status' => $status,
    'label' => $label,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'type' => $type,
    'comment' => $comment,
    'folderId' => $folderId,
    'companyId' => $companyId,
    'customerId' => $customerId,
    'contactId' => $contactId
);

$quotation = new Quotation($data);
$test = $quotationmanager->update($quotation);

$descriptions= array();

$i=1;
while ( ($postDescription = current($_POST["description"])) !== FALSE ) {

    $j = key($_POST["description"]);
    if(strlen(trim($postDescription))>0){
        if(empty($_POST["remise"][$j])){
            $remise = 0;
        }else{
            $remise = $_POST["remise"][$j];
        }
        if(empty($_POST["quantite"][$j])){
            $qt = 1;
        }else{
            $qt = $_POST["quantite"][$j];
        }
        $price = $_POST["prix"][$j];
        $tax = $_POST["taxe"][$j];
        $dataDescription= array(
            'description' => $postDescription,
            'quantity' => $qt,
            'discount' => $remise,
            'price' => $price,
            'tax' => $tax
        );

        $description = new Description($dataDescription);
        $descriptions[$i] = $description;
    }
    $i++;
    next($_POST["description"]);
}

$test = $descriptionmanager->update($descriptions,$quotationNumber);


$i=1;
while(($postDescriptionOption = current($_POST["descriptionOption"])) !== FALSE ){

    $j = key($_POST["descriptionOption"]);
    if(strlen(trim($postDescriptionOption))>0){
        if(empty($_POST["remiseOption"][$j])){
            $remise = 0;
        }else{
            $remise = $_POST["remiseOption"][$j];
        }
        if(empty($_POST["quantiteOption"][$j])){
            $qt = 1;
        }else{
            $qt = $_POST["quantiteOption"][$j];
        }
        $price = $_POST["prixOption"][$j];
        $tax = $_POST["taxeOption"][$j];
        $dataDescriptionOption= array(
            'description' => $postDescriptionOption,
            'quantity' => $qt,
            'discount' => $remise,
            'price' => $price,
            'tax' => $tax
        );

        $descriptionOption = new Description($dataDescriptionOption);
        $descriptionsOption[$i] = $descriptionOption;
    }
    $i++;
    next($_POST["descriptionOption"]);
}
$quotationNumberOption = $quotationNumber.'_option';
$test2 = $descriptionmanager->add($descriptionsOption,$quotationNumberOption);
echo "test2 ".$test2;

$i=1;
while(($postDescriptionCout = current($_POST["descriptionCout"])) !== FALSE ){

    $j = key($_POST["descriptionCout"]);
    if(strlen(trim($postDescriptionCout))>0){

        $price = $_POST["prixCout"][$j];
        $supplier = $_POST["fournisseur"][$j];
        $dataDescriptionCout= array(
            'description' => $postDescriptionCout,
            'value' => $price,
            'folderId' => $folderId,
            'supplierId' => $supplier
        );

        $descriptionCout = new Cost($dataDescriptionCout);
        $descriptionsCout[$i] = $descriptionCout;
    }
    $i++;
    next($_POST["descriptionCout"]);
}

$test3 = $costmanager->update($descriptionsCout,$quotationNumber);
echo "test3 ".$test3;
/*

if(is_null($test) || is_null($test2) || is_null($test3))
{
   header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{
  header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/".$type2."/".$idQuotation."/success");
}*/
?>