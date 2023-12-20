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
$printType = $_GET['cat5'];

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
$shatteredQuotation = new ShatteredQuotation($array);
$shatteredManager = new ShatteredQuotationManager($bdd);

$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

switch($type){
    case "devis":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation,"D",$companyId);
        $entete = "du devis";
        $enteteIcon = '<i class="fas fa-file-invoice"></i>';
        $typeQuotation = "D";
        break;

    case "proforma":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation,"P",$companyId);
        $entete = "de la proforma";
        $enteteIcon = '<i class="fas fa-file-alt"></i>';
        $typeQuotation = "P";
        break;

    case "facture":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation,"F",$companyId);
        $entete = "de la facture";
        $enteteIcon = '<i class="fas fa-file-invoice-dollar"></i>';
        $typeQuotation = "F";
        break;

    case "avoir":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation,"A",$companyId);
        $entete = "de l'avoir";
        $enteteIcon = '<i class="fas fa-file-prescription"></i>';
        $typeQuotation = "A";
        break;
}

$folder = $foldermanager->get($quotation->getFolderId());
$company = $companymanager->getByNameData($companyNameData);
$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$typeQuotation,$companyId);
$contact = $contactmanager->getById($quotation->getContactId());
$user = $usermanager->get($folder->getSeller());
$customer = $customermanager->getById($quotation->getCustomerId());
if($quotation->getType() == "S")
{
    $shatteredQuotation = $shatteredManager->getByQuotationNumberChild($quotation->getQuotationNumber());
}

$date = date('d/m/Y',strtotime($quotation->getDate()));

