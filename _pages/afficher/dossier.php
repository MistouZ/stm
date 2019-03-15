<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

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

$folder = $foldermanager->get($folderId);

$company = $companymanager->getByNameData($companyNameData);
$user = $usermanager->get($folder->getSeller());
$customer = $customermanager->getById($folder->getCustomerId());
$contact = $contactmanager->getById($folder->getContactId());
$quotationmanager = $quotationmanager->getByFolderId($folderId);

$date = date('d/m/Y',strtotime(str_replace('/','-',"".$folder->getDay().'/'.$folder->getMonth().'/'.$folder->getYear()."")));

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
                <button class="close" data-close="alert"></button> Le devis a bien été mis à jour !</div>
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
        <div id="modif_date" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modifier la date <?php echo $entete; ?> <span style="font-style: italic; font-weight: 800;"><?php echo $quotation->getQuotationNumber(); ?></span></h4>
                    </div>
                    <div class="modal-body form">
                        <form action="<?php echo URLHOST."_pages/_post/modifier_date.php"; ?>" method="post" id="to_proforma" class="form-horizontal form-row-seperated">
                            <div class="form-group">
                                <label class="control-label col-md-4">Date
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-8">
                                    <div class="input-group input-medium date date-picker"  data-date-lang="FR-fr" type="text">
                                        <input type="text" name="date" class="form-control" value="<?php echo $date; ?>" >
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <span class="help-block">Cliquez sur la date pour la modifier</span>
                                </div>
                            </div>
                            <input type="hidden" id="quotationNumber" name="quotationNumber" value="<?php echo $quotation->getQuotationNumber(); ?>">
                            <input type="hidden" id="type" name="type" value="<?php echo $type2; ?>">
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
