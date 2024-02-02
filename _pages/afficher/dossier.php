<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
require_once("_cfg/cfg.php");

$array = array();
$companyNameData = $_GET["section"];

$folderId = $_GET['soussouscat'];

$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$quotation = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$cost = new Cost($array);
$costManager = new CostManager($bdd);
$supplier = new Suppliers($array);
$suppliermanager = new SuppliersManager($bdd);

$folder = $foldermanager->get($folderId);

$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();
$user = $usermanager->get($folder->getSeller());
$customer = $customermanager->getById($folder->getCustomerId());
$contact = $contactmanager->getById($folder->getContactId());
$quotations = $quotationmanager->getByFolderId($folderId);
$costs = $costManager->getByFolderId($folderId);

$date = date('d/m/Y',strtotime(str_replace('/','-',"".$folder->getDate()."")));

if(isset($_GET['cat5'])){
    $retour = $_GET['cat5'];
}

switch($type){
    case "devis":
        $entete = "du devis";
        $enteteIcon = '<i class="fas fa-file-invoice"></i>';
        break;
    case "proforma":
        $entete = "de la proforma";
        $enteteIcon = '<i class="fas fa-file-alt"></i>';
        break;
    case "facture":
        $entete = "de la facture";
        $enteteIcon = '<i class="fas fa-file-invoice-dollar"></i>';
        break;
    case "avoir":
        $entete = "de l'avoir";
        $enteteIcon = '<i class="fas fa-file-prescription"></i>';
        break;
}


