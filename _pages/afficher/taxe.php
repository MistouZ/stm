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
?>
<div class="portlet box grey-cascade">
    <div class="portlet-title">
        <div class="caption">
            <i class="fas fa-user-tie"></i>Informations du client <span style="font-style: italic; font-weight: 800;"><?php echo $customer->getName(); ?></span></div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="javascript:;" class="reload"> </a>
        </div>
        <div class="actions">
            <a data-toggle="modal" href="#modifier_client" class="btn btn-default btn-sm">
                <i class="fa fa-pencil"></i> Modifier le client </a>
        </div>
    </div>
    <div class="portlet-body">
       <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <ul class="ver-inline-menu tabbable margin-bottom-10">
                    <li class="active">
                        <a href="#tab_6_1" data-toggle="tab"><i class="fas fa-info-circle"></i> Global </a>
                    </li>
                    <li>
                        <a href="#tab_6_2" data-toggle="tab"><i class="fas fa-address-card"></i> Contacts </a>
                    </li>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_6_1">
                        <div class="row static-info">
                            <div class="col-md-5 name"> Nom: </div>
                            <div class="col-md-7 value"> <?php echo $customer->getName(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Adresse physique: </div>
                            <div class="col-md-7 value"> <?php echo $customer->getPhysicalAddress(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Adresse de facturation: </div>
                            <div class="col-md-7 value"> <?php echo $customer->getInvoiceAddress(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Société(s) affilée(s): </div>
                            <div class="col-md-7 value"> <?php echo $customer->getCompanyName(); ?> </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab_6_2">
                        <div class="actions">
                            <a data-toggle="modal" href="#creer_contact" class="btn btn-default btn-sm grey-mint">
                                <i class="fas fa-plus"></i> Nouv. Contact </a>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="all">Nom</th>
                                    <th class="none">Mail</th>
                                    <th class="none">Téléphone</th>
                                    <th class="min-phone-l">Modifier</th>
                                    <th class="min-tablet">Suprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($contactmanager as $contact) {
                            ?>
                                <tr>
                                    <td><?php echo $contact->getName()." ".$contact->getFirstname(); ?></td>
                                    <td><?php echo $contact->getEmailAddress(); ?></td>
                                    <td><?php echo $contact->getPhoneNumber(); ?></td>
                                    <td><a href="<?php echo URLHOST.$_COOKIE['company'].'/contact/modifier/'.$contact->getIdContact(); ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
                                    <td><a href="<?php echo URLHOST.$_COOKIE['company'].'/contact/supprimer/'.$contact->getIdContact(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i></a></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="creer_contact" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Création d'un contact</h4>
                    </div>
                    <div class="modal-body form">
                        <form action="<?php echo URLHOST."_pages/_post/creer_contact.php"; ?>" method="post" id="form_sample_2" class="form-horizontal form-row-seperated">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nom
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" data-required="1" class="form-control" name="name" /> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Prénom
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" data-required="1" class="form-control" name="firstname" /> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Email
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="email" class="form-control" name="emailAddress" /> </div>
                                </div>
                            </div>
                            <div class="form-group last">
                                <label class="control-label col-md-4">Téléphone
                                </label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" name="phoneNumber" />
                                </div>
                            </div>
                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId; ?>">
                            <div class="modal-footer">
                                <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn green" name="valider">
                                    <i class="fa fa-check"></i> Valider</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div id="modifier_client" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modification du client</h4>
                    </div>
                    <div class="modal-body form">
                        <form action="<?php echo URLHOST."_pages/_post/modifier_client.php"; ?>" method="post" id="form_sample_2" class="form-horizontal form-row-seperated">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button> Vous devez remplir les champs requis (<span class="required"> * </span>) </div>
                            <div class="alert alert-success display-hide">
                                <button class="close" data-close="alert"></button> Les modifications ont bien été prises en compte </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Nom du client
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" data-required="1" class="form-control" name="name" value="<?php echo $customer->getName(); ?>" /> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Adresse physique
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" data-required="1" class="form-control" name="physical_address" id="physical_address" value="<?php echo $customer->getPhysicalAddress(); ?>" /> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Adresse de facturation
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" data-required="1" class="form-control" name="invoice_address" id="invoice_address" value="<?php echo $customer->getInvoiceAddress(); ?>" /> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Fournisseur
                                </label>
                                <div class="col-md-8">
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
                                        $companiesList = explode(", ",$customer->getCompanyName());
                                        
                                        foreach ($companies as $company)
                                        {
                                    ?>
                                            <label class="checkbox-inline">
                                    <?php
                                            echo'<input type="checkbox" id="case[]" name="case[]" value="'.$company->getIdCompany().'" ';
                                            if(in_array($company->getName(),$companiesList)){ echo "checked=\"checked\""; }
                                            echo '/>';
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
                            <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId; ?>">
                            <div class="modal-footer">
                                <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn green" name="valider">
                                    <i class="fa fa-check"></i> Valider</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>