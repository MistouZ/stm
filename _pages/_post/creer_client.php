<?php
include("../../_cfg/cfg.php");
    

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

    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);
    $customermanager->add($customer, $_POST["case"]);
    echo "New customer created successfully </br/>";

    if($provider == 1)
    {
      $supplier = new Suppliers($array);
      $suppliermanager = new SuppliersManager($bdd);
      //$suppliermanager->add($supplier,$_POST["case"]);
      echo "New provider created successfully <br />";
    }
}

?>

<a href="<?php echo URLHOST."client/afficher" ?>">Revenir à la liste des clients</a>
