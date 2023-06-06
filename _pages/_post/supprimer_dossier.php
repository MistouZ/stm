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
$folder->setIdFolder($idFolder);
$foldermanager = new FoldersManager($bdd);
$test = $foldermanager->delete($folder->getIdFolder());


if(is_null($test)){
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/errorsuppr");
}else{
    //Ajout d'un objet logs pour tracer l'action sur le dossier id et pas folderNumber
    $date = date('Y-m-d H:i:s');
    $arraylogs = array(
        'username' => $_COOKIE["username"],
        'company' => $companyId,
        'type' => "folder",
        'action' => "deleted",
        'id' => $idFolder,
        'date' => $date
    );
    $log = new Logs($arraylogs);
    $logsmgmt = new LogsManager($bdd);
    $logsmgmt = $logsmgmt->add($log);
    header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/successsuppr");
}

?>
