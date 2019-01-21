<?php

	session_start();
	$path = "../";

	include_once($path.'classes/class_db.php');
    include_once($path.'classes/class_features.php');
    include_once($path . 'classes/class_customers.php');
    include_once($path.'classes/class_customersmanager.php');

	$bdd = new DB();
	$bdd->connexion();
	$array = array();
	$customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);
    $customermanager = $customermanager->getList();

    foreach ($customermanager as $customer)
	{
			echo "id: " .$customer->getIdCustomer(). " - Nom de la société : " .$customer->getName(). " " .$customer->getPhysicalAddress(). "<br />";
			echo "Adresse de facturation :" .$customer->getInvoiceAddress()." le client est est actif : ".$customer->getisActive()."<br>";
	}

?>
