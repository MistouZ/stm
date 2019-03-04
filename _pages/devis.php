<?php 
    if (isset($_GET['souscat']) AND (empty($_GET['soussouscat']))) { 
        if(file_exists(__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php')) {               
            echo "1";
            include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');   
        }else{
            echo "2";
            include __DIR__.'/'.$_GET['souscat'].'/listing.php';
        }
        
    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND (empty($_GET['soussoussouscat']))) { 
        echo "3";
        include __DIR__.'/'.$_GET['souscat'].'/listing.php'; 

    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND (isset($_GET['soussoussouscat']))) { 
        echo "4";
        include __DIR__.'/'.$_GET['souscat'].'/vuedet.php'; 

    }
?>