<?php
$nom = $_COOKIE['nom'];
$prenom = $_COOKIE['prenom'];
?>
<!-- BEGIN LOGO -->
<div class="page-logo">
    <a href="<?php echo URLHOST; ?>">
        <img src="<?php echo URLHOST; ?>/images/logo.png" alt="logo" class="logo-default" style="width: 50px; margin: 13px 75px 0; " /> </a>
    <div class="menu-toggler sidebar-toggler">
        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
    </div>
</div>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->
<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN PAGE ACTIONS -->
<!-- DOC: Remove "hide" class to enable the page header actions -->
<div class="page-actions">
    <div class="btn-group">
        <button type="button" class="btn red-haze btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <span class="hidden-sm hidden-xs">Actions&nbsp;</span>
            <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="javascript:;">
                    <i class="icon-docs"></i> New Post </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-tag"></i> New Comment </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-share"></i> Share </a>
            </li>
            <li class="divider"> </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-flag"></i> Comments
                    <span class="badge badge-success">4</span>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <i class="icon-users"></i> Feedbacks
                    <span class="badge badge-danger">2</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- END PAGE ACTIONS -->
<!-- BEGIN PAGE TOP -->
<div class="page-top">
    <!-- BEGIN HEADER SEARCH BOX -->
    <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
    <form class="search-form" action="page_general_search_2.html" method="GET">
        <div class="input-group">
            <input type="text" class="form-control input-sm" placeholder="Search..." name="query">
            <span class="input-group-btn">
                <a href="javascript:;" class="btn submit">
                    <i class="icon-magnifier"></i>
                </a>
            </span>
        </div>
    </form>
    <!-- END HEADER SEARCH BOX -->
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
            <li class="separator hide"> </li>
            <!-- BEGIN USER LOGIN DROPDOWN -->
            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
            <li class="dropdown dropdown-user dropdown-dark">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <span class="username username-hide-on-mobile"> <?php echo $nom.' '.$prenom; ?> </span>
                    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                    <img alt="" class="img-circle" src="../assets/layouts/layout4/img/avatar9.jpg" /> </a>
                <ul class="dropdown-menu dropdown-menu-default">
                    <li>
                        <a href="page_user_profile_1.html">
                            <i class="icon-user"></i> Profil </a>
                    </li>
                    <li class="divider"> </li>
                    <li>
                        <a href="<?php echo URLHOST; ?>_pages/_post/deconnexion.php">
                            <i class="icon-logout"></i> Déconnexion </a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
    </div>
    <!-- END TOP NAVIGATION MENU -->
</div>