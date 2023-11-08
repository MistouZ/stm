<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");
$companyNameData = $_GET["section"];

if(isset($_POST['imprimer'])) {

    $type = "devis";

    $datefrom = $_POST["date_from"];
    $dateto = $_POST["date_to"];

    $seller = $_POST["seller"];

    $array = array();
    /*initilisation des objets */
    $company = new Company($array);
    $companymanager = new CompaniesManager($bdd);

    $user = new Users($array);
    $usermanager = new UsersManager($bdd);

    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);

    $quotation = new Quotation($array);
    $quotationmanager = new QuotationManager($bdd);

    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);

    $cost = new Cost($array);
    $costmanager = new CostManager($bdd);

    $company = $companymanager->getByNameData($companyNameData);
    $companyId = $company->getIdcompany();

    if (empty($seller) && empty($datefrom)) {
        $filteredFolder = $foldermanager->getList($companyId);
    } elseif (empty($seller)) {
        $filteredFolder = $foldermanager->getListByDate($companyId, $datefrom, $dateto);
    } elseif (!empty($seller) && empty($datefrom)) {
        $filteredFolder = $foldermanager->getListByUser($companyId, $seller);
    } elseif (!empty($seller) && !empty($datefrom)) {
        $filteredFolder = $foldermanager->getListByDateAndUser($companyId, $seller, $datefrom, $dateto);
    }

    if ($type == "devis") {
        $quotations = $quotationmanager->getListQuotationByFilteredFolders($filteredFolder, $folder);
        $costType = "D";
        $enteteIcon = '<i class="fas fa-chart-pie"></i>';
    } elseif ($type == "proforma") {
        $quotations = $quotationmanager->getListProformaByFilteredFolders($filteredFolder, $folder);
        $costType = "P";
        $enteteIcon = '<i class="fas fa-chart-area"></i>';
    } elseif ($type == "facture") {
        $quotations = $quotationmanager->getListInvoiceByFilteredFolders($filteredFolder, $folder);
        $costType = "F";
        $enteteIcon = '<i class="fas fa-chart-line"></i>';
    } elseif ($type == "avoir") {
        $quotations = $quotationmanager->getListAssetsByFilteredFolders($filteredFolder, $folder);
        $costType = "A";
        $enteteIcon = '<i class="fas fa-chart-bar"></i>';
    }


