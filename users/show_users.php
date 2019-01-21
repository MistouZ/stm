<?php

	session_start();
	$path = "../";

	include_once($path.'classes/class_db.php');
	include_once($path.'classes/class_features.php');
	include_once($path.'classes/class_users.php');
	include_once($path.'classes/class_usersmanager.php');

	$bdd = new DB();
	$bdd->connexion();
	$array = array();
	$user = new Users($array);
	$userManager = new UsersManager($bdd);

	$userManager = $userManager->getList();

	foreach ($userManager as $user)
	{
		 echo $user->getUsername()." ".$user->getFirstName()." ".$user->getName()." ".$user->getEmailAddress()." ".$user->getPhoneNumber().' '.$user->getCredential()." ".$user->getIsActive()." ".$user->getIsSeller()." ".$user->getCompanyName()."<br />";
	}

?>
