<?php
    $client = R::getAll('SELECT * FROM client WHERE idcustomer = $_GET[\'souscat\']'));
?>
<html>
Affichage du client : <?php echo $client['name']; ?><br />
Adresse physique : <?php echo $client['physicalAddress']; ?><br />
Adresse de facturation : <?php echo $client['invoiceAddress']; ?>


</html>