<?php
include("../../_cfg/cfg.php");
session_start();

setcookie('nom', false, time() - 365*24*3600, '/');
unset($_COOKIE['nom']);
setcookie('prenom', false, time() - 365*24*3600, '/');
unset($_COOKIE['prenom']);
setcookie('username', false, time() - 365*24*3600, '/');
unset($_COOKIE['username']);
unset($_COOKIE['connected']);
setcookie('connected', false, time() + 365*24*3600, '/');

header('Location: '.URLHOST.'connexion');


?>