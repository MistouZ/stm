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

$dateToProforma = date('d/m/Y');

switch($type){
    case "devis":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation);
        $entete = "du devis";
        $enteteIcon = '<i class="fas fa-file-invoice"></i>';
        $buttons = '<div class="actions">
                        <a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/modifier/'.$type2.'/'.$quotation->getQuotationNumber().'" class="btn btn-default btn-sm">
                            <i class="fas fa-edit"></i> Modifier </a>
                        <a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/imprimer/'.$type2.'/'.$quotation->getQuotationNumber().'" class="btn btn-default btn-sm">
                            <i class="fas fa-print"></i> Imprimer </a>
                        <a data-toggle="modal" href="#to_proforma" class="btn btn-default btn-sm">
                            <i class="fas fa-file-alt"></i> => Proforma </a>
                        <a data-toggle="modal" href="#to_facture" class="btn btn-default btn-sm">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                        <!--<a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/dupliquer/'.$quotation->getQuotationNumber().'" class="btn btn-default btn-sm">
                            <i class="fas fa-edit"></i> Dupliquer </a>-->
                            <a href="'.URLHOST.'_pages/_post/dupliquer_devis.php?quotationNumber='.$quotation->getQuotationNumber().'" class="btn btn-default btn-sm">
                            <i class="fas fa-edit"></i> Dupliquer </a>
                    </div>';
        break;
    case "proforma":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation);
        $entete = "de la proforma";
        $enteteIcon = '<i class="fas fa-file-alt"></i>';
        $buttons = '<div class="actions">
                        <a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/imprimer/'.$type2.'/'.$quotation->getQuotationNumber().'" class="btn btn-default btn-sm">
                            <i class="fas fa-print"></i> Imprimer </a>
                        <a data-toggle="modal" href="#to_facture" class="btn btn-default btn-sm">
                            <i class="fas fa-file-invoice-dollar"></i> => Facture </a>
                        <a data-toggle="modal" href="#to_devis" class="btn btn-default btn-sm">
                            <i class="fas fa-file-invoice"></i> => Devis </a>
                    </div>';
        break;
    case "facture":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation);
        $entete = "de la facture";
        $enteteIcon = '<i class="fas fa-file-invoice-dollar"></i>';
        $buttons = '<div class="actions">
                        <a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/imprimer/'.$type2.'/'.$quotation->getQuotationNumber().'" class="btn btn-default btn-sm">
                            <i class="fas fa-print"></i> Imprimer </a>
                        <a data-toggle="modal" href="#to_avoir" class="btn btn-default btn-sm">
                            <i class="fas fa-file-prescription"></i> => Avoir </a>
                        <a data-toggle="modal" href="#to_devis" class="btn btn-default btn-sm">
                            <i class="fas fa-file-invoice"></i> => Devis </a>
                    </div>';
        break;
    case "avoir":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation);
        $entete = "de l'avoir";
        $enteteIcon = '<i class="fas fa-file-prescription"></i>';
        $buttons = '<div class="actions">
                        <a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/imprimer/'.$type2.'/'.$quotation->getQuotationNumber().'" class="btn btn-default btn-sm">
                            <i class="fas fa-print"></i> Imprimer </a>
                    </div>';
        break;
}
$folder = $foldermanager->get($quotation->getFolderId());
$company = $companymanager->getByNameData($companyNameData);
$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());
$contact = $contactmanager->getById($folder->getContactId());
$user = $usermanager->get($folder->getSeller());
$customer = $customermanager->getById($quotation->getCustomerId());
if($quotation->getType() == "S")
{
    $shatteredQuotation = $shatteredManager->getByQuotationNumberChild($quotation->getQuotationNumber());
}

$date = date('d/m/Y',strtotime(str_replace('/','-',"".$quotation->getDay().'/'.$quotation->getMonth().'/'.$quotation->getYear()."")));

