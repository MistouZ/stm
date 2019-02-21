<?php
include("../../_cfg/cfg.php");
session_start();

setcookie('nom', false, time() - 365*24*3600, '/');
setcookie('prenom', false, time() - 365*24*3600, '/');
setcookie('username', false, time() - 365*24*3600, '/');
setcookie('company', false, time() - 365*24*3600, '/');
setcookie('connected', "false", time() + 365*24*3600, '/');

header('Location: '.URLHOST.'connexion');


?>