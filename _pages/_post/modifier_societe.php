<?php

include("../../_cfg/cfg.php");

$array = array();
$company = new Company($array);
$company = new CompaniesManager($bdd);
$company = $company->getById($_POST['idCompany']);

if(isset($_POST['valider'])) {
    $name=$_POST['name'];
    $address=$_POST['address'];
    $isActive = 1;
    $companyId = $_POST['idCompany'];
   
    if (!empty($_FILES['nameData']["name"])) {
        //supression de l'ancien logo
        $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
        $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
        fclose($_SERVER['DOCUMENT_ROOT']."/images/societe/".basename($image[0]));
        unlink($_SERVER['DOCUMENT_ROOT']."/images/societe/".basename($image[0]));
        //upload du nouveau logo
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
        'idcompany' => $companyId,
        'name' => $name,
        'address' => $address,
        'isActive' => $isActive
    );
    
    $company = new Company($array);
    $companiesmanager = new CompaniesManager($bdd);
    $test = $companiesmanager->update($company);
    
    if(is_null($test)){
        header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher/errormodif");
    }else{
        header('Location: '.URLHOST.$_COOKIE['company']."/societe/afficher/successmodif");
    }

}

?>