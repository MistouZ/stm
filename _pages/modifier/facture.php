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
$quotationNumber = $_GET['soussoussouscat'];
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
$supplier = new Suppliers($array);
$suppliermanager = new SuppliersManager($bdd);
$cost = new Cost($array);
$costmanager = new CostManager($bdd);

$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();
$quotation = $quotationmanager->getByQuotationNumber($quotationNumber,"F",$companyId);

$foldermanager = $foldermanager->getListActive($companyId);
$folderRecup = $foldermanagerRecup->get($quotation->getFolderId());


$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);

$descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),"F",$companyId);
$descriptionsOption = $descriptionmanager->getOption($quotation->getQuotationNumber());

if($quotation->getContactId() != 0){
    $contact = $contactmanager->getById($quotation->getContactId());
}

$user = $usermanager->get($folderRecup->getSeller());

$customerQuotation = $customermanager->getById($quotation->getCustomerId());
$costmanager = $costmanager->getByQuotationNumber($quotation->getQuotationNumber(),"F",$companyId);

$suppliermanager = $suppliermanager->getListAllByCompany($company->getIdcompany());

$date = date('d/m/Y',strtotime($quotation->getDate()));

//récupération des contacts du client
$contactByCustomers = $contactmanager->getList($customerQuotation->getIdCustomer());

/*récupération des objets en base*/
$customermanagerList = $customermanager->getListByCompany($company->getIdcompany());

$tableauClient = array();

foreach ($customermanagerList as $customer) {
    $tempContact = array();
    $tableauContacts = $contactmanager->getList($customer->getIdCustomer());
    if(!empty($tableauContacts)){
        foreach($tableauContacts as $tableauContact){
                $tempContact[$tableauContact->getIdContact()]=$tableauContact->getFirstname().' '.$tableauContact->getName();               
        }
        $tableauClient[$customer->getIdCustomer()] = $tempContact;
    }
}

?>
<script>
    function changeSelect(selected){
      //on recupere le php
      var data = <?php echo json_encode($tableauClient); ?>;
      console.log("selected.value : "+selected.value+", data[selected.value] : "+data[selected.value]);
      var monSelectB = document.getElementById("contact-select");
      //on efface tous les children options
      while (monSelectB.firstChild) {
        monSelectB.removeChild(monSelectB.firstChild);
      }
      //on rajoute les nouveaux children options
      for(var i in data[selected.value]){
        var opt = document.createElement("option");
        opt.value = i;
        opt.innerHTML = data[selected.value][i]; 
        
        monSelectB.appendChild(opt);
      }
    }
</script>


