<?php

	session_start();
    include_once('../connect.php');

	$sql = "SELECT * FROM customers WHERE is_active='1'";
	$result = $link->query($sql);
	if ($result->num_rows > 0) {
    // output data of each row
		while($row = $result->fetch_assoc()) {
			echo "id: " . $row["idcustomers"]. " - Nom de la société : " . $row["name"]. " " . $row["physical_address"]. "<br />";
			echo "Adresse de facturation :" . $row["invoice_address"]. "<br>";
		}
	}
	else {
		echo "0 results";
	}



$link->close();

?>
