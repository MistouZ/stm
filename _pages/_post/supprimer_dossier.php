﻿<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idFolder = $_GET["idFolder"];

$array = array();
$folder = new Folder($array);
$folder->setIdFolder($idFolder);
$foldermanager = new FoldersManager($bdd);
echo "new FolderManager OK / ";
echo $folder->getIdFolder();
$test = $foldermanager->delete($folder->getIdFolder());

echo "test : ".$test;

if(is_null($test)){
    //header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/error");
}else{
    //header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/success");
}

?>
