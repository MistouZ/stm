<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/02/2019
 * Time: 09:12
 */

include("../../_cfg/cfg.php");

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

            print_r($array);

            $company = new Company($array);
            $companiesmanager = new CompaniesManager($bdd);
            $test = $companiesmanager->add($company);

            $arraycounter = array();
            $counter = new Counter($arraycounter);
            $countermanager = new CounterManager($bdd);
            $counter = $countermanager->initiation($test);


            
            if(is_null($test)){
                header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher/error");
            }else{
                header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher/success");
            }
            
        }
        else {
            echo $uploadedFile.'<br />';
            echo $_FILES['nameData']['tmp_name'].'<br />';
            echo sys_get_temp_dir();
            header('Location: '.URLHOST.$_COOKIE['company']."/societe/creer/files");
        }
    }


}

?>