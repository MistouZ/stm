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

if(isset($_POST['functionCalled']) && !empty($_POST['functionCalled'])) {
    $action = $_POST['functionCalled'];
    $idFolder = $_POST['idFolder'];
    switch($action){
        case 'getContactFormFolder' : getContactFormFolder($idFolder);break;
    }

}


?>