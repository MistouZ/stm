<?php
session_start();
$path = "../../";


include_once($path.'_cfg/classes/class_db.php');
include_once($path.'_cfg/classes/class_features.php');
include_once($path.'_cfg/classes/class_customers.php');
include_once($path.'_cfg/classes/class_customersmanager.php');

$bdd = new DB();
$bdd->connexion();
$array = array();
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$customer = $customermanager->getByID($_GET['souscat']);

?>
<html>
Affichage du client : <?php echo $customer->getName(); ?><br />
Adresse physique : <?php echo $customer->getPhysicalAddress(); ?><br />
Adresse de facturation : <?php echo $customer->getInvoiceAddress(); ?><br />
<?php print_r( R::dump( $customer ) ); ?>

</html>

<?php
//$client = R::findAll('client','idcustomer = ?',array($_GET['souscat']));
?>