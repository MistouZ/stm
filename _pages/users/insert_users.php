<?php
    session_start();
    $path = "../";

    include_once($path.'classes/class_db.php');
    include_once($path.'classes/class_features.php');
    include_once($path.'classes/class_users.php');
    include_once($path.'classes/class_usersmanager.php');


    $bdd = new DB();
    $bdd->connexion();

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

    echo 'Utilisateur ' . $username . ' mdp ' . $password . '<br/>';
    echo 'Nom ' . $name . ' prénom ' . $firstname . '<br/>';
    echo 'Email ' . $email . ' téléphone ' . $phone . '<br/>';


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
<a href="saisie_users.php"> revenir à la création d'utilisateur </a>
</html>