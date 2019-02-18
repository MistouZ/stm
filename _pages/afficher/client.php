<?php
session_start();
//$path = "../../";

$customerId = $_GET['souscat'];

$bdd = new DB();
$bdd->connexion();
$array = array();
$customer = new Customers($array);
echo $customer;
$customermanager = new CustomersManager($bdd);
$customer = $customermanager->getByID($customerId);
?>

<html lang="fr">
Affichage du client : <?php echo $customer->getName(); ?><br />
Adresse physique : <?php echo $customer->getPhysicalAddress(); ?><br />
Adresse de facturation : <?php echo $customer->getInvoiceAddress(); ?><br />
</html>

<?php //print_r( R::dump( $customer ) ); ?>

<?php
//$client = R::findAll('client','idcustomer = ?',array($_GET['souscat']));
?>