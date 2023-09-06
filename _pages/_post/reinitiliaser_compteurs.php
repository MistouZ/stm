<?php
include("../../_cfg/cfg.php");
    

if(isset($_POST['valider'])){

    print_r($_POST["case"]);

    /*
    foreach($_POST["case"])
    {
        $array = array(
            'quotation' => 0,
            'invoice' => 0,
            'asset' => 0,
            'company' => $_POST["case"]
        );
    
        $counter = new Counter($array);
        $countermanager = new CounterManager($bdd);
    }
    $test = $countermanager->updateCounter();

    
    if(is_null($test)){
        header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/error");
    }else{
        header('Location: '.URLHOST.$_COOKIE['company']."/client/afficher/success");
    }*/
}

?>
