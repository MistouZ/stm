<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1><?php print strtoupper($_GET['cat']); ?>
        </h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="<?php echo URLHOST.$_COOKIE['company'].'/accueil'; ?>">Accueil</a>
        <?php
            if(isset($_GET['souscat'])){ 
        ?>
        <i class="fa fa-circle"></i>
        <?php } ?>
    </li>
    <li>
        <span class="active"><?php print ucwords($_GET['souscat']); ?></span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->