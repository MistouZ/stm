<?php

$supplierId = $_GET['soussouscat'];

//récupération de la liste des sociétés
$arrayCompanies = array();
$company = new Company($arrayCompanies);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

//Récupération des données fournisseur
$arraySupplier = array();
$supplier = new Suppliers($arraySupplier);
$suppliermanager = new SuppliersManager($bdd);
$supplier = $suppliermanager->getByID($supplierId);

//récupération des contacts du fournisseur
$arrayContact = array();
$contacts = new Contact($arrayContact);
$contactmanager = new ContactManager($bdd);
$contactmanager = $contactmanager->getList($supplierId);


?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Modification du fournisseur <span style="font-style: italic; font-weight: 800;"><?php echo $supplier->getName(); ?></span></span>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="<?php echo URLHOST."_pages/_post/modifier_fournisseur.php"; ?>" method="post" id="form_sample_2" class="form-horizontal">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Vous devez remplir les champs requis (<span class="required"> * </span>) </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Les modifications ont bien été prises en compte </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom du fournisseur
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="name" value="<?php echo $supplier->getName(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse physique
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="physical_address" id="physical_address" value="<?php echo $supplier->getPhysicalAddress(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse de facturation
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="invoice_address" id="invoice_address" value="<?php echo $supplier->getInvoiceAddress(); ?>" /> </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#company_error">
                                <?php
                                    $companiesList = explode(", ",$supplier->getCompanyName());
    
                                    foreach ($companies as $company)
                                    {
                                ?>
                                        <label class="checkbox-inline">
                                <?php
                                        echo'<input type="checkbox" id="case[]" name="case[]" value="'.$company->getIdCompany().'" ';
                                        if(in_array($company->getName(),$companiesList)){ echo "checked=\"checked\""; }
                                        echo '/>';
                                        
                                        $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                        $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
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
                            <label class="control-label col-md-3">Compte associé au fournisseur
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="account" id="account" type="text" class="form-control" value="<?php echo $supplier->getAccount(); ?>" />
                            </div>
                        </div>
                        <div class="form-group" id="hidden_fields">
                            <label class="control-label col-md-3">Sous-compte associé au fournisseur
                                <span class="required"> * </span>
                            </label>
                            <?php
                                /*récupération des sous comptes du client par société */
                                $subaccountsList = explode(", ",$supplier->getSubaccount());
                                $i = 0;
                                $subaccounts = array();
                                while ($i < count($subaccountsList))
                                {
                                    $subaccountsList2 = explode("_",$subaccountsList[$i] );
                                    $j = $subaccountsList2[0];
                                    $k = $subaccountsList2[1];
                                    $subaccounts[$j] = $k;
                                    $i++;
                                }

                                foreach ($companies as $company)
                                {
                                    ?>
                                    <div class="form-row col-md-1" id="subaccount[<?php echo $company->getIdCompany(); ?>]">
                                        <?php
                                        echo '<input type="text" class="form-control" placeholder="'.$company->getNameData().'"  name="subaccount['.$company->getIdCompany().']" value="'.$subaccounts[$company->getIdCompany()].'">';
                                        ?>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <input type="hidden" id="supplierId" name="supplierId" value="<?php echo $supplierId; ?>">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="valider" id="valider" class="btn green">Valider</button>
                                    <button type="button" class="btn default">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>