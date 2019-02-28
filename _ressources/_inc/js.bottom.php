<!--[if lt IE 9]>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/respond.min.js"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<?php if($_GET['souscat']=="afficher" || $_GET['souscat']=="creer" || $_GET['souscat']=="modifier"){ ?>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-selectsplitter/bootstrap-selectsplitter.min.js" type="text/javascript"></script>
<?php }elseif($_GET['section']=="connexion"){ ?>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<?php }
        if($_GET['cat']=="societe"){ ?>
<script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<?php } ?>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo URLHOST;?>_ressources/_inc/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<?php if($_GET['souscat']=="afficher" || $_GET['souscat']=="creer" || $_GET['souscat']=="modifier"){ ?>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/table-datatables-responsive.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/form-samples.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/form-validation.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/ui-blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/ui-confirmations.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/components-bootstrap-select-splitter.min.js" type="text/javascript"></script>
<?php }elseif($_GET['section']=="connexion"){ ?>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/login.min.js" type="text/javascript"></script>
<?php } ?>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/dashboard.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo URLHOST;?>_ressources/_inc/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->