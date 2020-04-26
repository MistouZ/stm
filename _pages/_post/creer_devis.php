<?php

/**
 * @author Amaury
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

echo "Résultats : ";

$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$descriptionmanager = new DescriptionManager($bdd);
$costmanager = new CostManager($bdd);
$folder = $foldermanager->get($_POST["folder"]);
$folderId = $folder->getIdFolder();
$companyId = $folder->getCompanyId();
$customerId = $folder->getCustomerId();
$contactId = $folder->getContactId();

if(empty($_POST["label"]))
{
    $label = $folder->getLabel();
}
else{
    $label = $_POST["label"];
}

if(empty($_POST['comment'])){
    $comment = "";
}else{
    $comment = $_POST['comment'];
}


$date = date("Y-m-d");
$status = "En cours";
$type = "D";

$data = array(
    'status' => $status,
    'label' => $label,
    'date' => $date,
    'type' => $type,
    'comment' => $comment,
    'folderId' => $folderId,
    'companyId' => $companyId,
    'customerId' => $customerId,
    'contactId' => $contactId
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$quotationNumber = $quotationmanager->add($quotation);
echo "j'ai créé le devis : ".$quotationNumber;


//Ajout des lignes du devis
$descriptions= array();

$i=1;
while(($postDescription = current($_POST["descriptionDevis"])) !== FALSE ){

    $j = key($_POST["descriptionDevis"]);
    if(strlen(trim($postDescription))>0){
        if(empty($_POST["remiseDevis"][$j])){
            $remise = 0;
        }else{
            $remise = $_POST["remiseDevis"][$j];
        }
        if(empty($_POST["quantiteDevis"][$j])){
            $qt = 1;
        }else{
            $qt = $_POST["quantiteDevis"][$j];
        }
        $price = $_POST["prixDevis"][$j];
        $tax = $_POST["taxeDevis"][$j];
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
    next($_POST["descriptionDevis"]);
}

$test = $descriptionmanager->add($descriptions,$quotationNumber);

if(empty(current($_POST["descriptionOption"]))){
    $test2 = 1;
}
else {
    $i = 1;
    while (($postDescriptionOption = current($_POST["descriptionOption"])) !== FALSE) {

        $j = key($_POST["descriptionOption"]);
        if (strlen(trim($postDescriptionOption)) > 0) {
            if (empty($_POST["remiseOption"][$j])) {
                $remise = 0;
            } else {
                $remise = $_POST["remiseOption"][$j];
            }
            if (empty($_POST["quantiteOption"][$j])) {
                $qt = 1;
            } else {
                $qt = $_POST["quantiteOption"][$j];
            }
            $price = $_POST["prixOption"][$j];
            $tax = $_POST["taxeOption"][$j];
            $dataDescriptionOption = array(
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

    $quotationNumberOption = $quotationNumber . '_option';
    $test2 = $descriptionmanager->add($descriptionsOption, $quotationNumberOption);
}

if(empty(current($_POST["descriptionCout"]))){
    $test3 = 1;
}
else{
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


    $test3 = $costmanager->add($descriptionsCout,$quotationNumber);
    echo "j'ai réussi 3";
}


if(is_null($test) || is_null($test2) || is_null($test3))
{
    header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{
    header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/cours/".$quotationNumber);
}
?>