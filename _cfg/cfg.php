<?php
define('URLHOST','http://dev.bitwin.nc/');
include 'classes/class_db.php';
global $bdd;
$bdd = new DB();
$bdd->connexion();

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra');

?>