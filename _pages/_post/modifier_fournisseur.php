<?php
include("../../_cfg/cfg.php");
    

if(isset($_POST['valider'])){
		$name = $_POST['name'];
		$physical_address = $_POST['physical_address'];
        $supplierId = $_POST['supplierId'];
    if($_POST["invoice_address"] == NULL)
    {
        $invoice_address=$_POST['physical_address'];
    }
    else{
      $invoice_address=$_POST['invoice_address'];
    }

    $is_active =1;

    $array = array(
        'idsupplier' => $supplierId,
        'name' => $name,
        'physicalAddress' => $physical_address,
        'invoiceAddress' => $invoice_address,
        'isActive' => $is_active
    );
        
    $supplier = new Suppliers($array);
    $suppliermanager = new SuppliersManager($bdd);
    $test =$suppliermanager->update($supplier,$_POST["case"],$_POST["account"],$_POST["subaccount"]);

}
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$supplierId."/errormodif");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/fournisseur/afficher/".$supplierId."/successmodif");
}

?>
