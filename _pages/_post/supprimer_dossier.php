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
echo $folder->getIdFolder();
$foldermanager = new FoldersManager($bdd);
$test = $foldermanager->delete($folder->getIdFolder());

if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/error");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/success");
}

?>
