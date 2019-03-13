<?php
if(isset($_GET['souscat']) AND (empty($_GET['soussouscat']))) {
    if($_GET['souscat']!="afficher"){
        if(file_exists(__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php')) {
            include (__DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php');
        }
    }else{
        include __DIR__.'/'.$_GET['souscat'].'/listing-fournisseur.php';
    }

}elseif(isset($_GET['souscat']) AND (isset($_GET['soussouscat'])) AND empty($_GET['soussoussouscat'])) {
    if(!ctype_digit($_GET['soussouscat'])){
        include __DIR__.'/'.$_GET['souscat'].'/listing-fournisseur.php';

    }else{
        include __DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php';
    }
}elseif(isset($_GET['soussoussouscat']) AND ($_GET['soussoussouscat']=="contact")){
    include __DIR__.'/'.$_GET['cat5'].'/'.$_GET['soussoussouscat'].'.php';

}elseif(isset($_GET['soussoussouscat']) AND ($_GET['soussoussouscat']!="contact")){
    include __DIR__.'/'.$_GET['souscat'].'/'.$_GET['cat'].'.php';

}
?>