<div class="row">
    <div class="col-md-12">
        <?php if($retour == "error") { ?>
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button> Une erreur est survenue, la facture n'a donc pas pu être être mis à jour !</div>
        <?php } ?>
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-medical"></i>Modification de la facture <span style="font-weight: 800; font-style: italic;"><?php echo $idQuotation; ?></span></div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/modifier_facture.php"; ?>" method="post" id="facture" name="facture" class="form-horizontal">
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
                                            <span class="caption-subject bold uppercase"> Informations du dossier </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="display: block;">
                                        <div class="row form-section" style="padding: 12px 20px 15px 20px; margin: 10px 0px 10px 0px !important;">
                                            <div class="col-md-2">Dossier</div>
                                            <div class="col-md-10">
                                                    <?php
                                                    foreach ($foldermanager as $folder){
                                                        $customer = $customermanager->getByID($folder->getCustomerId());
                                                        if($quotation->getFolderId() == $folder->getIdFolder()){
                                                            ?>
                                                            N° <?php echo $folder->getFolderNumber()." ".$folder->getLabel()." (".strtoupper($customer->getName()).")"; ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
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
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="customer-select" style="font-weight: 800;">
                                                            Client                                              
                                                        </label>
                                                        <div class="col-md-4">
                                                            <select id="customer-select" name="customer-select" class="form-control" onchange="changeSelect(this);">
                                                                <option value="">--Choississez le client--</option>
                                                                <?php
                                                                    foreach($customermanagerList as $customer){
                                                                        if($customer->getIdCustomer() == $customerQuotation->getIdCustomer()){
                                                                            echo "<option value=" . $customer->getIdCustomer() . " selected=\"selected\">".$customer->getName()."</option>";
                                                                        }else{
                                                                            echo "<option value=" . $customer->getIdCustomer() . ">".$customer->getName()."</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="contact-select" style="font-weight: 800;">Contact</label>
                                                        <div class="col-md-4">
                                                            <select id="contact-select" name="contact-select" class="form-control">
                                                                <option value="0">--Choississez le contact--</option>
                                                                <?php
                                                                    foreach($contactByCustomers as $contacts){
                                                                        if($contacts->getIdContact() == $contact->getIdContact()){
                                                                            echo "<option value=" . $contacts->getIdContact() . " selected=\"selected\">".$contacts->getFirstname().' '.$contacts->getName()."</option>";
                                                                        }else{
                                                                            echo "<option value=" . $contacts->getIdContact() . ">".$contacts->getFirstname().' '.$contacts->getName()."</option>";
                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>


                                                        <!--<h5 style="font-weight: 800;">Client : <span id="spanCustomer"><?php echo $customerQuotation->getName(); ?></span></h5>
                                                        <h5 style="font-weight: 800;">Contact : <span id="spanContact"><?php echo $contact->getFirstname()." ".$contact->getName(); ?></span></h5>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="detailfacture">
                            <div class="col-md-12">
                                <div class="portlet box blue-dark">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-cogs"></i>
                                            <span class="caption-subject bold uppercase"> Détails de la facture </span>
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
                                            <label class="col-md-2 control-label">Libellé de la facture
                                            </label>
                                            <div class="col-md-6">
                                                <?php echo $folderRecup->getLabel(); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $i = 1;
                                        $taxmanager = $taxmanager->getListByCustomer($quotation->getCustomerId());
                                        foreach($descriptions as $description){ ?>
                                            <div id="ligneFacture<?php echo $i; ?>" class="ligneFacture" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                <div class="col-md-12" style="display: flex; align-items: center;">
                                                    <div class="col-md-6">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <label class="control-label">Description</label>
                                                            <textarea class="form-control" id="descriptionFacture<?php echo $i; ?>" name="descriptionFacture[<?php echo $i; ?>]" rows="4"><?php echo $description->getDescription(); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <label class="control-label">Quantité</label>
                                                            <input type="digits" id="quantiteFacture<?php echo $i; ?>" name="quantiteFacture[<?php echo $i; ?>]" value="<?php echo $description->getQuantity(); ?>" class="form-control" placeholder="Qt.">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <label class="control-label">Remise (%)</label>
                                                            <input type="digits" id="remiseFacture<?php echo $i; ?>" name="remiseFacture[<?php echo $i; ?>]" value="<?php echo $description->getDiscount(); ?>" class="form-control" placeholder="xx">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                            <label class="control-label">Taxes</label>
                                                            <select id="taxeFacture<?php echo $i; ?>" class="taxe form-control" name="taxeFacture[<?php echo $i; ?>]">
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
                                                            <input type="digits" id="prixFacture<?php echo $i; ?>" name="prixFacture[<?php echo $i; ?>]" value="<?php echo $description->getPrice(); ?>" class="form-control" placeholder="HT">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        }
                                        ?>
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
                                            <span class="caption-subject bold uppercase"> Coûts liés au devis </span>
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
                                                        <div class="col-md-6" style="display: none;">
                                                            <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                                <label class="control-label">ID Coût</label>
                                                                <input type="digits" id="idCout<?php echo $k; ?>" name="idCout[<?php echo $k; ?>]" value="<?php echo $cost->getIdCost(); ?>" class="form-control" placeholder="HT">
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
                    <input type="hidden" id="folder" name="folder" value="<?php echo $folderRecup->getIdFolder() ?>">
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
                    $("#detailfacture").css('display','');
                    $("#detailfacture").css('display','visible');

                    var monSelectB = document.getElementsByClassName("taxe");
                    //on efface tous les children options
                    for(var k=0; k<monSelectB.length; k++){
                        while (monSelectB[k].firstChild) {
                            console.log("option : "+monSelectB[k]);
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
                            if(response.taxes[i].valeur == 0.06){
                                opt.setAttribute("selected", "selected");
                            }
                            monSelectB[k].appendChild(opt);
                        }
                    }
                    var monSelectC = document.getElementsByClassName("taxeOption");
                    //on efface tous les children options
                    for(var k=0; k<monSelectC.length; k++){
                        while (monSelectC[k].firstChild) {
                            console.log("option : "+monSelectC[k]);
                            monSelectC[k].removeChild(monSelectC[k].firstChild);
                        }
                        //on rajoute les nouveaux children options
                        var opt = document.createElement("option");
                        opt.value = "";
                        opt.innerHTML = "Sélectionnez ...";
                        monSelectC[k].appendChild(opt);

                        for(var i in response['taxes']){
                            opt = document.createElement("option");
                            opt.value = response.taxes[i].valeur;
                            opt.innerHTML = response.taxes[i].nom;
                            if(response.taxes[i].valeur == 0.06){
                                opt.setAttribute("selected", "selected");
                            }
                            monSelectC[k].appendChild(opt);
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
            var $div = $('div[id^="ligneFacture"]:last').data( "arr", [ 1 ] );
            var $textarea = $('textarea[id^="descriptionFacture"]:last').data( "txt", [ 1 ] );
            // Read the Number from that DIV's ID (i.e: 3 from "klon3")
            // And increment that number by 1
            var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;

            // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
            var $klon = $div.clone(true).find(".help-block-error").text("").end().find(".has-error").removeClass("has-error").end().find("input,textarea").val("").end().find('textarea[id^="descriptionFacture"]:last').prop('id', 'descriptionFacture'+num ).end().find('textarea[name^="descriptionFacture"]:last').prop('name', 'descriptionFacture['+num+']' ).end().find('input[name^="quantiteFacture"]:last').prop('name', 'quantiteFacture['+num+']' ).end().find('input[name^="remiseFacture"]:last').prop('name', 'remiseFacture['+num+']' ).end().find('select[name^="taxeFacture"]:last').prop('name', 'taxeFacture['+num+']' ).end().find('select[id^="taxeFacture"]:last').prop('id', 'taxeFacture'+num ).end().find('input[name^="prixFacture"]:last').prop('name', 'prixFacture['+num+']' ).end().find('input[id^="prixFacture"]:last').prop('id', 'prixFacture'+num ).end().find('button[id^="supprFacture"]:last').prop('id', 'supprFacture'+num ).end().find('button[id^="supprFacture"]:last').attr('onclick', 'supprLigneFacture('+num+')' ).end().find('div[id^="divsupprFacture"]:last').prop('id', 'divsupprFacture'+num ).end().find('div[id="divsupprFacture'+num+'"]').css('display','' ).end().find('div[id="divsupprFacture'+num+'"]').css('display','block' ).end().prop('id', 'ligneFacture'+num );

            // Finally insert $klon wherever you want
            $("div[id*='divsupprFacture']").css('display','' );
            $("div[id*='divsupprFacture']").css('display','block' );
            $div.after( $klon.data( "arr", $.extend( [], $div.data( "arr" ) ) ) );

            $("#descriptionFacture"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });
            $("#taxeFacture"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });
            $("#prixFacture"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });

        });
        $('#ajoutOption').click(function(){

            // get the last DIV which ID starts with ^= "klon"
            var $div = $('div[id^="ligneOption"]:last').data( "arr", [ 1 ] );
            var $textarea = $('textarea[id^="descriptionOption"]:last').data( "txt", [ 1 ] );
            // Read the Number from that DIV's ID (i.e: 3 from "klon3")
            // And increment that number by 1
            var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;

            // Clone it and assign the new ID (i.e: from num 4 to ID "klon4")
            var $klon = $div.clone(true).find(".help-block-error").text("").end().find(".has-error").removeClass("has-error").end().find("input,textarea").val("").end().find('textarea[id^="descriptionOption"]:last').prop('id', 'descriptionOption'+num ).end().find('textarea[name^="descriptionOption"]:last').prop('name', 'descriptionOption['+num+']' ).end().find('input[name^="quantiteOption"]:last').prop('name', 'quantiteOption['+num+']' ).end().find('input[name^="remiseOption"]:last').prop('name', 'remiseOption['+num+']' ).end().find('select[name^="taxeOption"]:last').prop('name', 'taxeOption['+num+']' ).end().find('select[id^="taxeOption"]:last').prop('id', 'taxeOption'+num ).end().find('input[name^="prixOption"]:last').prop('name', 'prixOption['+num+']' ).end().find('input[id^="prixOption"]:last').prop('id', 'prixOption'+num ).end().find('button[id^="supprOption"]:last').prop('id', 'supprOption'+num ).end().find('button[id^="supprOption"]:last').attr('onclick', 'supprLigneOption('+num+')' ).end().find('div[id^="divsupprOption"]:last').prop('id', 'divsupprOption'+num ).end().find('div[id="divsupprOption'+num+'"]').css('display','' ).end().find('div[id="divsupprOption'+num+'"]').css('display','block' ).end().prop('id', 'ligneOption'+num );

            // Finally insert $klon wherever you want
            $("div[id*='divsupprOption']").css('display','' );
            $("div[id*='divsupprOption']").css('display','block' );
            $div.after( $klon.data( "arr", $.extend( [], $div.data( "arr" ) ) ) );

            $("#descriptionOption"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });
            $("#taxeOption"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });
            $("#prixOption"+num).each(function(){
                $(this).rules("add", {
                    required: true
                });
            });

        });
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
            document.getElementById("fournisseur"+selected).selectedIndex  = 0;
            document.getElementById("descriptionCout"+selected).value = "";
            document.getElementById("prixCout"+selected).value = "";
            selectedDiv.find('div[id="divsupprCout'+selected+'"]').css('display','' ).end();
            selectedDiv.find('div[id="divsupprCout'+selected+'"]').css('display','none' ).end();
            alert("Il n'est pas possible de supprimer la dernière ligne des coûts !");
        }
    }

</script>