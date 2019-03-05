<?php
define('URLHOST','http://dev.bitwin.nc/');

include 'classes/class_db.php';
include 'classes/class_features.php';
include 'classes/class_company.php';
include 'classes/class_companiesmanager.php';
include 'classes/class_customers.php';
include 'classes/class_customersmanager.php';
include 'classes/class_contact.php';
include 'classes/class_contactmanager.php';
include 'classes/class_suppliers.php';
include 'classes/class_suppliersmanager.php';
include 'classes/class_users.php';
include 'classes/class_usersmanager.php';
include 'classes/class_folder.php';
include 'classes/class_foldersmanager.php';
include 'classes/class_tax.php';
include 'classes/class_taxmanager.php';

global $bdd;
$bdd = new DB();
$bdd->connexion();

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra');

/*function getContactFormFolder($idFolder){
    $array = array();
    echo "1 Folder :".$idFolder." / ";
    $company = new Company($array);
    $companymanager = new CompaniesManager($bdd);
    echo "2";
    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    echo "3";
    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);
    echo "4";    
    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);
    $folder = $foldermanager->get($idFolder);
    echo "5";
    $arrayContact = array();
    $contacts = new Contact($arrayContact);
    $contactmanager = new ContactManager($bdd);
    echo "6";
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

}*/

?>