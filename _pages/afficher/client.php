<?php
session_start();
//$path = "../../";
echo "test 1";
$bdd = new DB();
echo "test 1-1";
$bdd->connexion();
echo "test 1-2";
$array = array();
echo "test 1-3";
$customer = new Customers($array);
echo "test 1-4";
$customermanager = new CustomersManager($bdd);
echo "test 1-5";
$customer = $customermanager->getByID(7);
echo "test2";
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