<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

echo "Résultats : ";

$idQuotation = $_POST['idQuotation'];
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
$quotationNumber = new Quotation($array);
$quotationmanagerNumber = new QuotationManager($bdd);
$quotationNumber = $quotationmanagerNumber->getByQuotationNumber($idQuotation);

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
    'idQuotation' => $quotationNumber->getIdQuotation(),
    'status' => $status,
    'label' => $label,
    'year' => $year,
    'month' => $month,
    'day' => $day,
    'type' => $type,
    'comment' =>$comment,
    'folderId' => $folderId,
    'companyId' => $companyId,
    'customerId' => $customerId,
    'contactId' => $contactId
);
echo "DATA: ";
print_r($data);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

echo " / QUOTATION : ";
print_r($quotation);

$test = $quotationmanager->update($quotation);


$descriptions= array();

for($i=0;$i<count($_POST["description"]);$i++)
{
    if(isset($_POST["remise"][$i])){
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

$test = $descriptionmanager->update($descriptions,$idQuotation);
if(is_null($test))
{
    header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{
    header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/".$type2."/".$idQuotation."/success");
}

?>