<?php
function __autoload($className) { 
      if (file_exists('./classes/class_'.strtolower($className) . '.php')) { 
          require_once './classes/class_'.strtolower($className) . '.php';
      }else{
        echo 'classes/class_'.$className . '.php - Not Found';
      }
}


function getContactFormFolder($idFolder){

    $array = array();
    $company = new Company($array);
    $companymanager = new CompaniesManager($bdd);

    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    
    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);
        
    $folder = new Folder($array);
    echo 'OK folder';
    $foldermanager = new FoldersManager($bdd);
    echo'OK manager';
    $folder = $foldermanager->get($idFolder);
    if(is_null($folder)){
        echo "vide";
    }else{
        var_dump($folder);
    }
    
    $arrayContact = array();
    $contacts = new Contact($arrayContact);
    $contactmanager = new ContactManager($bdd);
    
    $customer = $customermanager->getByID($folder->getCustomerId());
    $contact = $contactmanager->getById($folder->getCustomerId());
    $company = $companymanager->getById($folder->getCompanyId());
    $user = $usermanager->get($folder->getSeller());
    
    $tabReponse->contact = $contact->getFirstname().' '.$contact->getName();
    $tabReponse->customer = $customer->getName();
    $tabReponse->company = $company->getName();
    $tabReponse->seller = $user->getName()." ".$user->getFirstName();;
    
    $reponse = json_encode($tabReponse);
    return $reponse;
}

if(isset($_GET['functionCalled']) && !empty($_GET['functionCalled'])) {
    $action = $_GET['functionCalled'];
    $idFolder = $_GET['idFolder'];
    switch($action){
        case 'getContactFormFolder' : 
            echo "TEST";
            $reponse = getContactFormFolder($idFolder);
            print_r($reponse);
            return $reponse;
            break;
    }

}


?>