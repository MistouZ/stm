
<?php
/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");
$array = array();
$companyNameData = $_GET["section"];
$type = $_GET['cat'];
$type2 = $_GET['soussouscat'];
$username = $_COOKIE['username'];
$dateToProforma = date('d/m/Y');
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$quotations = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$verif= $_GET['soussoussouscat'];

if($verif != $username){
    $retour = $verif;
}
else{
    $folder2 = new Folder($array);
    $foldermanager2 = new FoldersManager($bdd);
}

switch($type){
    case "devis":
        $typeMini = 'D';
        $fa = "fas fa-file-invoice";
        if($type2=="cours"){
            if($verif == $username){
                $foldermanager2 = $foldermanager2->getListByUser($company->getIdcompany(),$username);
                $quotations = $quotationmanager->getListQuotationByFilteredFolders($foldermanager2, $folder2);
                print "company : ".$company->getIdcompany(); 
                print_r($foldermanager2);
            }
            else{
                $quotations = $quotationmanager->getListQuotation($company->getIdcompany());
            }
            $buttons = '<div id="actions" style="display:none;">
                        <a data-toggle="modal" href="#to_proforma" class="btn grey-mint btn-sm" title="Passer la sélection en proforma">
                            <i class="fas fa-file-alt"></i> => Proforma </a>
                        <a data-toggle="modal" href="#to_facture" class="btn grey-mint btn-sm" title="Passer la sélection en facture">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                    </div>';
        }
        elseif($type2=="partiels"){
            $quotations = $quotationmanager->getListShatteredQuotation($company->getIdcompany());
            $buttons = '<div id="actions" style="display:none;">
                        <a data-toggle="modal" href="#to_proforma" class="btn grey-mint btn-sm" title="Passer la sélection en proforma">
                            <i class="fas fa-file-alt"></i> => Proforma </a>
                        <a data-toggle="modal" href="#to_facture" class="btn grey-mint btn-sm" title="Passer la sélection en facture">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                    </div>';
        }
        if($type2=="archives"){
            $quotations = $quotationmanager->getListArchivedQuotation($company->getIdcompany());
            $buttons = '<div id="actions" style="display:none;">
                        <a data-toggle="modal" href="#to_proforma" class="btn grey-mint btn-sm" title="Passer la sélection en proforma">
                            <i class="fas fa-file-alt"></i> => Proforma </a>
                        <a data-toggle="modal" href="#to_facture" class="btn grey-mint btn-sm" title="Passer la sélection en facture">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                    </div>';
        }
        elseif($type2=="valides"){
            $quotations = $quotationmanager->getListValidatedQuotation($company->getIdcompany());
            $buttons = '<div id="actions" style="display:none;">
                        
                    </div>';
        }
        break;
    case "proforma":
        $typeMini = 'P';
        $fa = "fas fa-file-alt";
        $quotations = $quotationmanager->getListProforma($company->getIdcompany());
        $buttons = '<div id="actions" style="display:none;">
                        <a data-toggle="modal" href="#to_facture" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                        <a data-toggle="modal" href="#to_devis" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice"></i> => Devis </a>
                    </div>';
        break;
    case "facture":
        $fa = "fas fa-file-invoice-dollar";
        if($type2=="cours"){
            $typeMini = 'F';
            $quotations = $quotationmanager->getListInvoice($company->getIdcompany());
            $buttons = '<div id="actions" style="display:none;">
                            <a data-toggle="modal" href="#to_avoir" class="btn grey-mint btn-sm">
                                <i class="fas fa-file-prescription"></i> => Avoir </a>
                            <a data-toggle="modal" href="#to_devis" class="btn grey-mint btn-sm">
                                <i class="fas fa-file-invoice"></i> => Devis </a>
                            <a data-toggle="modal" href="#to_validate" class="btn grey-mint btn-sm">
                                <i class="fa fa-check"></i> => Valider </a>
                        </div>';
            break;
        }
        elseif($type2=="valides"){
            $typeMini = 'V';
            $quotations = $quotationmanager->getListValidatedInvoice($company->getIdcompany());
            $buttons = '<div id="actions" style="display:none;">
                            <a data-toggle="modal" href="#to_avoir" class="btn grey-mint btn-sm">
                                <i class="fas fa-file-prescription"></i> => Avoir </a>
                            <a data-toggle="modal" href="#to_devis" class="btn grey-mint btn-sm">
                                <i class="fas fa-file-invoice"></i> => Devis </a>
                        </div>';
            break;
        }

    case "avoir":
        $typeMini = 'A';
        $fa = "fas fa-file-prescription";
        $quotations = $quotationmanager->getListAsset($company->getIdcompany());
        $buttons = '<div id="actions" style="display:none;">
                        
                    </div>';
        break;
}


