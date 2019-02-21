<?php
include("../../_cfg/cfg.php");
session_start();

    $array = array();
	$user = new Users($array);
	$userManager = new UsersManager($bdd);


if(isset($_POST['valider'])){

		$user = $userManager->connectUser($_POST['username'],$_POST['password']);
        
        $array = array();
        $company = new Company($array);
        $companymanager = new CompaniesManager($bdd);
        $company = $companymanager->getById($user->getDefaultCompany());
        
        unset($_COOKIE['company']);
        setcookie('company', $company->getNameData() , time() + 365*24*3600, '/');
}
$url = URLHOST.$_COOKIE['company'];

echo $url;

/*if($_COOKIE['connected']==false){
        header('Location: '.URLHOST.'connexion/false');    
}else{
        
        header('Location: '.URLHOST.$_COOKIE['company']);  
}*/

?>
