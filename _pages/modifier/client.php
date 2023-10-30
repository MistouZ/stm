<?php

$customerId = $_GET['soussouscat'];

//récupération de la liste des sociétés
$arrayCompanies = array();
$company = new Company($arrayCompanies);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

//Récupération des données client
$arrayClient = array();
$customer = new Customers($arrayClient);
$customermanager = new CustomersManager($bdd);
$customer = $customermanager->getByID($customerId);

//récupération des contacts du client
$arrayContact = array();
$contacts = new Contact($arrayContact);
$contactmanager = new ContactManager($bdd);
$contactmanager = $contactmanager->getList($customerId);

//récupération de la liste des taxes
$array = array();
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$taxmanager = $taxmanager->getList();

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Modification du client <span style="font-style: italic; font-weight: 800;"><?php echo $company->getName(); ?></span></span>
                </div>
            </div>
            <div class="portlet-body form">
                <form action="<?php echo URLHOST."_pages/_post/modifier_client.php"; ?>" method="post" id="form_sample_2" class="form-horizontal">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Vous devez remplir les champs requis (<span class="required"> * </span>) </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Les modifications ont bien été prises en compte </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom du client
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="name" value="<?php echo $customer->getName(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse physique
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="physical_address" id="physical_address" value="<?php echo $customer->getPhysicalAddress(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse de facturation
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="invoice_address" id="invoice_address" value="<?php echo $customer->getInvoiceAddress(); ?>" /> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#company_error">
                                <?php
                                    $companiesList = explode(", ",$customer->getCompanyName());
    
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
                            <label class="control-label col-md-3">Compte associé au client
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="account" id="account" type="text" class="form-control" value="<?php echo $customer->getAccount(); ?>" />
                            </div>
                        </div>
                        <div class="form-group" id="hidden_fields">
                            <label class="control-label col-md-3">Sous-compte associé au client
                                <span class="required"> * </span>
                            </label>
                            <?php
                                /*récupération des sous comptes du client par société */
                                $subaccountsList = explode(", ",$customer->getSubaccount());
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
                        <div class="form-group">
                            <label class="control-label col-md-3">Taxes
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#tax_error">
                                    <?php
    
                                    $taxList = new TaxManager($bdd);
                                    $taxList = $taxList->getListByCustomer($customer->getIdCustomer());
    
                                    foreach ($taxmanager as $tax)
                                    {
                                        ?>
                                        <label class="checkbox-inline">
                                            <?php
                                            echo'<input type="checkbox" id="taxes[]" name="taxes[]" value="'.$tax->getIdTax().'" ';
                                            if(in_array($tax,$taxList)){ echo "checked=\"checked\""; }
                                            echo '/>';
                                            echo $tax->getName();
                                            ?>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <span class="help-block">Cocher la ou les taxe(s) affiliée(s) au client </span>
                                <div id="company_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Taxes
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="radio-list" data-error-container="#modalite_error">
                                    <label class="radio-inline">
                                        <?php
                                            echo'<input type="radio" id="modalite" name="modalite" value="30JF" ';
                                            if($customer->getModalite() == "30JF"){ echo "checked=\"checked\""; }
                                            echo '/> 30 jours fin de mois';
                                        ?>
                                    </label>
                                    <label class="radio-inline">
                                        <?php
                                            echo'<input type="radio" id="modalite" name="modalite" value="IMME" ';
                                            if($customer->getModalite() == "IMME"){ echo "checked=\"checked\""; }
                                            echo '/> Comptant immédiat';
                                        ?>
                                    </label>
                                </div>
                                <span class="help-block">Cocher la modalité du client </span>
                                <div id="modalite_error"> </div>
                            </div>
                        </div>
                        <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId; ?>">
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