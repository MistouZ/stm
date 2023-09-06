<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$retour = $_GET['soussouscat'];
$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);

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
                            <th class="min-phone-l">Dossier</th>
                            <th class="none">Devis</th>
                            <th class="none">Factures</th>
                            <th class="none">Avoirs</th>
                            <th class="min-tablet">Réinitialiser</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($companymanager as $company) {
                        $counter = new Counter($array);
                        $countermanager = new CounterManager($bdd);
                        $counter = $countermanager->getCount($company->getIdcompany());
                       
                        ?>
                        <tr>
                            <td><?php echo $company->getName(); ?></td>
                            <td><?php echo $counter->getFolder(); ?>%</td>
                            <td><?php echo $counter->getQuotation();?></td>
                            <td><?php echo $counter->getInvoice();?></td>
                            <td><?php echo $counter->getAsset();?></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/taxe/modifier/'.$tax->getIdTax(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
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