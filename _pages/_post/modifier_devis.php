<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

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
    'comment' => $comment,
    'folderId' => $folderId,
    'companyId' => $companyId,
    'customerId' => $customerId,
    'contactId' => $contactId
);

$quotation = new Quotation($data);
$quotationmanager = new QuotationManager($bdd);

$test = $quotationmanager->update($quotation);

$descriptions= array();

//print_r($_POST["description"]);
$i=1;
foreach($_POST["description"] as $postDescription){
    echo key($_POST["description"]);

    if(strlen(trim($postDescription))>0){
        if(empty($_POST["remise"][$i])){
            $remise = 0;
        }else{
            $remise = $_POST["remise"][$i];
        }
        if(empty($_POST["quantite"][$i])){
                $qt = 1;
        }else{
            $qt = $_POST["quantite"][$i];
        }
        $price = $_POST["prix"][$i];
        $tax = $_POST["taxe"][$i];
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
}
//echo "count : ".count($descriptions);
//print_r($descriptions);

//$test = $descriptionmanager->update($descriptions,$idQuotation);
/*if(is_null($test))
{
   header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{
  header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/".$type2."/".$idQuotation."/success");
}
*/
?>