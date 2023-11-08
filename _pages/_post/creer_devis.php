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
$folder = $foldermanager->get($_POST["folder"]);
$folderId = $folder->getIdFolder();
$companyId = $folder->getCompanyId();
$customerId = $folder->getCustomerId();
$contactId = $folder->getContactId();

$arraycounter = array();
$counter = new Counter($arraycounter);
$countermanager = new CounterManager($bdd);
$counter = $countermanager->getCount($companyId);

$counterQuotation = $counter->getQuotation();

echo "counter".$counterQuotation;



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
    'quotationNumber' => $counterQuotation,
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

echo" ------------- TESTTTTTTT ------ ";
print_r($descriptions);

$descriptionmanager = new DescriptionManager($bdd);
$test = $descriptionmanager->add($descriptions,$quotationNumber,$type);

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

    $descriptionmanager2 = new DescriptionManager($bdd);
    $quotationNumberOption = $quotationNumber . '_option';
    $test2 = $descriptionmanager2->add($descriptionsOption, $quotationNumberOption, $type);
}

if(empty(current($_POST["descriptionCout"]))){
    $test3 = 1;
}
else{
    echo "je passe ici".$test3;
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

    $costmanager = new $costmanager($bdd);
    $test3 = $costmanager->add($descriptionsCout,$quotationNumber, $type);
    echo "j'ai réussi 3";
}

echo " ------- Test 1 : ".$test." - Test 2 : ".$test2." - Test 3 : ".$test3;

if(is_null($test) || is_null($test2) || is_null($test3) )
{
    //header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{

    //Ajout d'un objet logs pour tracer l'action de création du devis
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "quotation",
        'action' => "creation",
        'id' => $quotationNumber,
        'date' => $date
    );

    print_r($arraylogs);

    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);

    //incrémentation du nombre de devis créé pour la société
    $counterQuotation = $counterQuotation + 1;
    echo $counterQuotation;
    $counter->setQuotation($counterQuotation);
    print_r($counter);
    $countermanager->updateCounter($counter);



    //header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/cours/".$quotationNumber);
}
?>