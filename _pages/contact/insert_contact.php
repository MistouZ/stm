<?php

	session_start();
  include_once('../connect.php');

if(isset($_POST['valider'])){
		$name=$_POST['name'];
		$physical_address=$_POST['physical_address'];
    if($_POST["invoice_address"] == NULL)
    {
        $invoice_address=$_POST['physical_address'];
    }
    else{
      $invoice_address=$_POST['invoice_address'];
    }
    if(isset($_POST["is_supplier"]))
    {
      $provider = 1;
    }
    else{
      $provider = 0;
    }

		$is_active =1;

		$sql = "INSERT INTO customers (name, physical_address,invoice_address,is_active)
					VALUES ('".addslashes($name)."', '".addslashes($physical_address)."','".addslashes($invoice_address)."','".$is_active."')";
    if($provider == 1)
    {
      $sql2 = "INSERT INTO suppliers (name, physical_address,invoice_address,is_active)
  		VALUES ('".addslashes($name)."', '".addslashes($physical_address)."','".addslashes($invoice_address)."','".$is_active."')";
    }
  }

		if ($link->query($sql) === TRUE) {
		    echo "New customer created successfully </br/>";
				$sql3 = "SELECT idcustomers FROM customers WHERE is_active='1' AND name ='$name'";
				$result = $link->query($sql3);
				while($row = $result->fetch_assoc()){
					for ($i=0;$i<count($_POST['case']);$i++)
					{
						$sql4 =  "INSERT INTO link_company_customers (customers_idcustomer, company_idcompany)
						VALUES ('".$row["idcustomers"]."', '".$_POST['case'][$i]."')";
						$link->query($sql4);
					}
				}
		}
		else {
		    echo "Error: " . $sql. "<br>" . $link->error;
		}
		if($provider == 1){
			if ($link->query($sql2) === TRUE) {
			    echo "New record supplier successfully </br/>";
					$sql5 = "SELECT * FROM suppliers WHERE is_active='1' AND name ='$name'";
					$result = $link->query($sql5);
					while($row = $result->fetch_assoc()){
						for ($i=0;$i<count($_POST['case']);$i++)
						{
							$sql6 =  "INSERT INTO link_company_suppliers (company_idcompany, suppliers_idsupplier)
							VALUES ('".$_POST['case'][$i]."', '".$row["idsupplier"]."')";
							$link->query($sql6);
						}
					}
			}
			else {
			    echo "Error: " . $sql2. "<br>" . $link->error;
			}
		}



$link->close();

?>

<a href="saisie_customers.php"> revenir à la création de clients / fournisseur </a>
