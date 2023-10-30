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
                                        $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH);
                                        $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                ?>
                                        <label class="checkbox-inline">
                                <?php
                                        echo'<input type="checkbox" id="case[]" name="case[]" value="'.$company->getIdCompany().'" />';
                                ?>
                                            <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/></a>
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
                                <input name="account" id="account" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group" id="hidden_fields">
                            <label class="control-label col-md-3">Sous-compte associé au client
                                <span class="required"> * </span>
                            </label>
                            <?php
                            foreach ($companies as $company)
                            {
                                ?>
                                <div class="form-row col-md-1" id="subaccount[<?php echo $company->getIdCompany(); ?>]">
                                    <?php
                                    echo '<input type="text" class="form-control" placeholder="'.$company->getNameData().'"  name="subaccount['.$company->getIdCompany().']">';
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
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
                                <div id="tax_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Modalité de facturation
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="radio-list" data-error-container="#modalite_error">
                                    <label class="radio-inline">
                                        <input type="radio" id="modalite" name="modalite" value="IMME"/> Comptant immédiat
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" id="modalite" name="modalite" value="30JF"/> 30 jour fin de mois
                                    </label>
                                </div>
                                <span class="help-block"> Cocher la modalité de facturation du client </span>
                                <div id="modalite_error"> </div>
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

<!--<script type="text/javascript">
    $(function() {

        // Get the form fields and hidden div
        var checkbox = $("#case[]");
        var hidden = $("#hidden_fields");

        // Hide the fields.
        // Use JS to do this in case the user doesn't have JS
        // enabled.
        hidden.hide();

        // Setup an event listener for when the state of the
        // checkbox changes.
        checkbox.change(function() {
            // Check to see if the checkbox is checked.
            // If it is, show the fields and populate the input.
            // If not, hide the fields.
            if (checkbox.is(':checked')) {
                // Show the hidden fields.
                hidden.show();
            } else {
                // Make sure that the hidden fields are indeed
                // hidden.
                hidden.hide();

                // You may also want to clear the value of the
                // hidden fields here. Just in case somebody
                // shows the fields, enters data to them and then
                // unticks the checkbox.
                //
                // This would do the job:
                //
                // $("#hidden_field").val("");
            }
        });
    });
</script>-->