?>
<div class="row">
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
                            <div class="col-md-7 value"> <?php echo $quotation->getQuotationNumber(); ?></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Date: </div>
                            <div class="col-md-7 value"> <?php echo $date; ?> <a data-toggle="modal" href="#modif_date" ><i class="fas fa-edit"></i></a></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Dossier N°: </div>
                            <div class="col-md-7 value"><?php echo $folder->getFolderNumber(); ?></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Libellé : </div>
                            <div class="col-md-7 value"> <?php echo $folder->getLabel(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Commercial : </div>
                            <div class="col-md-7 value"> <?php echo $user->getName().' '.$user->getFirstName(); ?> </div>
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
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet grey-cascade box">
                    <div class="portlet-title">
                        <div class="caption">
                            <?php echo $enteteIcon; ?> Détail <?php echo $entete; ?> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-sm-5"> Description </th>
                                        <th class="col-sm-3"> Prix à l'unité </th>
                                        <th class="col-sm-1"> QT. </th>
                                        <th class="col-sm-1"> Taxe </th>
                                        <th class="col-sm-1"> Remise </th>
                                        <th class="col-sm-3"> Prix total HT </th>
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
                                            if(isset($arrayTaxesKey[$description->getTax()])){
                                                $arrayTaxesKey[$description->getTax()]["Montant"] = $arrayTaxesKey[$description->getTax()]["Montant"]+$taxe;
                                            }else{
                                                $arrayTaxesKey[$description->getTax()]['Taxe']=$tax->getName();
                                                $arrayTaxesKey[$description->getTax()]['Montant']=$taxe;
                                            }

                                            $totalTaxe = $totalTaxe+$taxe;
                                            $montantHT = $montantHT+$montantLigne;
                                            $montant = $montant+$montantLigne+$taxe;
                                        ?>
                                        <tr>
                                            <td><?php echo $description->getDescription(); ?></td>
                                            <td><?php echo number_format($description->getPrice(),0,","," "); ?> XPF</td>
                                            <td><?php echo $description->getQuantity(); ?></td>
                                            <td><?php echo $description->getTax()*100; ?> %</td>
                                            <td><?php echo $description->getDiscount(); ?> %</td>
                                            <td><?php echo number_format($montantLigne,0,","," "); ?> XPF</td>
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
            <div class="col-md-6"> </div>
            <div class="col-md-6">
                <div class="well">
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Sous-total: </div>
                        <div class="col-md-3 value"> <?php echo number_format($montantHT,0,","," "); ?> XPF</div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Total taxes : </div>
                        <div class="col-md-3 value"> <?php echo number_format($totalTaxe,0,","," "); ?> XPF</div>
                    </div>
                    <?php 
                        foreach($arrayTaxesKey as $key => $value){ 
                            if($arrayTaxesKey[$key]["Montant"]>0){
                    ?>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name" style="font-size: 11px; font-style: italic;"> <?php echo $arrayTaxesKey[$key]["Taxe"]; ?> : </div>
                        <div class="col-md-3 value" style="font-size: 11px; font-style: italic;"> <?php echo number_format($arrayTaxesKey[$key]["Montant"],0,","," "); ?> XPF</div>
                    </div>
                    <?php }} ?>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name" style="font-weight: 800; font-size: 16px;"> Total TTC : </div>
                        <div class="col-md-3 value" style="font-weight: 800; font-size: 16px;"> <?php echo number_format($montant,0,","," "); ?> XPF</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button onclick="ExportPdf()">Exporter</button>
<script src="https://kendo.cdn.telerik.com/2019.2.619/js/jquery.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2019.2.619/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2019.2.619/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2019.2.619/styles/kendo.common-material.min.css"></script>
<script src="https://kendo.cdn.telerik.com/2019.2.619/styles/kendo.material.min.css"></script>

<script>
    // Import DejaVu Sans font for embedding
    kendo.pdf.defineFont({
        "DejaVu Sans":
            "http://cdn.kendostatic.com/2019.2.619/styles/fonts/DejaVu/DejaVuSans.ttf",

        "DejaVu Sans|Bold":
            "http://cdn.kendostatic.com/2019.2.619/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",

        "DejaVu Sans|Bold|Italic":
            "http://cdn.kendostatic.com/2019.2.619/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",

        "DejaVu Sans|Italic":
            "http://cdn.kendostatic.com/2019.2.619/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf"
    });
</script>
<script type="x/kendo-template" id="page-template">
    <div class="page-template">
        <div class="header">
            <img src="<?php echo URLHOST; ?>images/societe/<?php echo $companyNameData; ?>.jpg" alt="<?php echo $companyNameData; ?>" class="logo-default" style="max-height: 40px;" />
        </div>
        <div class="footer" style="text-align: center">

            <h2> #:pageNum# </h2> //footer has the page count
        </div>
    </div>
</script>
<script>
    function ExportPdf(){
        kendo.drawing
            .drawDOM("#myCanvas",
                {
                    font: "'DejaVu Sans'",
                    paperSize: "A4",
                    multiPage : true,
                    margin: { top: "1cm", bottom: "2cm", right: "1cm", left: "1cm" },
                    scale: 0.75,
                    height: 500,
                    template: $("#page-template").html(),
                    keepTogether: ".prevent-split"
                })
            .then(function(group){
                kendo.drawing.pdf.saveAs(group, "Exported.pdf")
            });
    }
</script>