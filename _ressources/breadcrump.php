<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1><?php print strtoupper($_GET['section']); ?>
        </h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="<?php echo URLHOST.'accueil/'; ?>">Accueil</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active"><?php print ucwords($_GET['cat']); ?></span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->