?>
<div class="row">
    <div class="col-md-12">
        <?php if($retour == "error") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Une erreur est survenue, le devis n'a donc pas pu être être mis à jour !</div>
        <?php }elseif($retour == "success"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> Le dossier a bien été mis à jour !</div>
        <?php }elseif($retour == "errorDate") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Une erreur est survenue, la date n'a donc pas pu être mise à jour !</div>
        <?php }elseif($retour == "successDate"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> La date a bien été modifiée !</div>
        <?php } ?>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="portlet yellow-crusta box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fas fa-info"></i>Informations</div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-5 name"> Dossier N°: </div>
                            <div class="col-md-7 value"><?php echo $folder->getFolderNumber(); ?></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Date: </div>
                            <div class="col-md-7 value"> <?php echo $date; ?> <a data-toggle="modal" href="#modif_date" ><i class="fas fa-edit"></i></a></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Libellé : </div>
                            <div class="col-md-7 value"> <?php echo $folder->getLabel(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Commercial : </div>
                            <div class="col-md-7 value"> <?php echo $user->getName().' '.$user->getFirstName(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name">&nbsp;</div>
                            <div class="col-md-7 value">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="portlet blue-hoki box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fas fa-user-tie"></i>Informations client </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-5 name"> Client: </div>
                            <div class="col-md-7 value"> <?php echo $customer->getName(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Adresse: </div>
                            <div class="col-md-7 value"> <?php echo $customer->getInvoiceAddress(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Contact: </div>
                            <div class="col-md-7 value"> <?php echo $contact->getFirstname()." ".$contact->getName(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Téléphone: </div>
                            <div class="col-md-7 value"> <?php echo $contact->getPhoneNumber(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Mail: </div>
                            <div class="col-md-7 value"> <?php echo $contact->getEmailAddress(); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-invoice"></i>Liste des Devis  </div>
                <div class="tools">
                    <a href="" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: none;">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro de devis</th>
                            <th class="desktop">Montant total</th>
                            <th class="desktop">Détail</th>
                            <th class="desktop">Modifier</th>
                            <th class="desktop">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($quotations as $quotation){
                            if($quotation->getType() == "D") {
                                $type = "devis";
                                if($quotation->getStatus() == "En cours"){
                                    $type2 = "cours";
                                }
                                else{
                                    $type2=$quotation->getStatus();
                                }
                            //initialisation au format date pour organiser le tableau
                            $date = date('d/m/y', strtotime( $quotation->getDate()));
                            $descriptions = new Description($array);
                            $descriptionmanager = new DescriptionManager($bdd);
                            $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
                            $montant = 0;
                            foreach($descriptions as $description){
                                $montant = calculMontantTotalTTC($description, $montant);
                            }
                            ?>
                            <tr>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                <td><?php echo number_format($montant, 0, ",", " "); ?> XPF</td>
                                <td><a class="btn green-meadow"
                                       href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/afficher/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i
                                                class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                <td><a class="btn blue-steel"
                                       href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/modifier/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i
                                                class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation"
                                       data-title="Supprimer le devis n° <?php echo $quotation->getQuotationNumber(); ?> ?"
                                       data-content="ATTENTION ! La suppression est irréversible !"
                                       data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success"
                                       data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger"
                                       data-href="<?php echo URLHOST . '_pages/_post/supprimer_devis.php?idQuotation=' . $quotation->getIdQuotation() . '&quotationNumber=' . $quotation->getQuotationNumber(); ?>"><i
                                                class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                            </tr>
                            <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-alt"></i>Liste des Proformas  </div>
                <div class="tools">
                    <a href="" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: none;">
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro de proforma</th>
                            <th class="desktop">Montant total</th>
                            <th class="desktop">Détail</th>
                            <!--<th class="desktop">Modifier</th>-->
                            <th class="desktop">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($quotations as $quotation){
                            if($quotation->getType() == "P") {
                                $type = "proforma";
                                if($quotation->getStatus() == "En cours"){
                                    $type2 = "cours";
                                }
                                else{
                                    $type2=$quotation->getStatus();
                                }
                            //initialisation au format date pour organiser le tableau
                            $date = date('d/m/Y',strtotime(str_replace('/','-',"".$quotation->getDate()."")));
                            $descriptions = new Description($array);
                            $descriptionmanager = new DescriptionManager($bdd);
                            $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
                            $montant = 0;
                            foreach($descriptions as $description){
                                $montant = calculMontantTotalTTC($description, $montant);
                            }

                                ?>
                                <tr>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                    <td><?php echo number_format($montant, 0, ",", " "); ?> XPF</td>
                                    <td><a class="btn green-meadow"
                                           href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/afficher/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                    <!--<td><a class="btn blue-steel"
                                           href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/modifier/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-edit" alt="Editer"></i> Modifier</a></td>-->
                                    <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation"
                                           data-title="Supprimer la proforma n° <?php echo $quotation->getQuotationNumber(); ?> ?"
                                           data-content="ATTENTION ! La suppression est irréversible !"
                                           data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success"
                                           data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger"
                                           data-href="<?php echo URLHOST.'_pages/_post/supprimer_devis.php?idQuotation='.$quotation->getIdQuotation().'&quotationNumber='.$quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-invoice-dollar"></i>Liste des Factures
                </div>
                <div class="tools">
                    <a href="" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: none;">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro de facture</th>
                            <th class="desktop">Montant total</th>
                            <th class="desktop">Détail</th>
                            <th class="desktop">Modifier</th>
                            <th class="desktop">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($quotations as $quotation){
                            if($quotation->getType() == "F") {
                                $type = "facture";
                                if($quotation->getStatus() == "En cours"){
                                    $type2 = "cours";
                                }
                                else{
                                    $type2=$quotation->getStatus();
                                }
                            //initialisation au format date pour organiser le tableau
                            $date = date('d/m/Y',strtotime(str_replace('/','-',"".$quotation->getDate()."")));
                            $descriptions = new Description($array);
                            $descriptionmanager = new DescriptionManager($bdd);
                            $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
                            $montant = 0;
                            foreach($descriptions as $description){
                                $montant = calculMontantTotalTTC($description, $montant);
                            }

                                ?>
                                <tr>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                    <td><?php echo number_format($montant, 0, ",", " "); ?> XPF</td>
                                    <td><a class="btn green-meadow"
                                           href="<?php echo URLHOST . $_COOKIE['company'].'/'.$type.'/afficher/'.$type2.'/'. $quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                    <td><a class="btn blue-steel"
                                           href="<?php echo URLHOST . $_COOKIE['company'].'/'.$type.'/modifier/'.$type2.'/'. $quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                    <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation"
                                           data-title="Supprimer la facture n° <?php echo $quotation->getQuotationNumber(); ?> ?"
                                           data-content="ATTENTION ! La suppression est irréversible !"
                                           data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success"
                                           data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger"
                                           data-href="<?php echo URLHOST.'_pages/_post/supprimer_devis.php?idQuotation='.$quotation->getIdQuotation().'&quotationNumber='.$quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-prescription"></i>Liste des Avoirs
                </div>
                <div class="tools">
                    <a href="" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: none;">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro d'avoir</th>
                            <th class="desktop">Montant total</th>
                            <th class="desktop">Détail</th>
                            <th class="desktop">Modifier</th>
                            <th class="desktop">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($quotations as $quotation){
                            if($quotation->getType() == "A") {
                                $type = "avoir";
                                if($quotation->getStatus() == "En cours"){
                                    $type2 = "cours";
                                }
                                else{
                                    $type2=$quotation->getStatus();
                                }
                                //initialisation au format date pour organiser le tableau
                                $date = date('d/m/Y',strtotime(str_replace('/','-',"".$quotation->getDate()."")));
                                $descriptions = new Description($array);
                                $descriptionmanager = new DescriptionManager($bdd);
                                $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
                                $montant = 0;
                                foreach($descriptions as $description){
                                    $montant = calculMontantTotalTTC($description, $montant);
                                }

                                ?>
                                <tr>
                                    <td><?php echo $date; ?></td>
                                    <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                    <td><?php echo number_format($montant, 0, ",", " "); ?> XPF</td>
                                    <td><a class="btn green-meadow"
                                           href="<?php echo URLHOST . $_COOKIE['company'].'/'.$type.'/afficher/'.$type2.'/'. $quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                    <td><a class="btn blue-steel"
                                           href="<?php echo URLHOST . $_COOKIE['company'].'/'.$type.'/modifier/'.$type2.'/'. $quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                    <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation"
                                           data-title="Supprimer l'avoir' n° <?php echo $quotation->getQuotationNumber(); ?> ?"
                                           data-content="ATTENTION ! La suppression est irréversible !"
                                           data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success"
                                           data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger"
                                           data-href="<?php echo URLHOST.'_pages/_post/supprimer_devis.php?idQuotation='.$quotation->getIdQuotation().'&quotationNumber='.$quotation->getQuotationNumber(); ?>"><i
                                                    class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="portlet box red-flamingo">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-hand-holding-usd"></i>Liste des Coûts
                </div>
                <div class="tools">
                    <a href="" class="expand" data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body" style="display: none;">
                <form id="multiSelection" method="post">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="all">Fournisseur</th>
                            <th class="none">Description</th>
                            <th class="desktop">Montant total</th>
                            <th class="desktop">Modifier</th>
                            <th class="desktop">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($costs as $cost){

                                //initialisation au format date pour organiser le tableau
                                $cout = 0;
                                $cout = calculCoutTotal($cost, $cout);
                                $supplier = $suppliermanager->getByID($cost->getSupplierId())
                                ?>
                                <tr>
                                    <td><?php echo $supplier->getName(); ?></td>
                                    <td><?php echo $cost->getDescription(); ?></td>
                                    <td><?php echo number_format($cout, 0, ",", " "); ?> XPF</td>
                                    <td><a class="btn blue-steel"
                                           href="<?php echo URLHOST . $_COOKIE['company'].'/cout/modifier/'.$cost->getFolderId().'/'.$cost->getIdCost(); ?>"><i
                                                    class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                    <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation"
                                           data-title="Supprimer le cout lié au devis n° <?php echo $cost->getQuotationNumber(); ?> ?"
                                           data-content="ATTENTION ! La suppression est irréversible !"
                                           data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success"
                                           data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger"
                                           data-href="<?php echo URLHOST.'_pages/_post/supprimer_cout.php?folderId='.$cost->getFolderId().'&costId='.$cost->getIdCost(); ?>"><i
                                                    class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="date" id="date" />
                </form>
            </div>
        </div>
    </div>
    <form action="<?php echo URLHOST.$_COOKIE['company']."/dossier/imprimer/".$folder->getIdFolder(); ?>" target="_blank" method="post" class="form-horizontal form-row-seperated">
        <div class="modal-footer">
            <button type="button" class="btn grey-salsa btn-outline" onclick="history.back()" >Fermer</button>
            <button type="submit" class="btn green" name="imprimer">
                <i class="fas fa-print"></i> Imprimer page de garde</button>
        </div>
    </form>
</div>
