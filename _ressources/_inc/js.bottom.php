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
<?php if($_GET['souscat']=="afficher" || $_GET['souscat']=="creer" || $_GET['souscat']=="modifier" || $_GET["soussouscat"] == "creer" || $_GET["soussouscat"] == "afficher" ){ ?>
        <script src="https://cdn.datatables.net/plug-ins/1.13.7/sorting/date-eu.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-selectsplitter/bootstrap-selectsplitter.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js" type="text/javascript"></script>
        <script src="<?php echo URLHOST;?>_ressources/_inc/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
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
<?php if($_GET['souscat']=="afficher" || $_GET['souscat']=="creer" || $_GET['souscat']=="modifier" || $_GET["soussouscat"] == "creer" || $_GET["soussouscat"] == "afficher"){ ?>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/form-samples.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/form-validation.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/ui-blockui.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/ui-confirmations.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/components-bootstrap-select-splitter.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
<?php }elseif($_GET['section']=="connexion"){ ?>
<script src="<?php echo URLHOST;?>_ressources/_inc/pages/scripts/login.min.js" type="text/javascript"></script>
<?php } ?>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo URLHOST;?>_ressources/_inc/layouts/layout4/scripts/layout.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/layouts/layout4/scripts/demo.min.js" type="text/javascript"></script>
<script src="<?php echo URLHOST;?>_ressources/_inc/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->