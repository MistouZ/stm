<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$username = $_GET["username"];

$array = array();
$user = new Users($array);
$user->setUsername($username);
$usermanager = new UsersManager($bdd);
$usermanager->delete($user);
header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher");

?>