//récupération des coûts liés au dossier.

    $costs = $costmanager->getCostByFilteredQuotation($quotations, $quotation, $costType);
}
?>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div id="myCanvas">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet green box">
                    <div class="portlet-title">
                        <div class="caption">
                            <?php echo $enteteIcon; ?> <span style="margin-left: 15px">Palmares des  <?php print ucwords($type); if($type != "devis"){echo "s";}?></span>  </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" cellspacing="0" >
                            <thead>
                            <tr>
                                <th class="col-md-1">Date</th>
                                <th class="col-md-1">Dossier</th>
                                <th class="col-md-4">Libellé</th>
                                <th >Client</th>
                                <th >Montant total</th>
                                <th >Coûts</th>
                                <th class="col-md-1">Marge</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            //Initialisation des valueurs pour le premier dossier
                            $k = 0;
                            $TotalPalmares = 0;
                            $i = $quotations[$k]->getFolderId();
                            $TotalPalmaresDossier[$k] = 0;
                            $TotalCoutDossier[$k] = 0;
                            $InvoiceFolderList[$k] = "";
                            foreach($quotations as $quotation){
                                $j = $quotation->getFolderId();

                                // $customer = $customermanager->getById($quotation->getCustomerId());

                                $folderQuotation = new Folder($array);
                                $foldermanagerQuotation = new FoldersManager($bdd);

                                $folderQuotation = $foldermanagerQuotation->get($quotation->getFolderId());
                                if($k == 0)
                                {
                                    $folderList[$k] = $folderQuotation;
                                }


                                if($quotation->getStatus() == "En cours"){
                                    $status = "cours";
                                }
                                elseif($quotation->getStatus() == "Validated"){
                                    $status = "valides";
                                }

                                if($i == $j && $k == 0 ){
                                    $InvoiceFolderList[$i] = '<a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/afficher/'.$status.'/'.$quotation->getQuotationNumber().'">'. $quotation->getQuotationNumber().' </>';
                                }
                                elseif($i == $j && $k != 0 ){
                                    $InvoiceFolderList[$i] = $InvoiceFolderList[$i]." / ".'<a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/afficher/'.$status.'/'.$quotation->getQuotationNumber().'">'. $quotation->getQuotationNumber().' </>';
                                }
                                else{
                                    $folderList[$k] = $folderQuotation;
                                    $InvoiceFolderList[$j] = '<a href="'.URLHOST.$_COOKIE['company'].'/'.$type.'/afficher/'.$status.'/'.$quotation->getQuotationNumber().'">'. $quotation->getQuotationNumber().'</>';
                                }


                                $descriptions = new Description($array);
                                $descriptionmanager = new DescriptionManager($bdd);

                                $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(), $quotation->getType(),$companyId);

                                //Calcul du montant des devis / factures et cumul pour le Palmares
                                $montant = 0;
                                foreach ($descriptions as $description) {
                                    $montant = calculMontantTotalTTC($description, $montant);
                                }

                                //Calcul du cumul du montant par dossier avec vérification de l'ID pour le cumul
                                if($i == $j && $k == 0 ){
                                    $TotalPalmaresDossier[$i] = $montant;
                                }
                                elseif($i == $j && $k != 0 ){
                                    $TotalPalmaresDossier[$i] = $TotalPalmaresDossier[$i] + $montant;
                                }
                                else{
                                    $TotalPalmaresDossier[$j] = 0;
                                    $TotalPalmaresDossier[$j] = $montant;
                                }


                                $TotalPalmares = $TotalPalmares + $montant;
                                $TotalCost = 0;

                                foreach ($costs as $cost) {
                                    $TotalCost = calculCoutTotal($cost, $TotalCost);
                                }

                                $costFolder = new Cost($array);
                                $costsFolder = new CostManager($bdd);

                                $costsFolder = $costsFolder->getByFolderId($j);
                                $TotalCostFolder = 0;
                                /*récupérer les cout sur le dossier */
                                foreach ($costsFolder as $costFolder) {
                                    $TotalCostFolder = calculCoutTotal($costFolder, $TotalCostFolder);
                                }
                                if($i == $j && $k == 0){
                                    $TotalCoutDossier[$i] = $TotalCostFolder;
                                }
                                elseif($i == $j && $k != 0 ){
                                    $TotalCoutDossier[$i] = $TotalCoutDossier[$i] + $TotalCostFolder;
                                }
                                else{
                                    $i = $j;
                                    $TotalCoutDossier[$i] = 0;
                                    $TotalCoutDossier[$i] = $TotalCostFolder;
                                }

                                $TotalMarge = $TotalPalmares - $TotalCost;
                                $TotalMargeDossier[$i] = $TotalPalmaresDossier[$i] - $TotalCoutDossier[$i];
                                $PercentMarge = calculMarge($TotalPalmares, $TotalMarge);
                                $PercentDossier[$i] = calculMarge($TotalPalmaresDossier[$i], $TotalMargeDossier[$i]);
                                $i = $j;
                                $k++;

                            }
                            foreach($folderList as $folder){
                                $customer = $customermanager->getById($folder->getCustomerId());
                                //initialisation au format date pour organiser le tableau
                                $date = date('d/m/y', strtotime($folder->getDate()));

                                ?>
                                <tr>
                                    <td class="col-md-1"><?php echo $date; ?></td>
                                    <td class="col-md-1"><?php echo $folder->getFolderNumber(); ?></td>
                                    <td class="col-md-4"><?php echo $folder->getLabel(); ?></td>
                                    <td><?php echo $customer->getName(); ?></td>
                                    <td><?php echo number_format($TotalPalmaresDossier[$folder->getIdFolder()],0,","," "); ?> XPF</td>
                                    <td><?php echo number_format($TotalCoutDossier[$folder->getIdFolder()],0,","," "); ?> XPF</td>
                                    <td class="col-md-1"><?php echo number_format($PercentDossier[$folder->getIdFolder()],0,","," "); ?> %</td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-7">
                <div class="well">
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name"> Total TTC :  </div>
                        <div class="col-md-6 value"> <?php echo number_format($TotalPalmares,0,","," "); ?> XPF</div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name"> Total Coûts : </div>
                        <div class="col-md-6 value"> <?php echo number_format($TotalCost,0,","," "); ?> XPF</div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name"> Marge TTC : </div>
                        <div class="col-md-6 value"> <?php echo number_format($TotalMarge,0,","," "); ?> XPF</div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name"> Marge : </div>
                        <div class="col-md-6 value"> <?php echo number_format($PercentMarge,0,","," "); ?> %</div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-6 name"> Marge : </div>
                        <div class="col-md-6 value"> <?php echo number_format($totalTaxe,0,","," "); ?> XPF</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="filename" name="filename" value="<?php echo "analyse des couts - ".$companyNameData. "-".$datefrom."-".$dateto; ?>">
    <button id="Exporter" onclick="ExportPdf()">Exporter</button>
</div>

<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.default-v2.min.css"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.common-boostrap.min.css"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.boostrap.min.css"></script>
src="
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
        <div class="header" >
            <img src="<?php echo URLHOST; ?>images/societe/<?php echo $companyNameData; ?>.jpg" alt="<?php echo $companyNameData; ?>" class="logo-default" style="max-height: 60px;" />
        </div>
        <div class="footer">
            <h5> #:pageNum# / #:totalPages# </h5>
            <img src="<?php echo URLHOST; ?>images/footer/<?php echo $companyNameData; ?>.jpg" alt="<?php echo $companyNameData; ?>" class="logo-default" style="max-height: 40px;" />
        </div>
    </div>
</script>
<script type="text/javascript" language="javascript">

    window.onload = function() {
        document.getElementById('Exporter').click();
    }

    function closeWindow() {
        setTimeout(function() {
            window.close();
        }, 300); // 300 pour NC sur serveur MLS
    }

    function ExportPdf(){
        var filename = document.getElementById("filename").value;
        kendo.drawing
            .drawDOM("#myCanvas",
                {
                    paperSize: "A4",
                    landscape: true,
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
        border-bottom: 1px solid #000;
        text-align: center;
    }
    .page-template .footer {
        bottom: 20px;
        border-top: 1px solid #000;
        text-align: center;
    }

    /* utiliastion du FontAwesome pour l'impression des icones */

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