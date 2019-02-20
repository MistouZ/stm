<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
<?php if($_GET['cat']=="afficher"){ ?>
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css" />
<?php }elseif($_GET['section']=="connexion"){ ?>
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
<?php } ?>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?php echo URLHOST;?>_ressources/_inc/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<?php if($_GET['section']=="connexion"){ ?>
<link href="<?php echo URLHOST;?>_ressources/_inc/pages/css/login-3.min.css" rel="stylesheet" type="text/css" />
<?php } ?>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="<?php echo URLHOST;?>_ressources/_inc/layouts/layout4/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URLHOST;?>_ressources/_inc/layouts/layout4/css/themes/light.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="<?php echo URLHOST;?>_ressources/_inc/layouts/layout4/css/custom.min.css" rel="stylesheet" type="text/css" />
<!-- END THEME LAYOUT STYLES -->
<style type="text/css">
    body.login :before{ 
       position: fixed;
       height: 100%; width: 100%;
       background: url('images/fond.jpg') !important;
       background-size: cover;
       background-repeat:no-repeat;
       z-index: -1; /* Keep the background behind the content */     
       -webkit-filter: blur(8px);
       -webkit-background-size: cover; /* pour Chrome et Safari */
       -moz-background-size: cover; /* pour Firefox */
       -o-background-size: cover; /* pour Opera */
       background-size: cover; /* version standardisée */
    }
    
</style>