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
$idQuotation = $_GET['soussoussouscat'];
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
$quotation = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);
$tax = new Tax($array);
$taxmanager = new TaxManager($bdd);

$quotation = $quotationmanager->getByQuotationNumber($idQuotation);
$company = $companymanager->getByNameData($companyNameData);
$idCompany = $company->getIdcompany();

$foldermanager = $foldermanager->getListActive($idCompany);

$folderRecup = $foldermanagerRecup->get($quotation->getFolderId());


$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());
$contact = $contactmanager->getById($folderRecup->getContactId());
$user = $usermanager->get($folderRecup->getSeller());
$customer = $customermanager->getById($quotation->getCustomerId());

$date = date('d/m/Y',strtotime(str_replace('/','-',"".$quotation->getDay().'/'.$quotation->getMonth().'/'.$quotation->getYear()."")));

?>
<div class="row">
    <div class="col-md-12">
         <?php if($retour == "error") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Une erreur est survenue, le devis n'a donc pas pu être être mis à jour !</div>
        <?php } ?>
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-medical"></i>Modification du devis <span style="font-weight: 800; font-style: italic;"><?php echo $idQuotation; ?></span></div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/modifier_devis.php"; ?>" method="post" id="devis" name="devis" class="form-horizontal">
                    <div class="form-actions top">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button type="submit" class="btn green"><i class="fas fa-save"></i> Enregistrer</button>
                                <button type="button" class="btn default"><i class="fas fa-ban"></i> Annuler</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="portlet box blue-soft">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-folder"></i>
                                            <span class="caption-subject bold uppercase"> Sélection du dossier </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="display: block;">
                                        <div class="row form-section" style="padding: 12px 20px 15px 20px; margin: 10px 0px 10px 0px !important;">
                                            <label class="col-md-2 control-label">Dossier
                                            <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-10">
                                                <select class="form-control" id="folder" name="folder">
                                                    <option value="">Choisissez un dossier...</option>
                                                    <?php
                                                        foreach ($foldermanager as $folder){
                                                            $customer = $customermanager->getByID($folder->getCustomerId());
                                                            if($quotation->getFolderId() == $folder->getIdFolder()){
                                                    ?>
                                                    <option value="<?php echo $folder->getIdFolder(); ?>"selected="selected">N° <?php echo $folder->getFolderNumber()." ".$folder->getLabel()." (".strtoupper($customer->getName()).")"; ?></option>
                                                    <?php
                                                            }else{
                                                    ?>
                                                    <option value="<?php echo $folder->getIdFolder(); ?>">N° <?php echo $folder->getFolderNumber()." ".$folder->getLabel()." (".strtoupper($customer->getName()).")"; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
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
                        <div class="row" id="detaildevis">
                            <div class="col-md-12">
                                <div class="portlet box blue-dark">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-cogs"></i>
                                            <span class="caption-subject bold uppercase"> Détails du devis </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="display: block;">
                                        <div class="row form-section" style="padding: 12px 20px 15px 20px; margin: 10px 0px 10px 0px !important;">
                                            <div class="form-group" style="margin-bottom: 0px;">
                                                <label class="control-label col-md-2">Date</label>
                                                <div class="col-md-3">
                                                    <div class="input-group input-medium date date-picker"  data-date-lang="FR-fr" type="text">
                                                        <input type="text" name="date" class="form-control" value="<?php echo $date; ?>">
                                                        <span class="input-group-btn">
                                                            <button class="btn default" type="button">
                                                                <i class="fas fa-calendar-alt"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <!-- /input-group -->
                                                    <span class="help-block"> Cliquez sur la date pour la modifier </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-section" style="padding: 12px 20px 15px 20px; margin: 10px 0px 10px 0px !important;">
                                            <label class="col-md-2 control-label">Libellé du devis
                                            </label>
                                            <div class="col-md-6">
                                                <input type="text" id="libelle" name="label" class="form-control" placeholder="<?php echo $folderRecup->getLabel(); ?>">
                                                <span class="help-block">Si le libellé n'est pas rempli, le devis récupérera le libellé du dossier</span>
                                            </div>
                                        </div>
                                        <div class="row form-section" style="padding: 12px 20px 15px 20px; margin: 10px 0px 10px 0px !important;">
                                            <label class="col-md-2 control-label">Commentaire
                                            </label>
                                            <div class="col-md-6">
                                                <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Commentaire ..."><?php echo $quotation->getComment(); ?></textarea>
                                                <span class="help-block">Le commentaire s'affichera à la fin du devis</span>
                                            </div>
                                        </div>
                                        <?php 
                                            $i = 1;
                                            $taxmanager = $taxmanager->getListByCustomer($folderRecup->getCustomerId());
                                            foreach($descriptions as $description){ ?>
                                        <div id="ligne<?php echo $i; ?>" class="ligne row" style="margin-left: 0px !important; margin-right: 0px !important;">
                                            <div class="col-md-12" style="display: flex; align-items: center;">
                                                <div class="col-md-6">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Description</label>
                                                        <textarea class="form-control" id="description<?php echo $i; ?>" name="description[<?php echo $i; ?>]" rows="4"><?php echo $description->getDescription(); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Quantité</label>
                                                        <input type="digits" id="quantite" name="quantite[<?php echo $i; ?>]" value="<?php echo $description->getQuantity(); ?>" class="form-control" placeholder="Qt.">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Remise (%)</label>
                                                        <input type="digits" id="remise" name="remise[<?php echo $i; ?>]" value="<?php echo $description->getDiscount(); ?>" class="form-control" placeholder="xx">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Taxes</label>
                                                        <select id="taxe" class="taxe form-control" name="taxe[<?php echo $i; ?>]">
                                                            <option value="">Taxes</option>
                                                            <?php
                                                            
                                                            foreach ($taxmanager as $tax){
                                                            ?>
                                                                <option value="<?php echo $tax->getValue(); ?>" <?php if($description->getTax()==$tax->getValue()){echo "selected=\"selected\""; } ?> ><?php echo $tax->getName(); ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Prix HT</label>
                                                        <input type="digits" id="prix" name="prix[<?php echo $i; ?>]" value="<?php echo $description->getPrice(); ?>" class="form-control" placeholder="HT">
                                                    </div>
                                                </div>
                                                <div id="divsuppr<?php echo $i; ?>" style="text-align: right;" class="col-md-1">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <button type="button" title="Supprimer la ligne" id="suppr<?php echo $i; ?>" class="btn red" onclick="supprLigne(<?php echo $i; ?>);"><i class="fas fa-minus-square"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            $i++;
                                            } 
                                        ?>
                                        <div class="form-actions fluid">
                                            <div class="row">
                                                <div class="col-md-12" style="text-align: center;">
                                                    <button type="button" id="ajout" class="btn default grey-mint"><i class="fas fa-plus-square"></i> Ajouter une ligne</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row" id="optdevis">
                            <div class="col-md-12">
                                <div class="portlet box grey-cascade" style="margin-bottom: 0px !important;">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-sliders-h"></i>
                                            <span class="caption-subject bold uppercase"> Options du devis </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="expand" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="display: none;">
                                        <h5 style="font-weight: 800;">Société : </h5>
                                        <h5 style="font-weight: 800;">Comercial : </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions fluid">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <button type="submit" class="btn green"><i class="fas fa-save"></i> Enregistrer</button>
                                <button type="button" class="btn default"><i class="fas fa-ban"></i> Annuler</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="idQuotation" name="idQuotation" value="<?php echo $idQuotation; ?>">
                    <input type="hidden" id="type" name="type" value="<?php echo $type2; ?>">
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#folder").on("change",function(){
        var i = $(this).val();
    	console.log("selected.value : "+i+", data[selected.value] : "+i);
        
    	$.ajax({
            url: "<?php echo URLHOST."_cfg/fonctions.php"; ?>",
    		type: "POST",
            dataType: "json",
            contentType: 'application/x-www-form-urlencoded',
    		data: {functionCalled:'getContactFormFolder',idFolder:i },
    	    cache: false,
    		success: function(response)
    	  {
                 console.log(response);
                 $("#spanCompany").text(response.company);
                 $("#spanSeller").text(response.seller);
                 $("#spanCustomer").text(response.customer);
                 $("#spanContact").text(response.contact);
                 $("#libelle").attr("placeholder",response.label);
                 $("#detaildevis").css('display','');
                 $("#detaildevis").css('display','visible');
                 $("#optdevis").css('display','');
                 $("#optdevis").css('display','visible');
                 
                 console.log("taxes : "+response.taxes[0].nom);
                 var monSelectB = document.getElementsByClassName("taxe");
                  //on efface tous les children options
                  for(var k=0; k<monSelectB.length; k++){
                      while (monSelectB[k].firstChild) {
                        monSelectB[k].removeChild(monSelectB[k].firstChild);
                      }
                      //on rajoute les nouveaux children options
                      var opt = document.createElement("option");
                        opt.value = "";
                        opt.innerHTML = "Sélectionnez ..."; 
                        monSelectB[k].appendChild(opt);
                        
                      for(var i in response['taxes']){
                        opt = document.createElement("option");
                        opt.value = response.taxes[i].valeur;
                        opt.innerHTML = response.taxes[i].nom; 
                        monSelectB[k].appendChild(opt);
                      }
                  }
    	  },
          error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            $('#spanCompany').html(msg);
        },
    	});
    });
    
    $('#ajout').click(function(){
    
      // get the last DIV which ID starts with ^= "klon"
      var $div = $('div[id^="ligne"]:last').data( "arr", [ 1 ] );
      var $textarea = $('textarea[id^="description"]:last').data( "txt", [ 1 ] );
      // Read the Number from that DIV's ID (i.e: 3 from "klon3")
      // And increment that number by 1
      var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
      
      // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
      var $klon = $div.clone(true).find("input,textarea").val("").end().find('textarea[id^="description"]:last').prop('id', 'description'+num ).end().find('textarea[name^="description"]:last').prop('name', 'description['+num+']' ).end().find('input[name^="quantite"]:last').prop('name', 'quantite['+num+']' ).end().find('input[name^="remise"]:last').prop('name', 'remise['+num+']' ).end().find('select[name^="taxe"]:last').prop('name', 'taxe['+num+']' ).end().find('input[name^="prix"]:last').prop('name', 'prix['+num+']' ).end().find('button[id^="suppr"]:last').prop('id', 'suppr'+num ).end().find('button[id^="suppr"]:last').attr('onclick', 'supprLigne('+num+')' ).end().find('div[id^="divsuppr"]:last').prop('id', 'divsuppr'+num ).end().find('div[id="divsuppr'+num+'"]').css('display','' ).end().find('div[id="divsuppr'+num+'"]').css('display','block' ).end().prop('id', 'ligne'+num );
      
      // Finally insert $klon wherever you want
      $("div[id*='divsuppr']").css('display','' );
      $("div[id*='divsuppr']").css('display','block' );
      $div.after( $klon.data( "arr", $.extend( [], $div.data( "arr" ) ) ) );
    
    });  

});
function supprLigne(selected){
        var nbDiv = $("div[class*='ligne']").length;
        var selectedDiv = $("div[id='ligne"+selected+"']");
        if(nbDiv>1){
            selectedDiv.remove();
        }else{
            selectedDiv.find('div[id="divsuppr'+selected+'"]').css('display','' ).end();
            selectedDiv.find('div[id="divsuppr'+selected+'"]').css('display','none' ).end();
            alert("Il n'est pas possible de supprimer la dernière ligne du devis !");
        }
    }
</script>