<?php
ini_set('display_errors',1); error_reporting(E_ALL | E_STRICT);
/**
 * @author Amaury
 * @copyright 2023
 */
 
include("../../_cfg/cfg.php");
include "../../_cfg/fonctions.php";

$quotationNumber = $_POST['quotationNumber'];
$type2 = $_POST['type'];
$percent = $_POST["shattered_percent"];

$array = array();
$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber,"D");
$costGet = new Cost($array);
$costmanager = new CostManager($bdd);


$date = $_POST['date'];

$today = date("Y-m-d");

if($_POST["shattered"] == "full" || $percent == 100)
{
    $data = array(
        'idQuotation' => $quotationGet->getIdQuotation(),
        'quotationNumber' => $quotationNumber,
        'status' => 'En cours',
        'date' => $date,
        'validatedDate' => $today,
        'type' => 'P'
    );

    $quotation = new Quotation($data);

    $test = $quotationmanager->changeType($quotation);
    $test6 = $costmanager->UpdateCostType($quotationNumber,"P");

    if($type2 == "partiels")
    {
        $descriptionmanager = new DescriptionManager($bdd);
        $shatteredQuotationManager = new ShatteredQuotationManager($bdd);
        $shatteredQuotationInit = new ShatteredQuotation($array);
        $shatteredQuotationInit = $shatteredQuotationManager->getByQuotationNumberChild($quotationNumber);
        $quotationNumberInit = $shatteredQuotationInit->getQuotationNumberInit();
        $quotationInit = $quotationNumberInit."_init";
        $test2 = $descriptionmanager->delete($quotationInit,"D");
        $test3 = $shatteredQuotationManager->delete($quotationInit);
    }
    else{
        $test2 = $descriptionmanager->changeQuotationType($quotation->getQuotationNumber(),$quotation->getType());
        $test3 = "ok";
    }
    $test4a = "ok";
    $test4b ="ok";
    $test5 = "ok";
}
elseif ($_POST["shattered"] == "partial" && $percent < 100)
{
    $descriptionmanager = new DescriptionManager($bdd);
    $description = new Description($array);

    $shatteredQuotationManager = new ShatteredQuotationManager($bdd);

    $folderId = $quotationGet->getFolderId();
    $companyId = $quotationGet->getCompanyId();
    $customerId = $quotationGet->getCustomerId();
    $contactId = $quotationGet->getContactId();
    $comment = $quotationGet->getComment();
    $label = $quotationGet->getLabel();
    $type3 = $quotationGet->getType();

    //Récupération du nombre de devis pour créer le nouveau QuotationNumber
    $arraycounter = array();
    $counter = new Counter($arraycounter);
    $countermanager = new CounterManager($bdd);
    $counter = $countermanager->getCount($companyId);
    

    $counterQuotation = $counter->getQuotation();
    
    $date = date("Y-m-d");
    $status = "En cours";
    $type = "S"; // shattered quotation

    $data = array(
        'quotationNumber' => $counterQuotation,
        'status' => $status,
        'label' => $label,
        'date' => $date,
        'validatedDate' => $today,
        'type' => $type,
        'comment' => $comment,
        'folderId' => $folderId,
        'companyId' => $companyId,
        'customerId' => $customerId,
        'contactId' => $contactId
    );

    
    $duplicate = new Quotation($data);
    $newquotationNumber = $quotationmanager->add($duplicate);
    //ici j'ai créé mon nouveau devis dans la table pour quotation.
    $counterQuotation = $counterQuotation + 1;
    $counter->setQuotation($counterQuotation);
    $countermanager->updateCounter($counter);
    
    
    if($type3 == "S")
    {   
        //si le devis est déjà partiel, je récupère les données initiales
        $shatteredQuotationInit = new ShatteredQuotation($array);
        $shatteredQuotationInit = $shatteredQuotationManager->getByQuotationNumberChild($quotationNumber);
        $quotationNumberInit = $shatteredQuotationInit->getQuotationNumberInit();
        $quotationNumberChild = $shatteredQuotationInit->getQuotationNumberChild();
        $quotationInit = $quotationNumberInit."_init";
        $getDescription = $descriptionmanager->getByQuotationNumber($quotationInit,"S");
        $rest = $shatteredQuotationInit->getPercent();
        $rest = $rest - $percent;
        $idShatteredQuotation = $shatteredQuotationInit->getIdShatteredQuotation();
        $test = "ok";

    }
    else
    {
        //fonctionne bien lors du premier partiel
        $quotationNumberInit = $quotationNumber;
        $getDescription = $descriptionmanager->getByQuotationNumber($quotationNumber,"D");
        $quotationInit = $quotationGet->getQuotationNumber()."_init";
        $rest = 100 - $percent;
        $i = 0;
        $descriptions= array();
        foreach ($getDescription as $description)
        {
            $description->setQuotationNumber($quotationInit);
            $descriptions[$i] = $description;
            $i++;
        }
        // Duplication des descriptions pour garder l'original
        $test = $descriptionmanager->add($descriptions,$quotationInit,"S");

    }

    echo $newquotationNumber;
    $dataShattered = array(
        'quotationNumberInit' => $quotationNumberInit,
        'quotationNumberChild' => $newquotationNumber,
        'percent' => $rest
    );

    $shatteredQuotation = new ShatteredQuotation($dataShattered);
   
    //si on a un devis partiel, je mets à jour le Child et je conserve le devis initial et je mets à jour l'enfant
    if($type3 == "S")
    {
        $shatteredQuotation->setIdShatteredQuotation($idShatteredQuotation);
        $test2 = $shatteredQuotationManager->update($shatteredQuotation);

    }
    else
    {
        $test2 = $shatteredQuotationManager->add($shatteredQuotation);
    }
    
    

    //Copie effectuée sur la description, on a créé l'object devis partiel et on a stocké le pourcentage restant à facturer
    
    $j = 0;
    $descriptionsReduced= array();
    $descriptionReduced = new Description($array);

    foreach ($getDescription as $descriptionReduced)
    {
        $value = getPercentOfNumber($descriptionReduced->getPrice(),$percent);
        $descriptionReduced->setPrice(round($value));
        $descriptionsReduced[$j] = $descriptionReduced;
        $j++;
    }
    if($type3 == "S"){
        $test3 = $descriptionmanager->update($descriptionsReduced,$quotationNumberChild,"S");
    }
    else{
        $test3 = $descriptionmanager->update($descriptionsReduced,$quotationNumber,"S");
    }
   

    if($rest != 0)
    {   //il reste à facturer alors je stocke les données restantes
        $getDescriptionInit = $descriptionmanager->getByQuotationNumber($quotationInit,"S");
        $descriptionRest = new Description($array);
        $k = 0;
        foreach ($getDescriptionInit as $descriptionRest)
        {
            $value = getPercentOfNumber($descriptionRest->getPrice(),$rest);
            $descriptionRest->setPrice(round($value));
            $descriptionRest->setQuotationNumber($newquotationNumber);
            $descriptions[$k] = $descriptionRest;
            $k++;
        }
        //insertion du reste à payer
        $test4a = $descriptionmanager->add($descriptions,$newquotationNumber,"S");
        $test4b = "ok";
    }
    else
    {
        //il ne reste rien à facturer alors je supprime les données partielles
        $test4a = $descriptionmanager->delete($quotationInit,"S");
        $test4b = $shatteredQuotationManager->delete($quotationInit);
    }



    $data = array(
        'idQuotation' => $quotationGet->getIdQuotation(),
        'quotationNumber' => $quotationNumber,
        'status' => 'En cours',
        'date' => $date,
        'validatedDate' => $today,
        'type' => 'P'
    );
    $quotation = new Quotation($data);
    $test5 = $quotationmanager->changeType($quotation);
    $test5b = $descriptionmanager->changeQuotationType($quotation->getQuotationNumber(),$quotation->getType());
    
}

if(is_null($test) || is_null($test2) || is_null($test3) || is_null($test4a) || is_null($test4b) || is_null($test5) || is_null($test6)){
  header('Location: '.$_SERVER['HTTP_REFERER'].'/errorProforma');
}else{

    //Ajout d'un objet logs pour tracer l'action de passage du devis en proforma
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $quotationGet->getCompanyId(),
        'type' => "quotation",
        'action' => "to_proforma",
        'id' => $quotationNumber,
        'date' => $date
    );

    print_r($arraylogs);

    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);
   header('Location: '.URLHOST.$_COOKIE['company'].'/proforma/afficher/'.$type2.'/'.$quotationNumber.'/successProforma');
}

?>