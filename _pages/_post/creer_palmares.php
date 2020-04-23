<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 20/02/2019
 * Time: 13:38
 */

include("../../_cfg/cfg.php");

if(isset($_POST['valider'])) {

    $type = $_POST['type'];
    $array = array();
    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);
    $quotation = new Quotation($array);
    $quotationmanager = new QuotationManager($bdd);

    $datefrom = $_POST["date_from"];
    $dateto = $_POST["date_to"];


    $test = $foldermanager->add($folder);

    if (is_null($test)) {
        header('Location: ' . URLHOST . $_COOKIE['company'] . "/palmares/afficher/error");
    } else {
        header('Location: ' . URLHOST . $_COOKIE['company'] . "/palmares/afficher/success");
    }
}