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
    $password = $_POST['password'];
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $credential = $_POST["credential"];

    echo "Test1";

    if (isset($_POST["is_seller"])) {
        $is_seller = 1;
    } else {
        $is_seller = 0;
    }
    $is_active = 1;

    echo "Test2";
    
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
    
    echo "Test3";

    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    $usermanager->add($user, $_POST["societe"]);
    
    echo "Test4";

}
//header('Location: '.URLHOST.$_COOKIE['company']."/user/afficher");
?>