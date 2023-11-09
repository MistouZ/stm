<?php

spl_autoload_register(function($className){
    if (file_exists('./classes/class_'.strtolower($className) . '.php')) {
        require_once './classes/class_'.strtolower($className) . '.php';
    }else{
        echo 'classes/class_'.$className . '.php - Not Found';
    }
});

function getContactFormFolder($idFolder){

    $bdd = new DB();
    $bdd->connexion();
    
    $array = array();
    $company = new Company($array);
    $companymanager = new CompaniesManager($bdd);

    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    
    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);   
    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);
    $idFolder = json_decode($_POST['idFolder']);
    $funct = $_POST['functionCalled'];

    $folder = $foldermanager->get($idFolder);
    
    $arrayContact = array();
    $contacts = new Contact($arrayContact);
    $contactmanager = new ContactManager($bdd);
    
    $taxes = new Tax($array);
    $taxesmanager = new TaxManager($bdd);
    
    $customer = $customermanager->getByID($folder->getCustomerId());
    $contact = $contactmanager->getById($folder->getContactId());
    $company = $companymanager->getById($folder->getCompanyId());
    $user = $usermanager->get($folder->getSeller());
    $taxes = $taxesmanager->getListByCustomer($folder->getCustomerId());
    
    $tabTaxe = array();
    foreach($taxes as $taxe){
        array_push($tabTaxe,array('nom'=>$taxe->getName(),'valeur'=>$taxe->getValue()));
    }
    
    $tabReponse = array('contact'=>$contact->getFirstname().' '.$contact->getName(),'customer'=>$customer->getName(),'company'=>$company->getName(),'seller'=>$user->getName()." ".$user->getFirstName(),'taxes'=>$tabTaxe,'label'=>$folder->getLabel());
    
    $reponse = json_encode($tabReponse);
    echo $reponse;
}

if(isset($_POST['functionCalled']) && !empty($_POST['functionCalled'])) {
    $action = $_POST['functionCalled'];
    $idFolder = json_decode($_POST['idFolder']);
    switch($action){
        case 'getContactFormFolder' : 
            getContactFormFolder($idFolder);
            break;
    }

}

function calculMontantTotalTTC(Description $description, $montant){
    $montantLigne = $description->getQuantity()*$description->getPrice();
    $remise = $montantLigne*($description->getDiscount()/100);
    $montantLigne = $montantLigne-$remise;
    $taxe = $montantLigne*$description->getTax();
    $montantLigne = $montantLigne+$taxe;
    $montant = $montant+$montantLigne;
    
    return $montant;
}

function calculMontantTotalHT(Description $description, $montant){
    $montantLigne = $description->getQuantity()*$description->getPrice();
    $remise = $montantLigne*($description->getDiscount()/100);
    $montantLigne = $montantLigne-$remise;
    $montant = $montant+$montantLigne;
    
    return $montant;
}

function calculCoutTotal(Cost $cost, $cout){
    $coutLigne = $cost->getValue();
    $cout = $cout+$coutLigne;

    return $cout;
}

function calculMarge($TotalMontant, $TotalMarge)
{
    $marge = ($TotalMarge/$TotalMontant)*100;
    return $marge;
}

/**
 * Summary of getPercentOfNumber
 * @param mixed $number
 * @param mixed $percent
 * @return float
 */
function getPercentOfNumber($number, $percent){
    return ($percent / 100) * $number;
}


?>