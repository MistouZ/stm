<?php
include("../../_cfg/cfg.php");

    $array = array();
	$user = new Users($array);
	$userManager = new UsersManager($bdd);


if(isset($_POST['valider'])){

		$user = $userManager->connectUser($_POST['username'],$_POST['password']);
		$_SESSION["username"] = $user->getUsername();
		$_SESSION["name"] = $user->getName();
		$_SESSION["firstname"] = $user->getFirstName();
		$_SESSION["credentials"] = $user->getCredential();
	}

	//$link->close();

?>

<html>
    <head>

    </head>
    <body>
        <?php
            echo "Bienvenue ".$user->getUsername()." ".$user->getFirstName()." ".$user->getName()." ".$user->getEmailAddress()." ".$user->getPhoneNumber()."<br>";
            if($user->getCredential() == "A")
            {
         ?>
                <a href="<?php echo $path."users/saisie_users.php" ?>">Ajouter un utilisateur</a> <br>
                <a href="<?php echo $path."company/saisie_company.php" ?>">Ajouter une société</a>
        <?php
            }
            else
            {
                ?>
                <a href="<?php echo $path . "users/show_users.php" ?>">Voir les utilisateur</a> <br>
                <a href="<?php echo $path . "company/show_company.php" ?>">Voir les sociétés</a> <br>
                <a href="<?php echo $path . "customers/show_customers.php" ?>">Voir les clients</a> <br>
                <a href="<?php echo $path . "suppliers/show_suppliers.php" ?>">Voir les fournisseurs</a> <br>
       <?php
            }
        ?>

    </body>
</html>
