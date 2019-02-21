<?php
include("../../_cfg/cfg.php");
session_start();

unset($_COOKIE['company']);
setcookie('company', $_GET['company'], time() + 365*24*3600, '/');

header('Location: '.URLHOST.$_GET['company']."/accueil");


?>