?>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div id="myCanvas">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="portlet yellow-crusta box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fas fa-info"></i>Informations</div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-5 name"> <?php echo ucwords($type); ?>: </div>
                            <div class="col-md-7 value"><strong> <?php echo $quotation->getQuotationNumber(); ?></strong></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Date: </div>
                            <div class="col-md-7 value"><strong> <?php echo $date; ?></strong></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Dossier N°: </div>
                            <div class="col-md-7 value"><strong><?php echo $folder->getFolderNumber(); ?></strong></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Commercial : </div>
                            <div class="col-md-7 value"><strong> <?php echo $user->getName().' '.$user->getFirstName(); ?> </strong></div>
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
                            <div class="col-md-4 name"> Client: </div>
                            <div class="col-md-8 value"><strong> <?php echo $customer->getName(); ?> </strong></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name"> Adresse: </div>
                            <div class="col-md-8 value"><strong><?php echo $customer->getInvoiceAddress(); ?></strong> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name"> Contact: </div>
                            <div class="col-md-8 value"><strong><?php echo $contact->getFirstname()." ".$contact->getName(); ?></strong></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name"> Téléphone: </div>
                            <div class="col-md-8 value"><strong> <?php echo $contact->getPhoneNumber(); ?></strong> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 name"> Mail: </div>
                            <div class="col-md-8 value"> <strong><?php echo $contact->getEmailAddress(); ?></strong> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row static-info">
            <div class="col-md-2 name"> Libellé : </div>
            <div class="col-md-10 value"><strong> <?php echo $quotation->getLabel(); ?></strong> </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet grey-cascade box">
                    <div class="portlet-title">
                        <div class="caption">
                            <?php echo $enteteIcon; ?> <span style="margin-left: 5px"> Détail <?php echo $entete; ?> </span></div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-5"> Description </th>
                                        <th class="col-md-2"> Prix à l'unité </th>
                                        <th> QT. </th>
                                        <th> Taxe </th>
                                        <th> Remise </th>
                                        <th class="col-md-2"> Prix total HT </th>
                                    </tr>
                                </thead>
                               <tbody>
                                    <?php
                                        $montant = 0;
                                        $totalTaxe = 0;
                                        $montantHT = 0;
                                        $arrayTaxesKey =  array();
                                        foreach($descriptions as $description){
                                            $montantLigne = $description->getQuantity()*$description->getPrice();
                                            $remise = $montantLigne*($description->getDiscount()/100);
                                            $montantLigne = $montantLigne-$remise;
                                            $taxe = $montantLigne*$description->getTax();
                                            $tax = $taxmanager->getByPercent($description->getTax()*100);

                                            //Calcul du détail des taxes pour l'affichage par tranche détaillée
                                            if(isset($arrayTaxesKey[$tax->getName()]['Taxe'])){
                                                $arrayTaxesKey[$tax->getName()]["Montant"] = $arrayTaxesKey[$tax->getName()]["Montant"]+$taxe;
                                            }
                                            else{                                                   
                                                $arrayTaxesKey[$tax->getName()]['Taxe']=$tax->getName();
                                                $arrayTaxesKey[$tax->getName()]['Montant']=$taxe;                                                    
                                            }

                                            $totalTaxe = $totalTaxe+$taxe;
                                            $montantHT = $montantHT+$montantLigne;
                                            $montant = $montant+$montantLigne+$taxe;
                                        ?>
                                        <tr>
                                            <td class="col-md-5"><?php echo nl2br($description->getDescription()); ?></td>
                                            <td class="col-md-2"><?php echo number_format($description->getPrice(),0,","," "); ?> XPF</td>
                                            <td><?php echo $description->getQuantity(); ?></td>
                                            <td><?php echo $description->getTax()*100; ?> %</td>
                                            <td><?php echo $description->getDiscount(); ?> %</td>
                                            <td class="col-md-2"><?php echo number_format($montantLigne,0,","," "); ?> XPF</td>
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
        <div class="row">
                <div class="col-md-12" style="font-size: 10px; font-weight: bold; text-align: center; padding-bottom: 10px;">
                    Option de paiement de la TGC sur les débits conformément à l'article Lp 500-2 du codes des impôts de la Nouvelle-Calédonie.
                </div>
        </div>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-7">
                <div class="well">
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name"> Sous-total: </div>
                        <div class="col-md-6 value"> <?php echo number_format($montantHT,0,","," "); ?> XPF</div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name"> Total taxes : </div>
                        <div class="col-md-6 value"> <?php echo number_format($totalTaxe,0,","," "); ?> XPF</div>
                    </div>
                    <?php
                        foreach($arrayTaxesKey as $key => $value){
                            if($arrayTaxesKey[$key]["Montant"]>0){
                    ?>
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name" style="font-size: 11px; font-style: italic;"> <?php echo $arrayTaxesKey[$key]["Taxe"]; ?> : </div>
                        <div class="col-md-6 value" style="font-size: 11px; font-style: italic;"> <?php echo number_format($arrayTaxesKey[$key]["Montant"],0,","," "); ?> XPF</div>
                    </div>
                    <?php }} ?>
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name" style="font-weight: 800; font-size: 16px;"> Total TTC : </div>
                        <div class="col-md-6 value" style="font-weight: 800; font-size: 16px;"> <?php echo number_format($montant,0,","," "); ?> XPF</div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($type == "devis"){
            ?>
        <div class="row">
            <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6">Le client</div>
                    </div>
                    <div class="row">  
                        <div class="col-md-6" style="font-style: italic;">"Bon pour accord"</div>
                    </div>
            </div>
            <div class="col-md-7" style="font-size: 10px; font-style: italic;">
                <?php echo $quotation->getComment(); ?>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <input type="hidden" id="filename" name="filename" value="<?php echo $type."-".$idQuotation; ?>">
    <button id="Exporter" onclick="ExportPdf()">Exporter</button>
</div>

<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.default-v2.min.css"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.common-bootstrap.min.css"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.bootstrap.min.css"></script>
<script>
    // Import DejaVu Sans font for embedding
    kendo.pdf.defineFont({
        "DejaVu Sans":
            "https://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans.ttf",

        "DejaVu Sans|Bold":
            "https://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",

        "DejaVu Sans|Bold|Italic":
            "https://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",

        "DejaVu Sans|Italic":
            "https://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",

        "WebComponentsIcons"      :
            "https://kendo.cdn.telerik.com/2020.2.513/styles/fonts/glyphs/WebComponentsIcons.ttf",

        "FontAwesome":
            "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/webfonts/fa-solid-900.ttf"
    });
</script>
<script type="x/kendo-template" id="page-template">
    <div class="page-template">
        <?php if($printType=='header'){ ?>
            <div class="header" >
                <img src="<?php echo URLHOST; ?>images/societe/header/<?php echo $companyNameData; ?>.jpg" alt="<?php echo $companyNameData; ?>" class="logo-default" style="display: block;  margin-left: auto; margin-right: auto; width: 100%; bottom : 10px" />
            </div>
            <div class="footer">
                <h5> #:pageNum# / #:totalPages# </h5>  
                <img src="<?php echo URLHOST; ?>images/societe/footers/<?php echo $companyNameData; ?>.jpg" alt="<?php echo $companyNameData; ?>" class="logo-default" style="display: block;  margin-left: auto; margin-right: auto; width: 100%; bottom : 0px" />        
            </div>
        <?php }else{ ?>
            <div class="header" >
                <div style="height : 60px;"></div>
            </div>
            <div class="footer">
                <h5> #:pageNum# / #:totalPages# </h5>  
                <div style="height : 30px;"></div> 
            </div>
        <?php } ?>
    </div>
</script>
<script type="text/javascript" language="javascript">

    window.onload = function() {
        document.getElementById('Exporter').click();
    }

   function closeWindow() {
        setTimeout(function() {
            window.close();
        }, 500); // 300 pour NC sur serveur MLS
    }

    function ExportPdf(){
        var filename = document.getElementById("filename").value;
        kendo.drawing
            .drawDOM("#myCanvas",
                {
                    paperSize: "A4",
                    multiPage : true,
                    margin: { top: "3cm", bottom: "2cm", right: "1cm", left: "1cm" },
                    scale: 0.65,
                    height: 500,
                    template: $("#page-template").html(),
                    keepTogether: ".prevent-split"
                })
            .then(function(group){
                kendo.drawing.pdf.saveAs(group, filename+".pdf")
            });
       window.onload = closeWindow();
    }
</script>
<style>
    /*
        Make sure everything in the page template is absolutely positioned.
        All positions are relative to the page container.
    */
    .page-template > * {
        position: absolute;
        left: 20px;
        right: 20px;
        font-size: 90%;
    }
    .page-template .header {
        top: 20px;
        /*border-bottom: 1px solid #000;*/
        text-align: center;
    }
    .page-template .footer {
        bottom: 20px;
        /*border-top: 1px solid #000;*/
        text-align: center;
    }

    .fas{
        font-family : FontAwesome;
    }

    /*
        Use the DejaVu Sans font for display and embedding in the PDF file.
        The standard PDF fonts have no support for Unicode characters.
    */
    #myCanvas {
        font-family: "DejaVu Sans", "Arial", sans-serif;
    }

</style>