<?php

/**
 * @author Amaury
 * @copyright 2019
 */

include("../../_cfg/cfg.php");


$array = array();
$quotationmanager = new QuotationManager($bdd);
$description = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$cost = new Cost($array);
$costmanager = new CostManager($bdd);

//récupération des données du devis initial à dupliquer
$folderId = $quotation->getFolderId();
$companyId = $quotation->getCompanyId();
$customerId = $quotation->getCustomerId();
$contactId = $quotation->getContactId();
$comment = $quotation->getComment();
$label = $quotation->getLabel();
$quotation = $quotationmanager->getByQuotationNumber($_GET["quotationNumber"], 'D', $companyId);

$arraycounter = array();
$counter = new Counter($arraycounter);
$countermanager = new CounterManager($bdd);
$counter = $countermanager->getCount($companyId);

$counterQuotation = $counter->getQuotation();

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

$duplicate = new Quotation($data);
$quotationNumber = $quotationmanager->add($duplicate);

if($quotationNumber != NULL){
    echo "j'ai réussi à insérer mon devis ".$quotationNumber;
}
else{
    echo "erreur j'ai rien créé";
}

//récupération des descriptions du devis en cours
$getDescription = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),"D", $companyId);

$i = 0;
$descriptions= array();
foreach ($getDescription as $description)
{
    $description->setQuotationNumber($quotationNumber);
    $descriptions[$i] = $description;
    $i++;
}

$test = $descriptionmanager->add($descriptions,$quotationNumber,"D",$companyId);

//récupération des couts associés au devis

$getCost = $costmanager->getByQuotationNumber($quotation->getQuotationNumber(), 'D', $companyId);

$j = 0;
$costs= array();
foreach ($getCost as $cost)
{
    $cost->setQuotationNumber($quotationNumber);
    $costs[$j] = $cost;
    $j++;
}
$test2 = $costmanager->add($costs,$quotationNumber);

if(is_null($test) || is_null($test2))
{
    header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{

    //Ajout d'un objet logs pour tracer l'action de création du devis
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "quotation",
        'action' => "duplication",
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
    header('Location: '.URLHOST.$_COOKIE['company']."/devis/afficher/cours/".$quotationNumber);
}

?>