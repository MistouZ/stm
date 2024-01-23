<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

$quotationNumber = $_POST['quotationNumber'];
$type2 = $_POST['type'];

echo $quotationNumber;

if($type2 == "partiels")
{
    $type = "S";
}
else
{
    $type = "D";
}

$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$descriptionmanager = new DescriptionManager($bdd);
$costmanager = new CostManager($bdd);
$folder = $foldermanager->get($_POST["folder"]);
$folderId = $folder->getIdFolder();
$companyId = $folder->getCompanyId();
$customerId = $folder->getCustomerId();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber,$type, $companyId);
/*$customerId = $quotationGet->getCustomerId();
$contactId = $quotationGet->getContactId();*/

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


$date = date("Y-m-d", strtotime(str_replace('/','-',$_POST['date'])));

$status = "En cours";

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
print_r($data);
$quotation = new Quotation($data);
$test = $quotationmanager->update($quotation);

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


if($type2 == "partiels")
{
    $test2 = $descriptionmanager->update($descriptions,$quotationNumber,$type,"S",$companyId);
}
else
{
    $test2 = $descriptionmanager->update($descriptions,$quotationNumber,$type,"D",$companyId);
}


echo "modif insérée";

if(empty(current($_POST["descriptionOption"]))){
    $test3 = 1;
}
else{
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
    
    if($type2 == "partiels")
    {
        $test3 = $descriptionmanager->update($descriptionsOption,$quotationNumberOption,$type,"S",$companyId);
    }
    else
    {
        $test3 = $descriptionmanager->update($descriptionsOption,$quotationNumberOption,$type,"D",$companyId);
    }
    
}

if(empty(current($_POST["descriptionCout"]))){
    $testRecup = $costmanager->getByQuotationNumber($quotationNumber, $type,$companyId);
    //En cas de suppression de coût sur un devis.
    if($testRecup == NULL)
    {
        $test4 = 1;
    }
    else{
        $test4 = $costmanager->deleteByQuotationNumber($quotationNumber, $type,$companyId);
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
    $test4 = $costmanager->update($descriptionsCout,$quotationNumber, $type,$companyId);
}


if(is_null($test) || is_null($test2) || is_null($test3) || is_null($test4))
{
   header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{

    //Ajout d'un objet logs pour tracer l'action sur le devis
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "quotation",
        'action' => "update",
        'id' => $quotationNumber,
        'date' => $date
    );

    print_r($arraylogs);

    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);
  header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/".$type2."/".$quotationNumber."/success");
}
?>