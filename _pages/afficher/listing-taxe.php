<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$retour = $_GET['soussouscat'];
$array = array();
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$taxmanager = $taxmanager->getAllTaxes();

?>
<div class="row">
    <div class="col-md-12">
        <?php if($retour == "existe"){ ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> La taxe existe déjà !</div>
        <?php }elseif($retour == "delete"){?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> La taxe a bien été supprimée !</div>
        <?php } elseif($retour == "error"){?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Erreur lors de la création de la taxe !</div>
        <?php }elseif($retour == "success"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> La taxe a bien été créée !</div>
        <?php }elseif($retour == "update"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> La taxe a bien été mise à jour !</div>
        <?php } ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des taxes  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Nom de la Taxe</th>
                            <th class="min-phone-l">Valeur</th>
                            <th class="none">Actif</th>
                            <th class="none">Taxe par défaut</th>
                            <th class="min-tablet">Modifier</th>
                            <th class="min-tablet">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($taxmanager as $tax) {
                        if($tax->getIsActive() == 1)
                        {
                            $actif ="Oui";
                        }
                        else {
                            $actif = "Non";
                        }
                        if($tax->getIsDefault() == 1)
                        {
                            $tax->setIsDefault("Oui");
                        }
                        else {
                            $tax->setIsDefault("Non");
                        }

                        ?>
                        <tr>
                            <td><?php echo $tax->getName(); ?></td>
                            <td><?php echo $tax->getPercent(); ?>%</td>
                            <td><?php echo $actif;?></td>
                            <td><?php echo $tax->getIsDefault();?></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/taxe/modifier/'.$tax->getIdTax(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                            <?php
                            if($tax->getIsActive() == 1) {
                                ?>
                                <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le client <?php echo $tax->getName(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo URLHOST . "_pages/_post/supprimer_taxe.php?idTax=" . $tax->getIdTax(); ?>"><i
                                                class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                                <?php
                            }
                            else {
                                ?>
                                <td><a class="btn green-dark" data-placement="top" data-toggle="confirmation" data-title="Reactiver le client <?php echo $tax->getName(); ?> ?" data-btn-ok-label="Reactiver" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo  URLHOST."_pages/_post/reactiver_taxe.php?idTax=".$tax->getIdTax(); ?>"><i class="fas fa-toggle-on" alt="Reactiver"></i> Reactiver</a></td>
                                <?php
                            }
                            ?>
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