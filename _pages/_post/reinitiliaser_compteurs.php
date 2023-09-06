<?php
include("../../_cfg/cfg.php");
    

if(isset($_POST['valider'])){

    print_r($_POST["case"]);

    for ($i=0;$i<count($_POST["case"]);$i++)
    {
        $array = array(
            'quotation' => 0,
            'invoice' => 0,
            'asset' => 0,
            'company' => $_POST["case"][$i]
        );
    
        $counter = new Counter($array);
        print_r($counter);
    }

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
