<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

$quotationNumber = $_POST['quotationNumber'];
$type2 = $_POST['type'];
$type = "F";

echo $quotationNumber;

$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$descriptionmanager = new DescriptionManager($bdd);
$costmanager = new CostManager($bdd);
$folder = $foldermanager->get($_POST["folder"]);
$folderId = $folder->getIdFolder();
$companyId = $folder->getCompanyId();
$label = $folder->getLabel();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber,$type,$companyId);
print_r($quotationGet);
$customerId = $_POST["customer-select"];
$contactId = $_POST["contact-select"];

echo " passe 1 ";

$date = date("Y-m-d", strtotime(str_replace('/','-',$_POST['date'])));

$status = "En cours";


echo " passe 2 ";

$data = array(
    'idQuotation' => $quotationGet->getIdQuotation(),
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
echo " passe 3 ";
print_r($data);
$quotation = new Quotation($data);
$test = $quotationmanager->update($quotation);

echo " passe 4 ";
$descriptions= array();

$i=1;
while(($postDescription = current($_POST["descriptionFacture"])) !== FALSE ){

    $j = key($_POST["descriptionFacture"]);
    echo " ".key($_POST["descriptionFacture"])." ";
    if(strlen(trim($postDescription))>0){
        echo " passe 4-".$j;
        if(empty($_POST["remiseFacture"][$j])){
            $remise = 0;
        }else{
            $remise = $_POST["remiseFacture"][$j];
        }
        if(empty($_POST["quantiteFacture"][$j])){
            $qt = 1;
        }else{
            $qt = $_POST["quantiteFacture"][$j];
        }
        $price = $_POST["prixFacture"][$j];
        $tax = $_POST["taxeFacture"][$j];
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
    next($_POST["descriptionFacture"]);
}
echo " passe 5 ";
$test2 = $descriptionmanager->update($descriptions,$quotationNumber,$type,$type,$companyId);

echo "modif insérée";

if(empty(current($_POST["descriptionCout"]))){
    $testRecup = $costmanager->getByQuotationNumber($quotationNumber, $type,$companyId);
    //En cas de suppression de coût sur un devis.
    if($testRecup == NULL)
    {
        $test3 = 1;
    }
    else{
        $test3 = $costmanager->deleteByQuotationNumber($quotationNumber, $type,$companyId);
    }
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
        }else{
            $costmanager->delete($_POST["idCout"][$j]);
        }
        $i++;
        next($_POST["descriptionCout"]);
    }
    $test3 = $costmanager->update($descriptionsCout,$quotationNumber, $type,$companyId);
}



if(is_null($test) || is_null($test2) || is_null($test3))
{
   header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{

    //Ajout d'un objet logs pour tracer l'action sur le facture
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "facture",
        'action' => "update",
        'id' => $quotationNumber,
        'date' => $date
    );

    print_r($arraylogs);

    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);
  header('Location: '.URLHOST.$_COOKIE['company']."/facture/afficher/".$type2."/".$quotationNumber."/success");
}
?>