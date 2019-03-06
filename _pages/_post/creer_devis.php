<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

echo "Résultats : ";
print_r($_POST['description']);
print_r($_POST['quantite']);
print_r($_POST["remise"]);
print_r($_POST["prix"]);

print_r($_POST);
echo$_POST['description'][0];
?>