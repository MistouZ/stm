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

switch($type){
    case "devis":
        $quotations = $quotationmanager->getListQuotation($company->getIdcompany());
        $buttons = '<div id="actions" style="display:none;">
                        <a data-toggle="modal" href="#to_proforma" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-alt"></i> => Proforma </a>
                        <a data-toggle="modal" href="#to_facture" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                    </div>';
        break;
    case "proforma":
        $quotations = $quotationmanager->getListProforma($company->getIdcompany());
        $buttons = '<div id="actions">
                        <a data-toggle="modal" href="#to_facture" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                        <a data-toggle="modal" href="#to_devis" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice"></i> => Devis </a>
                    </div>';
        break;
    case "facture":
        $quotations = $quotationmanager->getListInvoice($company->getIdcompany());
        $buttons = '<div id="actions">
                        <a data-toggle="modal" href="#to_avoir" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-prescription"></i> => Avoir </a>
                        <a data-toggle="modal" href="#to_devis" class="btn grey-mint btn-sm">
                            <i class="fas fa-file-invoice"></i> => Devis </a>
                    </div>';
        break;
    case "avoir":
        $quotations = $quotationmanager->getListAsset($company->getIdcompany());
        $buttons = '<div id="actions">
                        
                    </div>';
        break;
}

$retour = $_GET['soussoussouscat'];

?>
<div class="row">
    <div class="col-md-12">
        <?php if($retour == "errorsuppr") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Une erreur est survenue, le devis n'a donc pas pu être être supprimé !</div>
        <?php }elseif($retour == "successsuppr"){ ?>
            <div class="alert alert-success">
                <button class="close" data-close="alert"></button> Le devis a bien été supprimé !</div>
        <?php } ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['cat']); ?>  </div>
                <div class="actions">
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/devis/creer'; ?>" class="btn btn-sm grey-mint">
                        <i class="fa fa-plus"></i> Créer un devis</a>
                    <?php echo $buttons; ?>
                </div>
            </div>
            <div class="portlet-body">
                <form id="multiSelection">
                    <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="text-align: center !important;" class="desktop"><input id="select-all" type="checkbox" /></th>
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
                            foreach($quotations as $quotation){
                                //initialisation au format date pour organiser le tableau
                                $date = date('d/m/Y',strtotime(str_replace('/','-',"".$quotation->getDay().'/'.$quotation->getMonth().'/'.$quotation->getYear()."")));
                                $customer = $customermanager->getById($quotation->getCustomerId());
                                $folder = $foldermanager->get($quotation->getFolderId());
                                $descriptions = new Description($array);
                                $descriptionmanager = new DescriptionManager($bdd);
                                $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());
                                $montant = 0;
                                foreach($descriptions as $description){
                                    $montantLigne = $description->getQuantity()*$description->getPrice();
                                    $remise = $montantLigne*($description->getDiscount()/100);
                                    $taxe = $montantLigne*$description->getTax();
                                    $montantLigne = $montantLigne-$remise;
                                    $montantLigne = $montantLigne+$taxe;
                                    $montant = $montant+$montantLigne;
                                }
                            ?>
                            <tr>
                                <td><input type="checkbox" name="selection[]" value="<?php echo $quotation->getQuotationNumber(); ?>" /></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                <td><?php echo $customer->getName(); ?></td>
                                <td><?php echo $folder->getFolderNumber(); ?></td>
                                <td><?php echo $folder->getLabel(); ?></td>
                                <td><?php echo number_format($montant,0,","," "); ?> XPF</td>
                                <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/afficher/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/'.$type.'/modifier/'.$type2.'/'.$quotation->getQuotationNumber(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le devis n° <?php echo $quotation->getQuotationNumber(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo URLHOST.'_pages/_post/supprimer_devis.php?idQuotation='.$quotation->getIdQuotation().'&quotationNumber='.$quotation->getQuotationNumber(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<script language="JavaScript">
$('#select-all').on("click",function(event) {
    if($(this).parent('.checked')) {
        // Iterate each checkbox
        $('input:checkbox').each(function() {
            $(this).attr('checked','checked');
            $(this).parent('span').addClass('checked');                         
        });
    } else {
        $(this).removeAttr('checked');
        $('input:checkbox').each(function() {
            $(this).removeAttr('checked');
            $(this).parent('span').removeClass('checked');                       
        });
    }
});
$('#multiSelection :checkbox').change(function() {
    var nb = $('#multiSelection :checkbox').length;
      
    if (nb>0) {
        $("#actions").css("display","");
        $("#actions").css("display","inline"); 
    } else {
        $("#actions").css("display","");
        $("#actions").css("display","none");
    }
});

</script>