<?php

$contactId = $_GET['soussouscat'];

//récupération de la liste des sociétés
$arrayCompanies = array();
$company = new Company($arrayCompanies);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

//récupération des contacts du client
$arrayContact = array();
$contact = new Contact($arrayContact);
$contactmanager = new ContactManager($bdd);
$contact = $contactmanager->getById($contactId);

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Modification du contact <span style="font-style: italic; font-weight: 800;"><?php echo $contact->getName()." ".$contact->getFirstname(); ?></span></span>
                </div>
            </div>
            <div id="modif_contact" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Création d'un contact</h4>
                        </div>
                        <div class="modal-body form">
                            <form action="<?php echo URLHOST."_pages/_post/modifier_contact.php"; ?>" method="post" id="form_sample_2" class="form-horizontal form-row-seperated">
                                <div class="form-group">
                                    <label class="control-label col-md-4">Nom
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fas"></i>
                                            <input type="text" data-required="1" class="form-control" name="name" value="<?php echo $contact->getName();?>"/> </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Prénom
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fas"></i>
                                            <input type="text" data-required="1" class="form-control" name="firstname" value="<?php echo $contact->getFirstname();?>"/> </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Email
                                    </label>
                                    <div class="col-md-8">
                                        <div class="input-icon right">
                                            <i class="fas"></i>
                                            <input type="email" class="form-control" name="emailAddress" value="<?php echo $contact->getEmailAddress();?>"/> </div>
                                    </div>
                                </div>
                                <div class="form-group last">
                                    <label class="control-label col-md-4">Téléphone
                                    </label>
                                    <div class="col-md-8">
                                        <input type="number" class="form-control" name="phoneNumber" value="<?php echo $contact->getPhoneNumber();?>"/>
                                    </div>
                                </div>
                                <input type="hidden" id="customerId" name="customerId" value="<?php echo $contactId; ?>">
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
</div>