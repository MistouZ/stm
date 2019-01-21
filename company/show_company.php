<?php

	session_start();
	$path = "../";

	include_once($path.'classes/class_db.php');
	include_once($path.'classes/class_features.php');
	include_once($path.'classes/class_company.php');
	include_once($path.'classes/class_companiesmanager.php');

	$bdd = new DB();
	$bdd->connexion();
	$array = array();
	$company = new Company($array);
	$companiesmanager = new CompaniesManager($bdd);

	$companiesmanager = $companiesmanager->getList();

	foreach ($companiesmanager as $company)
	{
		echo $company->getName()." ".$company->getAddress()." ".'<a href="edit_company.php?idcompany='.$company->getIdcompany().'">Modifier</a>'." ".'<a href="delete_company.php?idcompany='.$company->getIdcompany().'">Supprimer</a>'."<br />";
	}


?>
