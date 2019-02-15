<?php
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

global $bdd;

$bdd = new PDO('mysql:host=localhost;dbname=stm_compta_dev', 'stm-adm', 'gx@M5v59');

R::setup('mysql:host=localhost;dbname=stm_compta_dev','stm-adm','gx@M5v59'); //mysql

R::freeze( true );

define('URLHOST','http://dev.bitwin.nc/');

date_default_timezone_set('Pacific/Noumea');
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
?>