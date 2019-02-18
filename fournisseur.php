<?php
session_start();

$suppplierId = $_GET['souscat'];

$bdd = new DB();
$bdd->connexion();
$array = array();
$supplier = new Suppliers($array);
$suppliermanager = new SuppliersManager($bdd);
$supplier = $suppliermanager->getByID($suppplierId);
?>

<html lang="fr">
Affichage du fournisseur : <?php echo $supplier->getName(); ?><br />
Adresse physique : <?php echo $supplier->getPhysicalAddress(); ?><br />
Adresse de facturation : <?php echo $supplier->getInvoiceAddress(); ?><br />
</html>

<?php //print_r( R::dump( $customer ) ); ?>

<?php
//$client = R::findAll('client','idcustomer = ?',array($_GET['souscat']));
?>