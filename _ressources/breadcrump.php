<div class="page-head" style="background-color: white; padding-left: 10px;">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1 style="color: #173752 !important; font-weight: 900;"><?php print strtoupper($_GET['cat']); ?>
        </h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb" style="background-color: white; padding-left: 25px;">
    <li>
        <a href="<?php echo URLHOST.$_COOKIE['company'].'/accueil'; ?>" style="font-weight: 800;">Accueil</a>
        <?php
            if(isset($_GET['souscat']) && empty($_GET['soussouscat'])){ 
        ?>
        <i class="fa fa-circle" style="color: #aa134f;"></i>
        
    </li>
    <li>
        <span class="active" style="color: #523a5f; font-weight: 800;"><?php print ucwords($_GET['souscat']); ?></span>
    </li>
    <?php 
            }else{
    ?>
    <i class="fa fa-circle" style="color: #aa134f;"></i>
        
    </li>
    <li>
        <span class="active" style="color: #523a5f;"><?php print ucwords($_GET['souscat']); ?></span>
    </li>
        
    <?php 
            } 
            
            if(isset($_GET['soussouscat'])){ 
        ?>
        <i class="fa fa-circle" style="color: #aa134f;"></i>
        
    </li>
    <li>
        <span class="active" style="color: #523a5f; font-weight: 800;"><?php print ucwords($_GET['soussouscat']); ?></span>
    </li>
    <?php } ?>
</ul>
<!-- END PAGE BREADCRUMB -->