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
$usermanager = new UsersManager($bdd);
$user->setUsername($username);
$test = $usermanager->reactivate($user);
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher/erroractivate");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher/successactivate");
}

?>
