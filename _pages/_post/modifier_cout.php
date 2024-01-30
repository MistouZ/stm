<?php

/**
 * @author Amaury
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

$quotationNumber = $_POST['quotationNumber'];
$folderId = $_POST['folderId'];
$type = $_POST["quotationType"];

$array = array();
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$costmanager = new CostManager($bdd);

$folder = $foldermanager->get($folderId);

$companyId = $folder->getCompanyId();

$i=1;
while(($postDescriptionCout = current($_POST["descriptionCout"])) !== FALSE ){

    $j = key($_POST["descriptionCout"]);
    if(strlen(trim($postDescriptionCout))>0){

        $price = $_POST["prixCout"][$j];
        $supplier = $_POST["fournisseur"][$j];
        $dataDescriptionCout= array(
            'description' => $postDescriptionCout,
            'value' => $price,
            'folderId' => $folderId,
            'supplierId' => $supplier
        );

        $descriptionCout = new Cost($dataDescriptionCout);
        $descriptionsCout[$i] = $descriptionCout;
    }
    $i++;
    next($_POST["descriptionCout"]);
}


$test3 = $costmanager->update($descriptionsCout,$quotationNumber,$type,$companyId);
print_r($test3);


if(is_null($test3))
{
   header('Location: '.$_SERVER['HTTP_REFERER']."/error");
}
else{
  header('Location: '.URLHOST.$_COOKIE['company']."/dossier/afficher/".$folderId."/success");
}
?>