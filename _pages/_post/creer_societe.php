<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/02/2019
 * Time: 09:12
 */


if(isset($_POST['valider'])) {
    $name=$_POST['name'];
    $address=$_POST['address'];
    $isActive = 1;
    $extension=end(explode(".", $_FILES['nameData']["name"]));
    $_FILES['nameData']["name"] = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $name));


    if (isset($_FILES['nameData'])) {
        $uploadDir = '../../images/societe/'; //path you wish to store you uploaded files
        $uploadedFile = $uploadDir . basename($_FILES['nameData']["name"]).".".$extension;
        if (move_uploaded_file($_FILES['nameData']['tmp_name'], $uploadedFile)) {
            $array = array(
                'name' => $name,
                'address' => $address,
                'isActive' => $isActive
            );

            $company = new Company($array);
            echo $company->getName()." ".$company->getAddress()." ".$company->getIsActive();
            /*$companiesmanager = new CompaniesManager($bdd);
            $companiesmanager->add($company);*/


           // header('Location: '.URLHOST.$_GET['company']."/societe/afficher");
            
        }
        else {
            echo $uploadedFile.'<br />';
            echo $_FILES['nameData']['tmp_name'].'<br />';
            echo sys_get_temp_dir();
            header('Location: '.URLHOST.$_GET['company']."/societe/creer/files");
        }
    }


}

?>

<a href="saisie_company.php"> revenir à la création de Société </a>