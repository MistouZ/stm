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
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companyNameData = $_POST["company"];
$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$quotationGet = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
if($type2 == "partiels")
{
    $quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber,"S",$companyId);
}
else
{
    $quotationGet = $quotationmanager->getByQuotationNumber($quotationNumber,"D",$companyId);
}

$costGet = new Cost($array);
$costmanager = new CostManager($bdd);
//$costGet = $costmanager->getByQuotationNumber($quotationNumber, $currentType);


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

    $test6 = $costmanager->UpdateCostType($quotationNumber,$quotationNumber,"P",$companyId);

    if($type2 == "partiels")
    {
        $descriptionmanager = new DescriptionManager($bdd);
        $shatteredQuotationManager = new ShatteredQuotationManager($bdd);
        $shatteredQuotationInit = new ShatteredQuotation($array);
        $shatteredQuotationInit = $shatteredQuotationManager->getByQuotationNumberChild($quotationNumber);
        $quotationNumberInit = $shatteredQuotationInit->getQuotationNumberInit();
        $quotationInit = $quotationNumberInit."_init";
        $test2 = $descriptionmanager->delete($quotationInit,"D", $companyId);
        $test3 = $shatteredQuotationManager->delete($quotationInit);
        
    }
    else{
        $descriptionmanager = new DescriptionManager($bdd);
        print_r($quotation);
        $test2 = "ok";
    }

    $test3 = $descriptionmanager->changeQuotationType($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
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
        $getDescription = $descriptionmanager->getByQuotationNumber($quotationInit,"S",$companyId);
        $rest = $shatteredQuotationInit->getPercent();
        $rest = $rest - $percent;
        $idShatteredQuotation = $shatteredQuotationInit->getIdShatteredQuotation();
        $test = "ok";

    }
    else
    {
        //fonctionne bien lors du premier partiel
        $quotationNumberInit = $quotationNumber;
        $getDescription = $descriptionmanager->getByQuotationNumber($quotationNumber,"D",$companyId);
        $quotationInit = $quotationGet->getQuotationNumber()."_init";

        echo $quotationInit;
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
        $test = $descriptionmanager->add($descriptions,$quotationInit,"S",$companyId);

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
        $test3 = $descriptionmanager->update($descriptionsReduced,$quotationNumber,"S", "P",$companyId);
    }
    else{
        $test3 = $descriptionmanager->update($descriptionsReduced,$quotationNumber,"D","P", $companyId);
    }
   
    if($rest != 0)
    {   //il reste à facturer alors je stocke les données restantes
        $getDescriptionInit = $descriptionmanager->getByQuotationNumber($quotationInit,"S",$companyId);
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
        $test4a = $descriptionmanager->add($descriptions,$newquotationNumber,"S",$companyId);
        $test4b = "ok";
    }
    else
    {
        //il ne reste rien à facturer alors je supprime les données partielles
        $test4a = $descriptionmanager->delete($quotationInit,"S",$companyId);
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

    echo $companyId;
    $quotation = new Quotation($data);
    $test5 = $quotationmanager->changeType($quotation);$
    $test5b = $descriptionmanager->changeQuotationType($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
    $test6 = "ok";
    
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