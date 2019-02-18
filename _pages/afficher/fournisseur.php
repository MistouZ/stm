<?php
session_start();
//$path = "../../";

$customerId = $_GET['souscat'];

$bdd = new DB();
$bdd->connexion();
$array = array();
$supplier = new Suppliers($array);
$suppliermanager = new SuppliersManager($bdd);
$suppliermanager = $suppliermanager->getList();
?>

<html lang="fr">
Affichage du client : <?php echo $supplier->getName(); ?><br />
Adresse physique : <?php echo $supplier->getPhysicalAddress(); ?><br />
Adresse de facturation : <?php echo $supplier->getInvoiceAddress(); ?><br />
</html>

<?php //print_r( R::dump( $customer ) ); ?>

<?php
//$client = R::findAll('client','idcustomer = ?',array($_GET['souscat']));
?>