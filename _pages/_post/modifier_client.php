<?php
include("../../_cfg/cfg.php");
    

if(isset($_POST['valider'])){
		$name=$_POST['name'];
		$physical_address=$_POST['physical_address'];
        $customerId=$_POST['customerId'];
    if($_POST["invoice_address"] == NULL)
    {
        $invoice_address=$_POST['physical_address'];
    }
    else{
      $invoice_address=$_POST['invoice_address'];
    }
    if(isset($_POST["is_supplier"]))
    {
      $supplier = 1;
    }
    else{
      $supplier = 0;
    }

    $is_active =1;

    $array = array(
        'idcustomer' => $customerId,
        'name' => $name,
        'physicalAddress' => $physical_address,
        'invoiceAddress' => $invoice_address,
        'isActive' => $is_active
    );
        
    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);
    $test = $customermanager->update($customer, $_POST["case"], $_POST["account"],$_POST["subaccount"], $_POST["taxes"]);

    if($supplier == 1)
    {
      $supplier = new Suppliers($array);
      $suppliermanager = new SuppliersManager($bdd);
      $suppliermanager->update($supplier,$_POST["case"]);
    }

}
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/errormodif");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/".$customerId."/successmodif");
}

?>
