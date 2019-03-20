<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$idFolder = $_GET["idFolder"];
$costId = $_GET['costId'];

$array = array();
$cost = new Cost($array);
$costmanager = new CostManager($bdd);
$test = $costmanager->delete($costId);


if(is_null($test)){
    header('Location: '.$_SERVER['HTTP_REFERER']."/errorsuppr");
}else{

        header('Location: '.$_SERVER['HTTP_REFERER']."/successsuppr");
}

?>
