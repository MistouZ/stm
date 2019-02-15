<?php
    $client = R::findOne('client','idcustomer = ?',array($_GET['souscat']));
?>
<html>
Affichage du client : <?php echo $client['name']; ?><br />
Adresse physique : <?php echo $client['physicalAddresse']; ?>
Adresse de facturation : <?php echo $client['invoiceAddress']; ?>


</html>