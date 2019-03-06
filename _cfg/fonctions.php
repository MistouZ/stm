<?php
function __autoload($className) { 
      if (file_exists('./classes/class_'.strtolower($className) . '.php')) { 
          require_once './classes/class_'.strtolower($className) . '.php';
      }else{
        echo 'classes/class_'.$className . '.php - Not Found';
      }
}


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
    
    foreach($taxes as $taxe){
        $tabTaxe = array('name'=>$taxe->getName(), 'value'=>$taxe->getValue());
    }
    $taxes = json_encode($tabTaxe);
    
    $tabReponse = array('contact'=>$contact->getFirstname().' '.$contact->getName(),'customer'=>$customer->getName(),'company'=>$company->getName(),'seller'=>$user->getName()." ".$user->getFirstName(),'taxes'=>$taxes);
    /*$tabReponse->contact = $contact->getFirstname().' '.$contact->getName();
    $tabReponse->customer = $customer->getName();
    $tabReponse->company = $company->getName();
    $tabReponse->seller = $user->getName()." ".$user->getFirstName();*/
    
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


?>