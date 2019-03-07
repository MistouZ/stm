<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

echo "Résultats : ";

$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$descriptionmanager = new DescriptionManager($bdd);
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


$year = date("Y");
$month = date("m");
$day = date("d");
$status = "En cours";
$type = "D";

$data = array(
    'status' => $status,
    'label' => $label,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'type' => $type,
    'folderId' => $folderId,
    'companyId' => $companyId,
    'customerId' => $customerId,
    'contactId' => $contactId
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);


$quotationNumber = $quotationmanager->add($quotation);

if($quotationNumber != NULL){
    echo "j'ai réussi à insérer mon devis ".$quotationNumber;
}
else{
    echo "erreur j'ai rien créé";
}

$descriptions= array();
//print_r($_POST);
for($i=0;$i<count($_POST["description"]);$i++)
{
    if(!isset($_POST["remise"][$i])){
        $remise = 0;
    }else{
        $remise = $_POST["remise"][$i];
    }
    $dataDescription= array(
        'description' => $_POST["description"][$i],
        'quantity' => $_POST["quantite"][$i],
        'discount' => $remise,
        'price' => $_POST["prix"][$i],
        'tax' => $_POST["taxe"][$i]
    );

    $description = new Description($dataDescription);
    $descriptions[$i] = $description;
}

$test = $descriptionmanager->add($descriptions,$quotationNumber);
if(is_null($test))
{
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
else{
    header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/".$quotationNumber);
}

?>