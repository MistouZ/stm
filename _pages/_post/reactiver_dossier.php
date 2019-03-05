<?php
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
$foldermanager = new FoldersManager($bdd);
$folder->setIdFolder($idFolder);
$test = $foldermanager->reactivate($folder);
if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/erroractivate");
}else{
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/successactivate");
}

?>
