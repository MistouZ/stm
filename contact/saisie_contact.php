<?php
session_start();
  include_once('../connect.php');

  $sql = "SELECT * FROM company";
	$result = $link->query($sql);

 ?>
<html>
    <head><title>Création d'un nouveau Client / Fournisseur</title></head>
    <body>
        <h1>Bienvenue sur le site de création de clients STM-Compta pour Moy par Moy </h1>
        <h2>Commencez-donc par vous inscrire :</h2>
        <form name="inscription" method="post" action="insert_contact.php">
            <label for="name">Nom de la société : </label><input type="text" name="name" id="name"/> <br/>
            <label for="physical_address">Adresse phyisque du client : </label><input type="text" name="physical_address" id="physical_address"/><br/>
            <label for="invoice_address">Adresse de facturation du client : (si différente de l'adresse physique) </label><input type="text" name="invoice_address" id="invoice_address"/><br/>
            <label for="is_supplier">Le client est-il aussi un fournisseur ? </label> <input type="checkbox" id"=is_supplier" name="is_supplier" value="is_supplier" /> <br />
            <label for="company">Société :</label> <?php
              while ($ligne=mysqli_fetch_array($result)){
              echo'<input type="checkbox" name="case[]" value="'.$ligne['idcompany'].'" />';
              echo $ligne["name"];
              }
             ?> <br/>
            <input type="submit" name="valider" value="OK"/>
        </form>
    </body>
</html>
