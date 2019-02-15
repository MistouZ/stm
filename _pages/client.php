<?php 
    if (isset($_GET['cat']) AND (empty($_GET['souscat']))) { 
        if(file_exists(__DIR__.'/'.$_GET['cat'].'/'.$_GET['section'].'.php')) {               
            include (__DIR__.'/'.$_GET['cat'].'/'.$_GET['section'].'.php');   
        }else{
            include __DIR__.'/'.$_GET['cat'].'/listing-client.php';
        }
        
    } elseif (isset($_GET['cat']) AND (isset($_GET['souscat']))) { 
        
        include __DIR__.'/'.$_GET['cat'].'/vuedet.php'; 

    } 
?>