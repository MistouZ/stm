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

/*récupération des objets en base*/

switch($type){
    case "devis":
        if($type2=="cours"){
            $quotations = $quotationmanager->getListQuotation($company->getIdcompany());
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

        break;
    case "proforma":
        $quotations = $quotationmanager->getListProforma($company->getIdcompany());
        $buttons = '<div id="actions" style="display:none;">
                        <a data-toggle="modal" href="#to_facture" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                        <a data-toggle="modal" href="#to_devis" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice"></i> => Devis </a>
                    </div>';
        break;
    case "facture":
        $quotations = $quotationmanager->getListInvoice($company->getIdcompany());
        $buttons = '<div id="actions" style="display:none;">
                        <a data-toggle="modal" href="#to_avoir" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-prescription"></i> => Avoir </a>
                        <a data-toggle="modal" href="#to_devis" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice"></i> => Devis </a>
                    </div>';
        break;
    case "avoir":
        $quotations = $quotationmanager->getListAsset($company->getIdcompany());
        $buttons = '<div id="actions" style="display:none;">
                        
                    </div>';
        break;
}

$retour = $_GET['soussoussouscat'];

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['cat']); ?>  </div>
                <div class="actions">
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/creer'; ?>" class="btn btn-sm grey-mint">
                        <i class="fa fa-plus"></i> Créer un devis</a>
                    <?php //echo $buttons; ?>
                </div>
            </div>
            <div class="portlet-body">
                <?php if($retour == "errorsuppr") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le devis n'a donc pas pu être être supprimé !</div>
                <?php }elseif($retour == "successsuppr"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le devis a bien été supprimé !</div>
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
                        <button class="close" data-close="alert"></button> Erreur lors du passage en facture !</div>
                <?php }elseif($retour == "successFacture"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Passage en facture effectué avec succès !</div>
                <?php }elseif($retour == "errorDevis") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Erreur lors du passage en devis !</div>
                <?php }elseif($retour == "successDevis"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Passage en devis effectué avec succès !</div>
                <?php } ?>
                <form id="multiSelection" method="post">
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center !important;" class="desktop"><input id="select-all" type="checkbox" title="Sélectionner / Désélectionner tout" /></th>
                                <th class="all">Date</th>
                                <th class="min-phone-l">Numéro de devis</th>
                                <th class="min-tablet">Client</th>
                                <th class="desktop">Dossier</th>
                                <th class="desktop">Libellé</th>
                                <th class="none">Montant total</th>
                                <th class="desktop">Détail</th>
                                <th class="desktop">Modifier</th>
                                <th class="desktop">Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                               /* foreach ($quotations as $quotation) {
                                    //initialisation au format date pour organiser le tableau
                                    $date = date('d/m/Y', strtotime(str_replace('/', '-', "" . $quotation->getDay() . '/' . $quotation->getMonth() . '/' . $quotation->getYear() . "")));
                                    $customer = $customermanager->getById($quotation->getCustomerId());
                                    $folder = $foldermanager->get($quotation->getFolderId());
                                    $descriptions = new Description($array);
                                    $descriptionmanager = new DescriptionManager($bdd);
                                    $montant = 0;
                                    $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());
                                    foreach ($descriptions as $description) {
                                        $montant = calculMontantTotalTTC($description, $montant);
                                    }


                                    ?>
                                    <tr>
                                        <td><input class="selection" type="checkbox" name="selection[]"
                                                   value="<?php echo $quotation->getQuotationNumber(); ?>"/></td>
                                        <td><?php echo $date; ?></td>
                                        <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                        <td><?php echo $customer->getName(); ?></td>
                                        <td><?php echo $folder->getFolderNumber(); ?></td>
                                        <td><?php echo $folder->getLabel(); ?></td>
                                        <td><?php echo number_format($montant, 0, ",", " "); ?> XPF</td>
                                        <td><a class="btn green-meadow"
                                               href="<?php echo URLHOST . $_COOKIE['company'] . '/' . $type . '/afficher/' . $type2 . '/' . $quotation->getQuotationNumber(); ?>"><i
                                                        class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                        <td><a class="btn blue-steel"
                                               href="<?php echo URLHOST . $_COOKIE['company'] . '/' . $type . '/modifier/' . $type2 . '/' . $quotation->getQuotationNumber(); ?>"><i
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
                                }*/
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
<div>

</div>
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

</script>