<?php

$customerId = $_GET['souscat'];

//Récupération des données client
$arrayClient = array();
$customer = new Customers($arrayClient);
$customermanager = new CustomersManager($bdd);
$customer = $customermanager->getByID($customerId);

//récupération des contacts du client
/*$arrayContact = array();
$contacts = new Contact($arrayContact);
$contactmanager = new ContactManager($bdd);
$contacts = $contactmanager->getList();*/
?>
<div class="portlet box grey-cascade">
    <div class="portlet-title">
        <div class="caption">
            <i class="fas fa-user-tie"></i>Informations client</div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="javascript:;" class="reload"> </a>
        </div>
        <div class="actions">
            <a data-toggle="modal" href="#modifier" class="btn btn-default btn-sm">
                <i class="fa fa-pencil"></i> Modifier </a>
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
                    </div>
                    <div class="tab-pane fade" id="tab_6_2">
                        <div class="actions">
                            <a data-toggle="modal" href="#creer_contact" class="btn btn-default btn-sm grey-mint">
                                <i class="fas fa-plus"></i> Nouv. Contact </a>
                        </div>
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="all">Nom</th>
                                    <th class="none">Mail</th>
                                    <th class="none">Téléphone</th>
                                    <th class="min-phone-l">Afficher</th>
                                    <th class="min-tablet">Modifier</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($contactmanager as $contact) {
                            ?>
                                <tr>
                                    <td><?php echo $contact->getName(); ?></td>
                                    <td><?php echo $contact->getEmailAddress(); ?></td>
                                    <td><?php echo $contact->getPhoneNumber(); ?></td>
                                    <td><a href="<?php echo URLHOST.'contact/afficher/'.$contact->getIdContact(); ?>"><i class="fas fa-eye" alt="Détail"></i></a></td>
                                    <td><a href="<?php echo URLHOST.'contact/modifier/'.$contact->getIdContact(); ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
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
        <div id="creer_contact" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Création d'un contact</h4>
                    </div>
                    <div class="modal-body">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 300px;"><div class="scroller" style="height: 300px; overflow: hidden; width: auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="#" class="horizontal-form">
                                    <div class="form-body">
                                        <div class="col-md-12">
                                            <div class="form-group  margin-top-20">
                                                <label class="control-label col-md-4">Nom
                                                    <span class="required"> * </span>
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right input-group">
                                                        <i class="fa"></i>
                                                        <span class="input-group-addon">
                                                            <i class="far fa-address-card"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="nom" /> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Email
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right input-group">
                                                        <i class="fa"></i>
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <input type="email" class="form-control" name="email" /> </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--/span-->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Téléphone
                                                </label>
                                                <div class="col-md-8">
                                                    <div class="input-icon right input-group">
                                                        <i class="fa"></i>
                                                        <span class="input-group-addon">
                                                            <i class="fas fa-phone"></i>
                                                        </span>
                                                        <input type="text" class="form-control" name="telephone" /> </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="form-actions right">
                                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Fermer</button>
                                        <button type="submit" class="btn blue">
                                            <i class="fa fa-check"></i> Valider</button>
                                    </div>
                                </form>
                                <!-- END FORM-->
                            </div>
                        </div><div class="slimScrollBar" style="background: rgb(187, 187, 187); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 300px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                    </div>
                    <!--<div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                        <button type="button" class="btn green">Save changes</button>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>