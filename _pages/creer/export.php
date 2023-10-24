<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

$array = array();
$company = new Company($array);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();
$tax = new Tax($array);
$taxes = new TaxManager($bdd);
$taxes = $taxes->getList();

 ?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject sbold uppercase">Export de fichiers XL Compta</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST.$_COOKIE['company'].'/export/afficher'; ?>" method="post" id="export" name="export" class="form-horizontal">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Les fichiers ont bien été créés</div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date de départ
                                <span class="required"> * </span>
                            </label>
                            <div class="input-group input-medium date date-picker"  data-date-lang="FR-fr" type="text">
                                <input type="text" name="date_from" class="form-control" value="">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Date de fin
                                <span class="required"> * </span>
                            </label>
                            <div class="input-group input-medium date date-picker"  data-date-lang="FR-fr" type="text">
                                <input type="text" name="date_to" class="form-control" value="">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="radio-list" data-error-container="#company_error">
                                <?php
                                    /*foreach ($companies as $company)
                                    {
                                        $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH);
                                        $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                ?>
                                        <label class="radio-inline">
                                <?php
                                        echo'<input type="radio" id="societe" name="societe" value="'.$company->getIdCompany().'" />';
                                ?>
                                            <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/></a>
                                        </label>
                                <?php
                                    }*/
                                ?>
                                </div>
                                <span class="help-block"> Cocher la société souhaitée</span>
                                <div id="company_error"> </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="valider" class="btn green">Valider</button>
                                <button type="button" class="btn grey-salsa btn-outline">Annuler</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>