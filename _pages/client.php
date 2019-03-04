<?php 
    if (isset($_GET['souscat']) AND (empty($_GET['soussouscat']))) { 
        if($_GET['souscat']!="afficher"){
            if(file_exists(__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php')) {               
                include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');   
            }
        }else{
            include __DIR__.'/'.$_GET['souscat'].'/listing-client.php';
        }
        
    } elseif (isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND empty($_GET['soussoussouscat'])) {
        if(!ctype_digit($_GET['soussouscat'])){
            echo "Get : ".$_GET['soussouscat']. " int : ".ctype_digit($_GET['soussouscat']);
            include __DIR__.'/'.$_GET['souscat'].'/listing-client.php';
            
        }elseif(isset($_GET['soussoussouscat']) AND ($_GET['soussoussouscat']!="contact")){
            echo "Get2 : ".$_GET['soussouscat']. " int : ".ctype_digit($_GET['soussouscat']);
            include __DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php';
        }elseif(isset($_GET['soussoussouscat']) AND ($_GET['soussoussouscat']=="contact")){
            echo "Get3 : ".$_GET['soussouscat']. " int : ".ctype_digit($_GET['soussouscat']);
            include __DIR__.'/'.$_GET['cat5'].'/'.$_GET['soussoussouscat'].'.php';
        }else{
            echo "Get4 : ".$_GET['soussouscat']. " int : ".ctype_digit($_GET['soussouscat']);
            include __DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php';
        }
    }
?>