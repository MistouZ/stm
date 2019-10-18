<?php 
    if (isset($_GET['souscat']) AND (empty($_GET['soussouscat']))) { 
        if($_GET['souscat']!="afficher"){
            if(file_exists(__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php')) {               
                include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');   
            }
        }else{
            include __DIR__.'/'.$_GET['souscat'].'/listing-user.php';
        }
        
    }
    elseif(isset($_GET['souscat'])  AND (isset($_GET['soussouscat'])) AND isset($_GET['soussoussouscat'])){
        if($_GET['souscat']!="afficher" AND $_GET['soussouscat'] == "preferences") {
            include __DIR__ . '/' . $_GET['souscat'] . '/preference_user.php';
        }
    }
    elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat']))) {
        if(strstr($_GET['soussouscat'],"success") || strstr($_GET['soussouscat'],"error") ){
            include __DIR__.'/'.$_GET['souscat'].'/listing-user.php';
        }else{
            include __DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php'; 
        }

    }

?>