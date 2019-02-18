<?php
    $client = R::findOne('client','idcustomer = ?',array($_GET['souscat']));
?>
<html>Modification du client : <?php echo $client['name']; ?></html>