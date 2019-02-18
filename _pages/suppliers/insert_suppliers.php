<?php
    session_start();
    $path = "../";

    include_once($path.'classes/class_db.php');
    include_once($path.'classes/class_features.php');
    include_once($path . 'classes/class_suppliers.php');
    include_once($path.'classes/class_suppliersmanager.php');
    include_once($path . 'classes/class_suppliers.php');
    include_once($path.'classes/class_suppliersmanager.php');



$bdd = new DB();
    $bdd->connexion();

if(isset($_POST['valider'])){
		$name=$_POST['name'];
		$physical_address=$_POST['physical_address'];
    if($_POST["invoice_address"] == NULL)
    {
        $invoice_address=$_POST['physical_address'];
    }
    else{
      $invoice_address=$_POST['invoice_address'];
    }
    if(isset($_POST["is_supplier"]))
    {
      $provider = 1;
    }
    else{
      $provider = 0;
    }

    $is_active =1;

    $array = array(
        'name' => $name,
        'physicalAddress' => $physical_address,
        'invoiceAddress' => $invoice_address,
        'isActive' => $is_active
    );

    $supplier = new Suppliers($array);
    $suppliermanager = new SuppliersManager($bdd);
    $suppliermanager->add($supplier, $_POST["case"]);
    echo "New supplier created successfully </br/>";

    if($provider == 1)
    {
      $supplier = new Suppliers($array);
      $suppliermanager = new SuppliersManager($bdd);
      $suppliermanager->add($supplier,$_POST["case"]);
      echo "New provider created successfully <br />";
    }
}



?>

<a href="saisie_suppliers.php"> revenir à la création de clients / fournisseur </a>
