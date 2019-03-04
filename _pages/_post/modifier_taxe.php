<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 20/02/2019
 * Time: 13:38
 */

include("../../_cfg/cfg.php");


if(isset($_POST['valider'])){
    $name=$_POST['name'];
    $percent = $_POST['percent'];
    $value = ($percent /100);
    $isActive = $_POST["isActive"];
    $idTax = $_POST["idTax"];

    if(isset($_POST["default"]))
    {
        $isdefault = 1;
    }
    else{
        $isdefault = 0;
    }


    $array = array(
        'idTax' => $idTax,
        'name' => $name,
        'percent' => $percent,
        'value' => $value,
        'isActive' => $isActive,
        'isDefault' => $isdefault
    );

    $tax = new Tax($array);
    $taxmanager = new TaxManager($bdd);
    $test = $taxmanager->update($tax);

}
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/taxe/afficher/error");
}else{-
    header('Location: '.URLHOST.$_COOKIE['company']."/taxe/afficher/update");
}