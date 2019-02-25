<?php

include("../../_cfg/cfg.php");

if(isset($_POST['valider'])) {
    $name=$_POST['name'];
    $address=$_POST['address'];
    $isActive = 1;
    $idCompany = $_POST['idCompany'];
   
    if (!empty($_FILES['nameData']["name"])) {
        $extension=end(explode(".", $_FILES['nameData']["name"]));
        $_FILES['nameData']["name"] = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $name));
        $uploadDir = '../../images/societe/'; //path you wish to store you uploaded files
        $uploadedFile = $uploadDir . basename($_FILES['nameData']["name"]).".".$extension;
        if (!move_uploaded_file($_FILES['nameData']['tmp_name'], $uploadedFile)) {
            echo $uploadedFile.'<br />';
            echo $_FILES['nameData']['tmp_name'].'<br />';
            echo sys_get_temp_dir();
            header('Location: '.URLHOST.$_COOKIE['company']."/societe/modifier/files");
        }
    }
    
    $array = array(
        'idcompany' => $idCompany,
        'name' => $name,
        'address' => $address,
        'isActive' => $isActive
    );
    
    //print_r($array);
    
    $company = new Company($array);
    echo "New Company OK";
    $companiesmanager = new CompaniesManager($bdd);
    echo "New companyManager OK";
    $companiesmanager->update($company);
    echo "Update OK";
    
    header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher/".$idCompany);

}

?>