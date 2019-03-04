<?php 
    if (isset($_GET['souscat']) AND (empty($_GET['soussouscat']))) { 
        if(file_exists(__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php')) {               
            echo '/'.$_GET['souscat'].'/'.$_GET['cat'].'.php';
            include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');   
        }else{
            include __DIR__.'/'.$_GET['souscat'].'/listing.php';
        }
        
    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND (empty($_GET['soussoussouscat']))) { 
        include __DIR__.'/'.$_GET['souscat'].'/listing.php'; 

    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND (isset($_GET['soussoussouscat']))) { 
        include __DIR__.'/'.$_GET['souscat'].'/vuedet.php'; 

    }
?>