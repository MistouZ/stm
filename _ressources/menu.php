<!-- BEGIN SIDEBAR MENU -->
<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
    <li class="nav-item start">
        <a href="<?php echo URLHOST.'accueil'; ?>" class="nav-link nav-toggle">
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
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'client/creer'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'client/afficher'; ?>" class="nav-link ">
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
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'fournisseur/creer'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'fournisseur/afficher'; ?>" class="nav-link ">
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
                <a href="<?php echo URLHOST.'dossier/creer'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'dossier/afficher'; ?>" class="nav-link ">
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
                <a href="<?php echo URLHOST.'devis/creer'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'devis/afficher/cours'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> En cours</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'devis/afficher/eclates'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Eclatés</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'devis/afficher/partiels'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Partiels</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'devis/afficher/valides'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Validés</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'devis/afficher/archives'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Archivés</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="<?php echo URLHOST.'proforma/afficher'; ?>" class="nav-link nav-toggle">
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
                <a href="<?php echo URLHOST.'facture/afficher/cours'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> En cours</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'facture/afficher/partiels'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Partiels</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'facture/afficher/valides'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-list-alt"></i> Validés</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="<?php echo URLHOST.'avoir/afficher'; ?>" class="nav-link nav-toggle">
            <i class="fas fa-file-prescription"></i>
            <span class="title">Avoirs</span>
        </a>
    </li>
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
                <a href="<?php echo URLHOST.'palmares/afficher'; ?>" class="nav-link " target="_blank">
                    <span class="title"><i class="fas fa-chart-pie"></i> Devis</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'palmares/afficher'; ?>" class="nav-link ">
                    <span class="title"><i class="fas fa-chart-area"></i> Proformas</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'palmares/afficher'; ?>" class="nav-link " target="_blank">
                    <span class="title"><i class="fas fa-chart-line"></i> Factures</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'palmares/afficher'; ?>" class="nav-link " target="_blank">
                    <span class="title"><i class="fas fa-chart-bar"></i> Avoirs</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fas fa-chart-bar"></i>
            <span class="title">Analyse des coûts</span>
        </a>
    </li>
    <li class="heading">
        <h3 class="uppercase"><i class="fas fa-toolbox"></i> Administration</h3>
    </li>
    <li class="nav-item  ">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fas fa-user-shield"></i>
            <span class="title">Sécurité</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'user/creer'; ?>" class="nav-link ">
                    <span class="title"><i class="far fa-plus-square"></i> Créer</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?php echo URLHOST.'user/afficher'; ?>" class="nav-link ">
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
</ul>
<!-- END SIDEBAR MENU -->