<?php

function getContactFormFolder($idFolder){
    $company = new Company($array);
    $companymanager = new CompaniesManager($bdd);
    
    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    
    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);
        
    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);
    $folder = $foldermanager->get($idFolder);
    
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