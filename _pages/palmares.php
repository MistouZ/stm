<?php 
    if (isset($_GET['souscat']) AND (empty($_GET['soussouscat']))) { 
        if(file_exists(__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php')) {               
            include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');   
        }else{
            include __DIR__.'/'.$_GET['souscat'].'/listing-palmares.php';
        }
        
    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat']))) { 
        
        include __DIR__.'/'.$_GET['souscat'].'/vuedet.php'; 

    } 
?>