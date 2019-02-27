<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$array = array();
$tax = new Tax($array);
$taxes = new TaxManager($bdd);
$tax = $taxes->getById($_GET['soussouscat']);

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light form-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Modification de la taxe <span style="font-style: italic; font-weight: 800;"><?php echo $tax->getName(); ?></span></span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/modifier_taxe.php"; ?>" id="inscription" name="inscription" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Tous les champs doivent être remplis </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Modification de taxe effectuée avec succès </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom de la taxe
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name" data-required="1" class="form-control" placeholder="Nom" value="<?php echo $tax->getName(); ?>" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="value">Valeur de la taxe en %
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="percent" id="percent" type="text" class="form-control" value="<?php echo $tax->getPercent(); ?>"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="default">Taxe par défaut
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="default" id="default" type="checkbox" <?php if($tax->getIsDefault()==1){ echo "checked=\"checked\"";} ?>class="form-control" /> </div>
                        </div>
                        <input type="hidden" name="idTax" id="idTax" data-required="1" class="form-control" value="<?php echo $_GET['soussouscat'] ?>" />
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="valider" id="valider" class="btn green">Valider</button>
                                <button type="button" class="btn default">Annuler</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>