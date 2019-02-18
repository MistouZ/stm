<?php
$bdd = new DB();
$bdd->connexion();

define('URLHOST','http://dev.bitwin.nc/');

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
?>