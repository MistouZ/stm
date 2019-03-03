<?php

$contactId = $_GET['cat6'];

//récupération du contact à modifier du client
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
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/modifier_contact.php"; ?>" method="post" id="form_sample_2" name="form_sample_2" class="form-horizontal">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Le dossier a bien été créé </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="name" value="<?php echo $contact->getName();?>"/> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Prénom
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="text" data-required="1" class="form-control" name="firstname" value="<?php echo $contact->getFirstname();?>"/> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fas"></i>
                                    <input type="email" class="form-control" name="emailAddress" value="<?php echo $contact->getEmailAddress();?>"/> </div>
                            </div>
                        </div>
                        <div class="form-group last">
                            <label class="control-label col-md-3">Téléphone
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="phoneNumber" value="<?php echo $contact->getPhoneNumber();?>"/>
                            </div>
                        </div>
                        <input type="hidden" id="contactId" name="contactId" value="<?php echo $contactId; ?>">
                        <input type="hidden" id="customerId" name="customerId" value="<?php echo $_GET['soussouscat'];?>">
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