<?php

/**
 * @author Amaury
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
                    <span class="caption-subject sbold uppercase">Création d'un client</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/creer_client.php"; ?>" method="post" id="client" name="client" class="form-horizontal">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Le client a bien été créé </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom du client
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="name" data-required="1" class="form-control" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse physique
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="physical_address" id="physical_address" type="text" class="form-control" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse de facturation
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="invoice_address" id="invoice_address" type="text" class="form-control" />
                                <span class="help-block"> Si différente de l'adresse physique </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Fournisseur
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="is_supplier" name="is_supplier" id="is_supplier" /></label>
                                </div>
                                <span class="help-block"> Cocher si ce client est aussi un fournisseur </span>
                                <div id="form_2_services_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#company_error">
                                <?php
                                    foreach ($companies as $company)
                                    {
                                ?>
                                        <label class="checkbox-inline">
                                <?php
                                        echo'<input type="checkbox" id="case[]" name="case[]" value="'.$company->getIdCompany().'" />';
                                ?>
                                            <img src="<?php echo URLHOST; ?>images/societe/<?php echo $company->getNameData(); ?>.jpg" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/></a>
                                        </label>
                                <?php
                                    }
                                ?>
                                </div>
                                <span class="help-block"> Cocher la ou les société(s) affiliée(s) au client </span>
                                <div id="company_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Compte associé au client
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="customer_account" id="customer_account" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="control-label col-md-3">Sous-compte associé au client
                                <span class="required"> * </span>
                            </label>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Ss-compte-1" id="customer_subaccount_1" name="customer_subaccount_1">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Ss-compte-2" id="customer_subaccount_2" name="customer_subaccount_2">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Ss-compte-3" id="customer_subaccount_3" name="customer_subaccount_3">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Ss-compte-4" id="customer_subaccount_4" name="customer_subaccount_4">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Taxes
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#tax_error">
                                    <?php
                                    foreach ($taxes as $tax)
                                    {
                                        ?>
                                        <label class="checkbox-inline">

                                            <input type="checkbox" id="taxes[]" name="taxes[]" value="<?php echo $tax->getIdTax(); ?>"  <?php if($tax->getIsDefault()==1){ echo "checked=\"checked\"";} ?> />
                                            <?php echo $tax->getName(); ?>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <span class="help-block"> Cocher la ou les taxe(s) affiliée(s) au client </span>
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
