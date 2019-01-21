<?php

	session_start();
	$path = "../";

	include_once($path.'classes/class_db.php');
    include_once($path.'classes/class_features.php');
    include_once($path . 'classes/class_suppliers.php');
    include_once($path.'classes/class_suppliersmanager.php');

	$bdd = new DB();
	$bdd->connexion();
	$array = array();
	$supplier = new Suppliers($array);
    $suppliermanager = new SuppliersManager($bdd);
    $suppliermanager = $suppliermanager->getList();

    foreach ($suppliermanager as $supplier)
	{
			echo "id: " .$supplier->getIdSupplier(). " - Nom de la société : " .$supplier->getName(). " " .$supplier->getPhysicalAddress(). "<br />";
			echo "Adresse de facturation :" .$supplier->getInvoiceAddress()." le fournisseur est est actif : ".$supplier->getisActive()."<br>";
	}

?>
