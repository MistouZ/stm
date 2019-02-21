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
    $email = $_POST['email_address'];
    $phone = $_POST['phone_number'];
    $credential = $_POST["credential"];

    if (isset($_POST["is_seller"])) {
        $is_seller = 1;
    } else {
        $is_seller = 0;
    }
    $is_active = 1;


    $array = array(
        'username' => $username,
        'name' => $name,
        'firstname' => $firstname,
        'emailAddress' => $email,
        'password' => $password,
        'phoneNumber' => $phone,
        'credential' => $credential,
        'isSeller' => $is_seller,
        'isActive' => $is_active
    );

    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    $usermanager->add($user, $_POST["case"]);

}
echo "New record created successfully";

?>
<html>
<a href="<?php echo URLHOST."utilisateurs/afficher" ?>">Revenir à la liste des users </a>
</html>