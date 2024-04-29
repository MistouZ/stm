<!-- BEGIN SIDEBAR MENU -->
<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<ul class="page-sidebar-menu   " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
    <li class="nav-item start">
        <a href="<?php echo URLHOST.$_COOKIE['company'].'/accueil'; ?>" class="nav-link nav-toggle">
            <i class="icon-home"></i>
            <span class="title">Accueil</span>
            <span class="selected"></span>
            
        </a>
    </li>
    <li class="heading">
        <h3 class="uppercase"><i class="fas fa-users"></i> Relations</h3>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fas fa-user-tie"></i>
            <span class="title">Clients</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
        <?php
            if($_COOKIE["credential"] == "A" || $_COOKIE["credential"] == "C") {
        ?>
           <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/client/creer'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                    </a>
           </li>
        <?php
            }
        ?>
           <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/client/afficher'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Listing</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fas fa-user-tag"></i>
            <span class="title">Fournisseurs</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
        <?php
            if($_COOKIE["credential"] == "A" || $_COOKIE["credential"] == "C") {
        ?>
            <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/fournisseur/creer'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                    </a>
            </li>
            <?php
            }
        ?>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/fournisseur/afficher'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Listing</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="heading">
        <h3 class="uppercase"><i class="fas fa-wallet"></i> Documents</h3>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fas fa-folder-open"></i>
            <span class="title">Dossier</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/creer'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/afficher'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Listing</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fas fa-file-invoice"></i>
            <span class="title">Devis</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/creer'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/cours'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> En cours</span>
                </a>
            </li>
            <!--<li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/eclates'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Eclatés</span>
                </a>
            </li>-->
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/partiels'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Partiels</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/valides'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Validés</span>
                </a>
            </li>
            <?php
                if($_COOKIE["credential"] == "A" || $_COOKIE["credential"] == "C") {
            ?>
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/archives'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-list-alt"></i> Archivés</span>
                    </a>
                </li>
            <?php
                }
            ?>
            <!--<li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/archives'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Archivés</span>
                </a>
            </li>-->
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="<?php echo URLHOST.$_COOKIE['company'].'/proforma/afficher/cours'; ?>" class="nav-link nav-toggle">
            <i class="fas fa-file-alt"></i>
            <span class="title">Proformas</span>
        </a>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fas fa-file-invoice-dollar"></i>
            <span class="title">Factures</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/facture/afficher/cours'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> En cours</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/facture/afficher/partiels'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Partiels</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/facture/afficher/valides'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Validées</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="<?php echo URLHOST.$_COOKIE['company'].'/avoir/afficher'; ?>" class="nav-link nav-toggle">
            <i class="fas fa-file-prescription"></i>
            <span class="title">Avoirs</span>
        </a>
    </li>
    <?php
        if($_COOKIE["credential"] == "A" || $_COOKIE["credential"] == "F" || $_COOKIE["credential"] == "C") {
    ?>
        <li class="heading">
            <h3 class="uppercase"><i class="fas fa-calculator"></i> Analyses</h3>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fas fa-chart-line"></i>
                <span class="title">Palmares</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/palmares/devis/creer'; ?>" class="nav-link">
                        <span class="title"><i class="fas fa-chart-pie"></i> Devis</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/palmares/proforma/creer'; ?>" class="nav-link ">
                        <span class="title"><i class="fas fa-chart-area"></i> Proformas</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/palmares/facture/creer'; ?>" class="nav-link ">
                        <span class="title"><i class="fas fa-chart-line"></i> Factures</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/palmares/avoir/creer'; ?>" class="nav-link "
                       target="_blank">
                        <span class="title"><i class="fas fa-chart-bar"></i> Avoirs</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="<?php echo URLHOST . $_COOKIE['company'] . '/cout/creer'; ?>" class="nav-link nav-toggle">
                <i class="fas fa-chart-bar"></i>
                <span class="title">Analyse des coûts</span>
            </a>
        </li>
        <li class="nav-item  ">
            <a href="<?php echo URLHOST . $_COOKIE['company'] . '/export/creer'; ?>" class="nav-link nav-toggle">
                <i class="fas fa-file-export"></i>
                <span class="title">Exports</span>
            </a>
        </li>
        <?php
    }
    if($_COOKIE["credential"] == "A" || $_COOKIE["credential"] == "C"){

        ?>
        <li class="heading">
            <h3 class="uppercase"><i class="fas fa-toolbox"></i> Administration</h3>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fas fa-sort-numeric-down"></i>
                    <span class="title">Compteurs</span>
                    <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/compteurs/creer'; ?>" class="nav-link "
                            target="_blank">
                        <span class="title"><i class="fas fa-undo-alt"></i> Réinitilisation</span>
                    </a>
                </li>
                <li class="nav-item  ">
                <a href="<?php echo URLHOST.$_COOKIE['company'].'/compteurs/afficher'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Listing</span>
                </a>
            </li>
            </ul>
        </li>
        <?php
    }
    if($_COOKIE["credential"] == "A"){

        ?>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fas fa-user-shield"></i>
                <span class="title">Sécurité</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/user/creer'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/user/afficher'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-list-alt"></i> Listing</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fas fa-building"></i>
                <span class="title">Société</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/societe/creer'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/societe/afficher'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-list-alt"></i> Listing</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fas fa-percent"></i>
                <span class="title">Taxes</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/taxe/creer'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?php echo URLHOST . $_COOKIE['company'] . '/taxe/afficher'; ?>" class="nav-link ">
                        <span class="title"><i class="far fa-list-alt"></i> Listing</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="title">Erreurs</span>
            </a>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="far fa-question-circle"></i>
                <span class="title">FAQ</span>
            </a>
        </li>
        <?php
    }
    ?>
</ul>
<!-- END SIDEBAR MENU -->