<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/02/2019
 * Time: 09:12
 */

$customerId = $_GET['souscat'];

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
                        <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="all">Nom</th>
                                    <th class="none">Mail</th>
                                    <th class="none">Téléphone</th>
                                    <th class="min-phone-l">Afficher</th>
                                    <th class="min-tablet">Modifier</th>
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
                                    <td><a href="<?php echo URLHOST.'contact/afficher/'.$contact->getIdContact(); ?>"><i class="fas fa-eye" alt="Détail"></i></a></td>
                                    <td><a href="<?php echo URLHOST.'contact/modifier/'.$contact->getIdContact(); ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
                                    <td><a href="<?php echo URLHOST.'contact/supprimer/'.$contact->getIdContact(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i></a></td>
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
                                        <input type="text" class="form-control" name="name" /> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Prénom
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" class="form-control" name="firstname" /> </div>
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
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" class="form-control" name="phoneNumber" /> </div>
                                        <input type="hidden" id="customerId" name="customerId" value="<?php echo $customerId; ?>">
                                </div>
                            </div>
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