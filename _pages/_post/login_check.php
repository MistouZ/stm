<?php
include("../../_cfg/cfg.php");
session_start();

    $array = array();
	$user = new Users($array);
	$userManager = new UsersManager($bdd);


if(isset($_POST['valider'])){

		$user = $userManager->connectUser($_POST['username'],$_POST['password']);
        
        
	}

if($_COOKIE['connected']==false){
        header('Location: '.URLHOST.'connexion/false');    
}else{
        
        header('Location: '.URLHOST);  
}

?>