?>
<div class="row">
    <div class="col-md-12">
        <?php if($retour == "errorsuppr") { ?>
            <div class="alert alert-danger">
                <button class="close" onclick="window.location.href='<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/'.$type2.'/'.$quotationNumber; ?>'" data-close="alert"></button> Une erreur est survenue, le devis n'a donc pas pu être être supprimé !</div>
        <?php }elseif($retour == "successsupprdevis"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> Le devis a bien été supprimé !</div>
        <?php }elseif($retour == "successsupprproforma"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> La proforma a bien été supprimée !</div>
        <?php }elseif($retour == "successsupprfacture"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> La facture a bien été supprimée !</div>
        <?php }elseif($retour == "errorProforma") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Erreur lors du passage en proforma !</div>
        <?php }elseif($retour == "successProforma"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> Passage en proforma effectué avec succès !</div>
        <?php }elseif($retour == "errorDate") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Une erreur est survenue, la date n'a donc pas pu être mise à jour !</div>
        <?php }elseif($retour == "successDate"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> La date a bien été modifiée !</div>
        <?php }elseif($retour == "errorFacture") { ?>
            <div class="alert alert-danger">
            <button class="close" onclick="window.location.href='<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/'.$type2.'/'.$quotationNumber; ?>'" data-close="alert"></button> Erreur lors du passage en facture !</div>
        <?php }elseif($retour == "successFacture"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> Passage en facture effectué avec succès !</div>
        <?php }elseif($retour == "errorDevis") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Erreur lors du passage en devis !</div>
        <?php }elseif($retour == "successDevis"){ ?>
            <div class="alert alert-success">
            <button class="close" onclick="window.location.href='<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/'.$type2.'/'.$quotationNumber; ?>'" data-close="alert"></button> Passage en devis effectué avec succès !</div>
        <?php } ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="<?php print $fa; ?>"></i>Liste des <?php print ucwords($_GET['cat']); if($_GET['cat'] != "devis"){echo "s";}?>  </div>
                <div class="actions">
                    <a data-toggle="modal" href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/cours/'.$username; ?>" class="btn btn-sm grey-salsa">
                        <i class="far fa-list-alt"></i> Voir mes devis</a>
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/creer'; ?>" class="btn btn-sm grey-mint">
                        <i class="fa fa-plus"></i> Créer un devis</a>
                    <?php echo $buttons; ?>
                </div>
            </div>
            <div class="portlet-body">
                <form id="multiSelection" method="post">
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="text-align: center !important;" class="desktop"><input id="select-all" type="checkbox" title="Sélectionner / Désélectionner tout" /></th>
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro de <?php echo $type; ?></th>
                            <th class="min-tablet">Client</th>
                            <th class="desktop">Dossier</th>
                            <th class="desktop">Libellé</th>
                            <th class="none">Montant total</th>
                            <th class="desktop">Détail</th>
                            <?php if($_GET['cat'] != "facture" || $_GET['cat'] != "proforma"){
                                ?>
                            <th class="desktop">Modifier</th>
                            <?php
                            }
                            ?>
                            <th class="desktop">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach($quotations as $quotation){
                            //initialisation au format date pour organiser le tableau
                            $date = date('d/m/y', strtotime($quotation->getDate()));
                            $customer = $customermanager->getById($quotation->getCustomerId());
                            $folder = $foldermanager->get($quotation->getFolderId());
                            $descriptions = new Description($array);
                            $descriptionmanager = new DescriptionManager($bdd);
                            $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
                            $montant = 0;
                            foreach ($descriptions as $description) {
                                $montant = calculMontantTotalTTC($description, $montant);
                            }
                            ?>
                            <tr>
                                <td><input class="selection" type="checkbox" name="selection[]" value="<?php echo $quotation->getQuotationNumber(); ?>" /></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                <td><?php echo $customer->getName(); ?></td>
                                <td><?php echo $folder->getFolderNumber(); ?></td>
                                <td><?php echo $quotation->getLabel(); ?></td>
                                <td><?php echo number_format($montant,0,","," "); ?> XPF</td>
                                <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/afficher/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                <?php if($_GET['cat'] != "facture" || $_GET['cat'] != "proforma"){
                                ?>
                                <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/modifier/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                <?php
                                }
                                ?>
                                <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer <?php echo $type; ?> n° <?php echo $quotation->getQuotationNumber(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo URLHOST.'_pages/_post/supprimer_devis.php?idQuotation='.$quotation->getIdQuotation().'&quotationNumber='.$quotation->getQuotationNumber().'&type='.$typeMini.'&compId='.$folder->getCompanyId(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php
if(count($quotations)>0) {
    ?>
    <div id="to_proforma" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Validation multiple des <?php print ucwords($_GET['cat']); ?> <span
                                style="font-style: italic; font-weight: 800;">en proforma</span></h4>
                </div>
                <div class="modal-body form">
                    <form action="" method="post" id="to_proforma" class="form-horizontal form-row-seperated">
                        <div class="form-group">
                            <label class="control-label col-md-4">Date
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date date-picker" data-date-lang="FR-fr"
                                     type="text">
                                    <input type="text" name="date_proforma" id="date_proforma" class="form-control"
                                           value="<?php echo $dateToProforma; ?>">
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </span>
                                </div>
                                <span class="help-block">Si aucune date n'est sélectionnée, la date par défaut sera celle du jour</span>
                            </div>
                        </div>
                        <input type="hidden" id="quotationNumber" name="quotationNumber"
                               value="<?php echo $quotation->getQuotationNumber(); ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $type2; ?>">
                        <input type="hidden" id="currentType" name="currentType" value="<?php echo $quotation->getType(); ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer
                            </button>
                            <button type="button" class="btn green" id="validerProforma" name="validerProforma"
                                    value="proforma" onclick="submitDate('proforma');">
                                <i class="fa fa-check"></i> Valider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="to_facture" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Validation multiple des <?php print ucwords($_GET['cat']); ?> <span
                                style="font-style: italic; font-weight: 800;">en facture</span></h4>
                </div>
                <div class="modal-body form">
                    <form action="" method="post" id="to_facture" class="form-horizontal form-row-seperated">
                        <div class="form-group">
                            <label class="control-label col-md-4">Date
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date date-picker" data-date-lang="FR-fr"
                                     type="text">
                                    <input type="text" name="date_facture" id="date_facture" class="form-control"
                                           value="<?php echo $dateToProforma; ?>">
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </span>
                                </div>
                                <span class="help-block">Si aucune date n'est sélectionnée, la date par défaut sera celle du jour</span>
                            </div>
                        </div>
                        <input type="hidden" id="quotationNumber" name="quotationNumber"
                               value="<?php echo $quotation->getQuotationNumber(); ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $type2; ?>">
                        <input type="hidden" id="currentType" name="currentType" value="<?php echo $quotation->getType(); ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer
                            </button>
                            <button type="button" class="btn green" id="validerFacture" name="validerFacture"
                                    value="facture" onclick="submitDate('facture');">
                                <i class="fa fa-check"></i> Valider
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div id="to_avoir" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Validation multiple des <?php print ucwords($_GET['cat']); ?> <span
                                style="font-style: italic; font-weight: 800;">en avoir</span></h4>
                </div>
                <div class="modal-body form">
                    <form action="" method="post" id="to_avoir" class="form-horizontal form-row-seperated">
                        <div class="form-group">
                            <label class="control-label col-md-4">Date
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date date-picker" data-date-lang="FR-fr"
                                     type="text">
                                    <input type="text" name="date_avoir" id="date_avoir" class="form-control"
                                           value="<?php echo $dateToProforma; ?>">
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </span>
                                </div>
                                <span class="help-block">Si aucune date n'est sélectionnée, la date par défaut sera celle du jour</span>
                            </div>
                        </div>
                        <input type="hidden" id="quotationNumber" name="quotationNumber"
                               value="<?php echo $quotation->getQuotationNumber(); ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $type2; ?>">
                        <input type="hidden" id="currentType" name="currentType" value="<?php echo $quotation->getType(); ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer
                            </button>
                            <button type="button" class="btn green" id="validerAvoir" name="validerAvoir" value="avoir"
                                    onclick="submitDate('avoir');">
                                <i class="fa fa-check"></i> Valider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="to_devis" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Validation multiple des <?php print ucwords($_GET['cat']); ?> <span
                                style="font-style: italic; font-weight: 800;">en devis</span></h4>
                </div>
                <div class="modal-body form">
                    <form action="" method="post" id="to_devis" class="form-horizontal form-row-seperated">
                        <div class="form-group">
                            <label class="control-label col-md-4">Date
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date date-picker" data-date-lang="FR-fr"
                                     type="text">
                                    <input type="text" name="date_devis" id="date_devis" class="form-control"
                                           value="<?php echo $dateToProforma; ?>">
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </span>
                                </div>
                                <span class="help-block">Si aucune date n'est sélectionnée, la date par défaut sera celle du jour</span>
                            </div>
                        </div>
                        <input type="hidden" id="quotationNumber" name="quotationNumber"
                               value="<?php echo $quotation->getQuotationNumber(); ?>">
                        <input type="hidden" id="type" name="type" value="<?php echo $type2; ?>">
                        <input type="hidden" id="currentType" name="currentType" value="<?php echo $quotation->getType(); ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer
                            </button>
                            <button type="button" class="btn green" id="validerDevis" name="validerDevis" value="devis"
                                    onclick="submitDate('devis');">
                                <i class="fa fa-check"></i> Valider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="to_validate" data-keyboard="false" data-backdrop="static" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Validation multiple des <?php print ucwords($_GET['cat']); ?>s <span style="font-style: italic; font-weight: 800;"></span></h4>
                </div>
                <div class="modal-body form">
                    <form action="" method="post" id="to_validate" class="form-horizontal form-row-seperated">
                        <input type="hidden" id="quotationNumber" name="quotationNumber"
                               value="<?php echo $quotation->getQuotationNumber(); ?>">
                        <input type="hidden" id="currentType" name="currentType" value="<?php echo $quotation->getType(); ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer
                            </button>
                            <button type="button" class="btn green" id="validerFacture" name="validerFacture" value="factures"
                                    onclick="submitInvoice('validate');">
                                <i class="fa fa-check"></i> Valider
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script language="JavaScript">
    $('#select-all').click(function(){
        if($('#select-all').attr("checked")){
            $('#select-all').removeAttr('checked');
            $('.selection').each(function() {
                $(this).removeAttr('checked').uniform('refresh');
            });
            $.uniform.update();
        }else{
            $('#select-all').attr('checked','checked');
            $('.selection').each(function() {
                $(this).prop('checked',true);
                $(this).parent('span').addClass('checked');
            });
        }
    });
    $('#multiSelection :checkbox').change(function() {
        //$.uniform.update();
        var nb = $('#multiSelection :checkbox:checked').length;
        var nbTotal = $('#multiSelection :checkbox').length;
        if (nb>0) {
            if(nb==1){
                if($('#select-all').attr("checked")){
                    $('#select-all').removeAttr('checked').uniform('refresh');
                }else{
                    $("#actions").css("display","");
                    $("#actions").css("display","inline");
                }
            }
        } else {
            $("#actions").css("display","");
            $("#actions").css("display","none");
            $('#select-all').removeAttr('checked');
        }
    });
    function submitDate(selected){
        var inputSelected = $('#date_'+selected).val();
        $("#date").val(inputSelected);
        $('#multiSelection').attr("action","<?php echo URLHOST."_pages/_post/"; ?>to_multi_"+selected+".php");
        $('#multiSelection').submit();
    }

    function submitInvoice(selected){
        $('#multiSelection').attr("action","<?php echo URLHOST."_pages/_post/"; ?>to_multi_"+selected+".php");
        $('#multiSelection').submit();
    }
</script>