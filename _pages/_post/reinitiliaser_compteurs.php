<?php
include("../../_cfg/cfg.php");
    

if(isset($_POST['valider'])){

    $countermanager = new CounterManager($bdd);

    for ($i=0;$i<count($_POST["case"]);$i++)
    {
        $array = array(
            'quotation' => 0,
            'invoice' => 0,
            'asset' => 0,
            'company' => $_POST["case"][$i]
        );
    
        $counter = new Counter($array);
        $test = $countermanager->updateCounter($counter);
    }    
    if(is_null($test)){
        header('Location: '.URLHOST.$_COOKIE['company']."/compteurs/afficher/error");
    }else{
        header('Location: '.URLHOST.$_COOKIE['company']."/compteurs/afficher/success");
    }
}

?>
