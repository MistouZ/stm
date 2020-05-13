<?php
include("../../_cfg/cfg.php");
session_start();

    $array = array();
	$user = new Users($array);
	$userManager = new UsersManager($bdd);


//if(isset($_POST['valider'])){

		$user = $userManager->connectUser($_POST['username'],$_POST['password']);
//}

if($_COOKIE['connected']=="false"){
        header('Location: '.URLHOST.'connexion/false');    
}else{
        $array = array();
        $company = new Company($array);
        $companymanager = new CompaniesManager($bdd);
        $company = $companymanager->getById($user->getDefaultCompany());
        
        setcookie('company', $company->getNameData() , time() + 365*24*3600, '/');

        header('Location: '.URLHOST.$company->getNameData()."/accueil");
}

?>
