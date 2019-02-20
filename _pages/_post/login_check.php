<?php
include("../../_cfg/cfg.php");
session_start();

    $array = array();
	$user = new Users($array);
	$userManager = new UsersManager($bdd);


if(isset($_POST['valider'])){

		$user = $userManager->connectUser($_POST['username'],$_POST['password']);
        setcookie('nom', $user->getName(), time() + 365*24*3600, null, null, false, true);
        setcookie('prenom', $user->getFirstName(), time() + 365*24*3600, null, null, false, true);
        
		/*$_SESSION["username"] = $user->getUsername();
		$_SESSION["name"] = $user->getName();
		$_SESSION["firstname"] = $user->getFirstName();
		$_SESSION["credentials"] = $user->getCredential();
        $_SESSION["connected"] = true;*/
	}

if(empty($_COOKIE['nom'])){
        header('Location: '.URLHOST.'connexion/false');    
}else{
        header('Location: '.URLHOST);
        setcookie('connected', $donnees['login'], time() + 365*24*3600, null, null, false, true);
}

?>
