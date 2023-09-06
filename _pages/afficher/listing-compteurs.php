<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$retour = $_GET['soussouscat'];
$array = array();
$company = new Company($array);
$companies = new CompaniesManager($bdd);
$companies = $companies->getCompanies($_COOKIE["username"]);

?>
<div class="row">
    <div class="col-md-12">
        <?php if($retour == "error"){ ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Erreur lors de la réinitilisation des compteurs !</div>
        <?php }elseif($retour == "success"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> La réinitilisation a bien été effectuée !</div>
        <?php
                }
        ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des compteurs  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Nom de la société</th>
                            <th class="all">Dossier</th>
                            <th class="all">Devis</th>
                            <th class="all">Factures</th>
                            <th class="all">Avoirs</th>
                            <th class="all">Réinitialiser</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($companies as $company) {
                        $counter = new Counter($array);
                        $countermanager = new CounterManager($bdd);
                        $counter = $countermanager->getCount($company->getIdcompany());
                       
                        ?>
                        <tr>
                            <td><?php echo $company->getName(); ?></td>
                            <td><?php echo $counter->getFolder(); ?></td>
                            <td><?php echo $counter->getQuotation();?></td>
                            <td><?php echo $counter->getInvoice();?></td>
                            <td><?php echo $counter->getAsset();?></td>
                            <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Réinitialiser le compteur de la société <?php echo $company->getName(); ?>" data-content="ATTENTION ! La réinitialisation est irréversible !" data-btn-ok-label="Réinitiliaser" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo URLHOST.'_pages/_post/reinitiliaser_compteurs.php?idCompany='.$counter->getCompany(); ?>"><i class="fas fa-undo" alt="Supprimer"></i> Réinitiliaser</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>