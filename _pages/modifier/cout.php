<?php
/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

$array = array();
$companyNameData = $_GET["section"];
$type = $_GET['cat'];
$folderId = $_GET['soussouscat'];
$costId = $_GET['soussoussouscat'];
$retour = $_GET['cat5'];

$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$folderRecup = new Folder($array);
$foldermanagerRecup = new FoldersManager($bdd);
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);
$supplier = new Suppliers($array);
$suppliermanager = new SuppliersManager($bdd);
$cost = new Cost($array);
$costmanager = new CostManager($bdd);

$costRecup = $costmanager->getByCostId($costId);

$quotationNumber = $costRecup->getQuotationNumber();
$quotationType = $costRecup->getType();

$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$foldermanager = $foldermanager->getListActive($companyId);

$folderRecup = $foldermanagerRecup->get($folderId);

$contact = $contactmanager->getById($folderRecup->getContactId());
$user = $usermanager->get($folderRecup->getSeller());
$customer = $customermanager->getById($folderRecup->getCustomerId());
$costmanager = $costmanager->getByFolderId($folderRecup->getIdFolder());


$suppliermanager = $suppliermanager->getListAllByCompany($company->getIdcompany());

?>
<div class="row">
    <div class="col-md-12">
        <?php if($retour == "error") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Une erreur est survenue, le coût n'a donc pas pu être être mis à jour !</div>
        <?php } ?>
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-medical"></i>Modification du coût du dossier <span style="font-weight: 800; font-style: italic;"><?php echo $folderRecup->getFolderNumber(); ?></span></div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/modifier_cout.php"; ?>" method="post" id="cout" name="cout" class="form-horizontal">
                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="portlet box blue-soft">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-folder"></i>
                                            <span class="caption-subject bold uppercase">Modification des coûts </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="display: block;">
                                        <div class="row form-section" style="padding: 12px 20px 15px 20px; margin: 10px 0px 10px 0px !important;">
                                            <label class="col-md-2 control-label">
                                                <h3 style="font-weight: 800; vert-align: middle;">Dossier N° <?php echo $folderRecup->getFolderNumber()." ".$folderRecup->getLabel(); ?></h3>
                                            </label>
                                        </div>
                                        <div id="infos" class="row form-section" style="margin: 10px 0px 0px 0px !important;">
                                            <div class="col-md-6">
                                                <div class="portlet box purple-sharp" style="margin-bottom: 0px !important;">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fas fa-building"></i>
                                                            <span class="caption-subject bold uppercase"> Informations de la société </span>
                                                        </div>
                                                        <div class="tools">
                                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body" style="display: block;">
                                                        <h5 style="font-weight: 800;">Société : <span id="spanCompany"><?php echo $company->getName(); ?></span></h5>
                                                        <h5 style="font-weight: 800;">Comercial : <span id="spanSeller"><?php echo $user->getName()." ".$user->getFirstName() ?></span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="portlet box purple-sharp" style="margin-bottom: 0px !important;">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fas fa-user-tie"></i>
                                                            <span class="caption-subject bold uppercase"> Informations client </span>
                                                        </div>
                                                        <div class="tools">
                                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body" style="display: block;">
                                                        <h5 style="font-weight: 800;">Client : <span id="spanCustomer"><?php echo $customer->getName(); ?></span></h5>
                                                        <h5 style="font-weight: 800;">Contact : <span id="spanContact"><?php echo $contact->getFirstname()." ".$contact->getName(); ?></span></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="coutdevis">
                            <div class="col-md-12">
                                <div class="portlet box red-flamingo" style="margin-bottom: 0px !important;">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-hand-holding-usd"></i>
                                            <span class="caption-subject bold uppercase"> Coûts liés au dossier </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" <?php if(count($costmanager) == 0){ echo 'class="expand"';}else{echo 'class="collapse"';} ?> data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" <?php if(count($costmanager) == 0){ echo 'style="display: none;"';}else{echo 'style="display: block;"';} ?>>
                                        <?php
                                        $k = 1;
                                        if(count($costmanager) > 0){
                                            foreach($costmanager as $cost){ ?>
                                                <div id="ligneCout<?php echo $k; ?>" class="ligneCout row" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                    <div class="col-md-12" style="display: flex; align-items: center;">
                                                        <div class="col-md-4">
                                                            <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                                <label class="control-label">Fournisseur</label>
                                                                <select id="fournisseur<?php echo $k; ?>" class="form-control" name="fournisseur[<?php echo $k; ?>]">
                                                                    <option value="">Sélectionnez ...</option>
                                                                    <?php
                                                                    foreach ($suppliermanager as $supplier){
                                                                        ?>
                                                                        <option value="<?php echo $supplier->getIdSupplier(); ?>" <?php if($cost->getSupplierId()== $supplier->getIdSupplier()){echo "selected=\"selected\""; } ?> ><?php echo $supplier->getName(); ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                                <label class="control-label">Description</label>
                                                                <textarea class="form-control" id="descriptionCout<?php echo $k; ?>" name="descriptionCout[<?php echo $k; ?>]" rows="4"><?php echo $cost->getDescription(); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                                <label class="control-label">Prix HT</label>
                                                                <input type="digits" id="prixCout<?php echo $k; ?>" name="prixCout[<?php echo $k; ?>]" value="<?php echo $cost->getValue(); ?>" class="form-control" placeholder="HT">
                                                            </div>
                                                        </div>
                                                        <div id="divsupprCout1" style="text-align: right;" class="col-md-1">
                                                            <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                                <button type="button" title="Supprimer la ligne" id="supprCout<?php echo $k; ?>" class="btn red" onclick="supprLigneCout(<?php echo $k; ?>);"><i class="fas fa-minus-square"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $k++;
                                            }
                                        }
                                        else{
                                        ?>
                                            <div id="ligneCout<?php echo $k; ?>" class="ligneCout row" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                <div class="col-md-12" style="display: flex; align-items: center;">
                                                    <div class="col-md-4">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <label class="control-label">Fournisseur</label>
                                                            <select id="fournisseur<?php echo $k; ?>" class="form-control" name="fournisseur[<?php echo $k; ?>]">
                                                                <option value="">Sélectionnez ...</option>
                                                                <?php
                                                                foreach ($suppliermanager as $supplier){
                                                                    ?>
                                                                    <option value="<?php echo $supplier->getIdSupplier(); ?>" <?php if($cost->getSupplierId()== $supplier->getIdSupplier()){echo "selected=\"selected\""; } ?> ><?php echo $supplier->getName(); ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <label class="control-label">Description</label>
                                                            <textarea class="form-control" id="descriptionCout<?php echo $k; ?>" name="descriptionCout[<?php echo $k; ?>]" rows="4"><?php echo $cost->getDescription(); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <label class="control-label">Prix HT</label>
                                                            <input type="digits" id="prixCout<?php echo $k; ?>" name="prixCout[<?php echo $k; ?>]" value="<?php echo $cost->getValue(); ?>" class="form-control" placeholder="HT">
                                                        </div>
                                                    </div>
                                                    <div id="divsupprCout1" style="text-align: right;" class="col-md-1">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <button type="button" title="Supprimer la ligne" id="supprCout<?php echo $k; ?>" class="btn red" onclick="supprLigneCout(<?php echo $k; ?>);"><i class="fas fa-minus-square"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="form-actions fluid">
                                            <div class="row">
                                                <div class="col-md-12" style="text-align: center;">
                                                    <button type="button" id="ajoutCout" class="btn default grey-mint"><i class="fas fa-plus-square"></i> Ajouter une ligne</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions fluid">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button type="submit" class="btn green"><i class="fas fa-save"></i> Enregistrer</button>
                                <button type="button" class="btn default" onclick="history.back()"><i class="fas fa-ban"></i> Annuler</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="quotationNumber" name="quotationNumber" value="<?php echo $quotationNumber; ?>">
                    <input type="hidden" id="folderId" name="folderId" value="<?php echo $folderId; ?>">
                    <input type="hidden" id="quotationType" name="quotationType" value="<?php echo $quotationType; ?>">
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#ajoutCout').click(function(){

            // get the last DIV which ID starts with ^= "klon"
            var $div = $('div[id^="ligneCout"]:last').data( "arr", [ 1 ] );
            var $textarea = $('textarea[id^="descriptionCout"]:last').data( "txt", [ 1 ] );
            // Read the Number from that DIV's ID (i.e: 3 from "klon3")
            // And increment that number by 1
            var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;

            // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
            var $klon = $div.clone(true).find(".help-block-error").text("").end().find(".has-error").removeClass("has-error").end().find("input,textarea").val("").end().find('textarea[id^="descriptionCout"]:last').prop('id', 'descriptionCout'+num ).end().find('textarea[name^="descriptionCout"]:last').prop('name', 'descriptionCout['+num+']' ).end().find('select[name^="fournisseur"]:last').prop('name', 'fournisseur['+num+']' ).end().find('select[id^="fournisseur"]:last').prop('id', 'fournisseur'+num ).end().find('input[name^="prixCout"]:last').prop('name', 'prixCout['+num+']' ).end().find('input[id^="prixCout"]:last').prop('id', 'prixCout'+num ).end().find('button[id^="supprCout"]:last').prop('id', 'supprCout'+num ).end().find('button[id^="supprCout"]:last').attr('onclick', 'supprLigneCout('+num+')' ).end().find('div[id^="divsupprCout"]:last').prop('id', 'divsupprCout'+num ).end().find('div[id="divsupprCout'+num+'"]').css('display','' ).end().find('div[id="divsupprCout'+num+'"]').css('display','block' ).end().prop('id', 'ligneCout'+num );

            // Finally insert $klon wherever you want
            $("div[id*='divsupprCout']").css('display','' );
            $("div[id*='divsupprCout']").css('display','block' );
            $div.after( $klon.data( "arr", $.extend( [], $div.data( "arr" ) ) ) );

            $("#descriptionCout"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });
            $("#taxeCout"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });
            $("#prixCout"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });

        });

    });

    function supprLigneCout(selected){
        var nbDiv = $("div[class*='ligneCout']").length;
        var selectedDiv = $("div[id='ligneCout"+selected+"']");
        if(nbDiv>1){
            selectedDiv.remove();
        }else{
            selectedDiv.find('div[id="divsupprCout'+selected+'"]').css('display','' ).end();
            selectedDiv.find('div[id="divsupprCout'+selected+'"]').css('display','none' ).end();
            alert("Il n'est pas possible de supprimer la dernière ligne des coûts !");
        }
    }
</script>