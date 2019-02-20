<?php
include("../../_cfg/cfg.php");

    $array = array();
	$user = new Users($array);
	$userManager = new UsersManager($bdd);


if(isset($_POST['valider'])){

		$user = $userManager->connectUser($_POST['username'],$_POST['password']);
		$_SESSION["username"] = $user->getUsername();
		$_SESSION["name"] = $user->getName();
		$_SESSION["firstname"] = $user->getFirstName();
		$_SESSION["credentials"] = $user->getCredential();
        $_SESSION["connected"] = true;
	}

print_r($user);
/*if(empty($user)){
        header('Location: '.URLHOST.'connexion/false');
}else{
        header('Location: '.URLHOST);
}*/

?>
