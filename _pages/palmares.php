<?php 
    if (isset($_GET['souscat']) AND (isset($_GET['soussouscat']))) {
        if(file_exists(__DIR__.'/'.$_GET['soussouscat'].'/'.$_GET['cat'].'.php')) {
            include (__DIR__.'/'.$_GET['soussouscat'].'/'.$_GET['cat'].'.php?='.$_GET["souscat"]);
        }else{
            include __DIR__.'/'.$_GET['souscat'].'/listing-palmares.php';
        }
        
    }
?>