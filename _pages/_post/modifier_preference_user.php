﻿<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 11:29
 */

include("../../_cfg/cfg.php");

if(isset($_POST['valider'])) {
    $username = $_POST['username'];
    if(isset($_POST['password']) && !empty($_POST['password'])){
        $password = $_POST['password'];
    }
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];

    
    if(isset($_POST['password']) && !empty($_POST['password'])){
        $array = array(
            'username' => $username,
            'emailAddress' => $email,
            'password' => $password,
            'phoneNumber' => $phone,
            'defaultCompany' => $_POST["societe"][0],
        );
    }else{
        $array = array(
            'username' => $username,
            'emailAddress' => $email,
            'phoneNumber' => $phone,
            'defaultCompany' => $_POST["societe"][0],
        );
    }

    $user = new Users($array);
    echo "OK";
    $usermanager = new UsersManager($bdd);
    echo "OK2 ";
    $test = $usermanager->updatePreference($user);
    

}
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher/errormodif");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher/successmodif");
}
?>