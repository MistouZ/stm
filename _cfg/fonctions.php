<?php
function __autoload($className) { 
      if (file_exists('./classes/class_'.strtolower($className) . '.php')) { 
          require_once './classes/class_'.strtolower($className) . '.php';
      }else{
        echo 'classes/class_'.$className . '.php - Not Found';
      }
}


function getContactFormFolder($idFolder){
    /*$bdd = new DB();
    $bdd->connexion();
    
    $array = array();
    $company = new Company($array);
    $companymanager = new CompaniesManager($bdd);

    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    
    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);   
    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);*/
    $tabReponse = array('contact'=>'Folder 1','customer'=>'Manager OK','company'=>$idFolder,'seller'=>'Good Seller !');
    return $tabReponse;
    /*$folder = $foldermanager->get($idFolder);
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
    $user = $usermanager->get($folder->getSeller());*/
    
    //$tabReponse = array('contact'=>$contact->getFirstname().' '.$contact->getName(),'customer'=>$customer->getName(),'company'=>$company->getName(),'seller'=>$user->getName()." ".$user->getFirstName());
    /*$tabReponse->contact = $contact->getFirstname().' '.$contact->getName();
    $tabReponse->customer = $customer->getName();
    $tabReponse->company = $company->getName();
    $tabReponse->seller = $user->getName()." ".$user->getFirstName();*/
    
    /*$reponse = json_encode($tabReponse);
    return $reponse;*/
}

if(isset($_POST['functionCalled']) && !empty($_POST['functionCalled'])) {
    $action = $_POST['functionCalled'];
    $idFolder = $_POST['idFolder'];
    switch($action){
        case 'getContactFormFolder' : 
            getContactFormFolder($idFolder);
            //print_r($reponse);
            //return $reponse;
            break;
    }

}


?>