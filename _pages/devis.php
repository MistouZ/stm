<?php 
    if (isset($_GET['souscat']) AND (empty($_GET['soussouscat']))) { 
        if(file_exists(__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php')) {    
            include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');   
        }else{
            include __DIR__.'/'.$_GET['souscat'].'/listing.php';
        }
        
    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND (empty($_GET['soussoussouscat']))) { 
        include __DIR__.'/'.$_GET['souscat'].'/listing.php'; 

    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND (isset($_GET['soussoussouscat']))) { 
        if($_GET['souscat']=="afficher" AND ctype_digit($_GET['soussoussouscat'])){
            include __DIR__.'/'.$_GET['souscat'].'/vuedet.php';
        }elseif($_GET['souscat']=="afficher" AND !ctype_digit($_GET['soussoussouscat'])){
            include __DIR__.'/'.$_GET['souscat'].'/listing.php';
        }
        elseif($_GET['souscat']=="imprimer" AND ctype_digit($_GET['soussoussouscat'])){
            include __DIR__.'/'.$_GET['souscat'].'/quotation.php';
        }else{
            include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');
        }

    }
?>