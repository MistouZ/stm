<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 18/02/2019
 * Time: 15:16
 */

session_start();
//$path = "../../";

$supplierId = $_GET['souscat'];

echo $supplierId;

$bdd = new DB();
$bdd->connexion();
$array = array();
$supplier = new Suppliers($array);
/*$suppliermanager = new SuppliersManager($bdd);
$supplier = $suppliermanager->getByID($supplierId);*/
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