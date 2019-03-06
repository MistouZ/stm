<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

echo "Résultats : ";
/*print_r($_POST['description']);
print_r($_POST['quantite']);
print_r($_POST["remise"]);
print_r($_POST["prix"]);*/

//print_r($_POST);
//echo $_POST['description'][0];

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


/*$quotationNumber = $quotationmanager->add($quotation);

if($quotationNumber != NULL){
    echo "j'ai réussi à insérer mon devis ".$quotationNumber;
}
else{
    echo "erreur j'ai rien créé";
}*/

$descriptions= array();
for($i=0;$i<count($_POST["description"]);$i++)
{
    $dataDescription= array(
        'description' => $_POST["description"][$i],
        'quantity' => $_POST["quantite"][$i],
        'discount' => $_POST["remise"][$i],
        'price' => $_POST["prix"][$i],
        'tax' => $_POST["taxe"][$i]
    );
    $description = new Description($dataDescription);
    $descriptions[$i] = $description;
}

print_r($descriptions);

?>