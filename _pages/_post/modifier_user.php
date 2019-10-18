<?php
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
    $credential = $_POST["credential"];
    $oldusername = $_POST['oldUsername'];

    if (isset($_POST["is_seller"])) {
        $is_seller = 1;
    } else {
        $is_seller = 0;
    }
    $is_active = 1;
    
    if(isset($_POST['password']) && !empty($_POST['password'])){
        $array = array(
            'username' => $username,
            'name' => $name,
            'firstname' => $firstname,
            'emailAddress' => $email,
            'password' => $password,
            'phoneNumber' => $phone,
            'credential' => $credential,
            'defaultCompany' => $_POST["societe"][0],
            'isSeller' => $is_seller,
            'isActive' => $is_active
        );
    }else{
        $array = array(
            'username' => $username,
            'name' => $name,
            'firstname' => $firstname,
            'emailAddress' => $email,
            'phoneNumber' => $phone,
            'credential' => $credential,
            'defaultCompany' => $_POST["societe"][0],
            'isSeller' => $is_seller,
            'isActive' => $is_active
        );
    }

    $user = new Users($array);
    echo "OK";
    $usermanager = new UsersManager($bdd);
    echo "OK2 / ".$oldusername;
    $test = $usermanager->update($user, $_POST["societe"],$oldusername);
    

}
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher/errormodif");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher/successmodif");
}
?>