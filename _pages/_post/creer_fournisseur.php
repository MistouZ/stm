<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 19/02/2019
 * Time: 16:22
 */
if(isset($_POST['valider'])) {
    $name = $_POST['name'];
    $physical_address = $_POST['physical_address'];
    if ($_POST["invoice_address"] == NULL) {
        $invoice_address = $_POST['physical_address'];
    } else {
        $invoice_address = $_POST['invoice_address'];
    }

    $is_active = 1;

    $array = array(
        'name' => $name,
        'physicalAddress' => $physical_address,
        'invoiceAddress' => $invoice_address,
        'isActive' => $is_active
    );

    $supplier = new Suppliers($array);
    $suppliermanager = new SuppliersManager($bdd);
    $test = $suppliermanager->add($supplier, $_POST["case"]);

    if (is_null($test)) {
        header('Location: ' . URLHOST . $_COOKIE['company'] . "/fournisseur/afficher/error");
    } else {
        header('Location: ' . URLHOST . $_COOKIE['company'] . "/fournisseur/afficher/success");
    }


}
?>
