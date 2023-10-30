<?php

$customerId = $_GET['soussouscat'];
$retour = $_GET['soussoussouscat'];

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
<div class="portlet box grey-cascade">
    <div class="portlet-title">
        <div class="caption">
            <i class="fas fa-user-tie"></i>Informations du client <span style="font-style: italic; font-weight: 800;"><?php echo $customer->getName(); ?></span></div>
        <div class="tools">
            <a href="javascript:;" class="collapse"> </a>
            <a href="javascript:;" class="reload"> </a>
        </div>
        <div class="actions">
            <a data-toggle="modal" href="#modifier_client" class="btn btn-sm grey-mint">
                <i class="fas fa-pencil-alt"></i> Modifier le client </a>
        </div>
    </div>
    <div class="portlet-body">
       <div class="row">
            <div class="col-md-12">
                <?php if($retour == "existe"){ ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Le contact existe déjà !</div>
                <?php }elseif($retour == "supprime"){?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Le contact a bien été supprimé !</div>
                <?php }elseif($retour == "ajout"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le contact a bien été créé !</div>
                <?php }elseif($retour == "update"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le contact a bien été mis à jour !</div>
                <?php }elseif($retour == "errormodif") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le client n'a donc pas pu être modifié !</div>
                <?php }elseif($retour == "successmodif"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le client a bien été modifié !</div>
                <?php } ?>
                <div class="panel-group accordion scrollable" id="accordion2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_1"><i class="fas fa-info-circle"></i> Informations globales </a>
                            </h4>
                        </div>
                        <div id="collapse_2_1" class="panel-collapse in">
                            <div class="panel-body">
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
                                    <div class="col-md-7 value">
                                    <?php
                                        $companiesList = explode(", ",$customer->getCompanyName());
                                        foreach ($companies as $company)
                                        {
                                            $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                            $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                            if(in_array($company->getName(),$companiesList)){
                                    ?>
                                        <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/>
                                    <?php
                                        }}
                                    ?>
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Compte associé au client </div>
                                    <div class="col-md-7 value">
                                        <?php echo $customer->getAccount(); ?>
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Sous-compte associé au client </div>
                                    <div class="col-md-7 value">
                                        <div class="col-md-12">
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
                                                    <div class="row static-info" style="border-bottom: 1px solid grey;">
                                                        <div class="col-md-5 name"><?php echo strtoupper($company->getNameData()); ?> : </div>
                                                        <div class="col-md-7 value">
                                                            <?php
                                                                echo $subaccounts[$company->getIdCompany()];
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Modalité de facturation: </div>
                                    <div class="col-md-7 value"> 
                                        <?php 
                                            if($customer->getModalite() == "30JF") {
                                                echo "30 jours fin de mois";
                                            }else {
                                                echo "Comptant immédiat";
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2_2"><i class="fas fa-address-card"></i> Liste des contacts du clients </a>
                            </h4>
                        </div>
                        <div id="collapse_2_2" class="panel-collapse collapse">
                            <div class="panel-body">
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
                                            <th class="min-phone-l">Modifier</th>
                                            <th class="min-tablet">Suprimer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($contactmanager as $contact) {
                                    ?>
                                        <tr>
                                            <td><?php echo $contact->getFirstname()." ".$contact->getName(); ?></td>
                                            <td><?php echo $contact->getEmailAddress(); ?></td>
                                            <td><?php echo $contact->getPhoneNumber(); ?></td>
                                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/client/afficher/'.$customerId.'/contact/modifier/'.$contact->getIdContact(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                            <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le contact <?php echo $contact->getName().' '.$contact->getFirstName(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo  URLHOST."_pages/_post/supprimer_contact.php?idContact=".$contact->getIdContact()."&idCustomer=".$customer->getIdCustomer(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td></td>
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
                        <!-- Form validation depuis el fichier : _ressources/_inc/pages/scripts/form-validation handleValidationCon(); -->
                        <form action="<?php echo URLHOST."_pages/_post/creer_contact.php"; ?>" method="post" id="form_contact" class="form-horizontal form-row-seperated">
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
                                        <input type="text" class="form-control" name="emailAddress" /> </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">Téléphone
                                </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <i class="fas"></i>
                                        <input type="text" class="form-control" name="phoneNumber" /></div>
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
                        <form action="<?php echo URLHOST."_pages/_post/modifier_client.php"; ?>" method="post" id="client" class="form-horizontal form-row-seperated">
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
                                        <div class="form-row col-md-2" id="subaccount[<?php echo $company->getIdCompany(); ?>]">
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
                                    <div id="tax_error"> </div>
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
                                                echo'<input type="radio" name="modalite" value="30JF" ';
                                                if($customer->getModalite() == "30JF"){ echo "checked=\"checked\""; }
                                                echo '/> 30 jours fin de mois';
                                            ?>
                                        </label>
                                        <label class="radio-inline">
                                            <?php    
                                                echo'<input type="radio" name="modalite" value="IMME" ';
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