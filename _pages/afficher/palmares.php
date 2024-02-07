<?php
/**
 * @author Amaury
 * @copyright 2019
 */

$companyNameData = $_GET["section"];

if(isset($_POST['valider'])) {

    $type = $_POST['type'];

    $datefrom = $_POST["date_from"];
    $dateto = $_POST["date_to"];

    $seller = $_POST["seller"];

    $customerSelected = $_POST["customer"];

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

    if(empty($seller) && empty($datefrom) && empty($customerSelected)){
        if ($type == "devis") {
            $quotations = $quotationmanager->getListQuotation($companyId);
            $typeCost = "D";
            $enteteIcon = '<i class="fas fa-chart-pie"></i>';
        } elseif ($type == "proforma") {
            $quotations = $quotationmanager->getListProforma($companyId);
            $typeCost = "P";
            $enteteIcon = '<i class="fas fa-chart-area"></i>';
        } elseif ($type == "facture") {
            $quotations = $quotationmanager->getListInvoice($companyId);
            $typeCost = "F";
            $enteteIcon = '<i class="fas fa-chart-line"></i>';
        } elseif ($type == "avoir") {
            $quotations = $quotationmanager->getListAsset($companyId);
            $typeCost = "A";
            $enteteIcon = '<i class="fas fa-chart-bar"></i>';
        }
        //$filteredFolder = $foldermanager->getList($companyId);
    }
    elseif(!empty($seller) && empty($datefrom))
    {
        $filteredFolder = $foldermanager->getListByUser($companyId, $seller);
        if ($type == "devis") {
            $quotations = $quotationmanager->getListQuotationByFilteredFolders($filteredFolder,$folder);
            $typeCost = "D";
            $enteteIcon = '<i class="fas fa-chart-pie"></i>';
        } elseif ($type == "proforma") {
            $quotations = $quotationmanager->getListProformaByFilteredFolders($filteredFolder, $folder);
            $typeCost = "P";
            $enteteIcon = '<i class="fas fa-chart-area"></i>';
        } elseif ($type == "facture") {
            $quotations = $quotationmanager->getListInvoiceByFilteredFolders($filteredFolder, $folder);
            $typeCost = "F";
            $enteteIcon = '<i class="fas fa-chart-line"></i>';
        } elseif ($type == "avoir") {
            $quotations = $quotationmanager->getListAssetsByFilteredFolders($filteredFolder, $folder);
            $typeCost = "A";
            $enteteIcon = '<i class="fas fa-chart-bar"></i>';
        }

    }
    elseif(empty($seller) && !empty($datefrom) && empty($customerSelected))
    {
        if ($type == "devis") {
            $quotations = $quotationmanager->getListQuotationByDate($companyId,$datefrom,$dateto);
            $typeCost = "D";
            $enteteIcon = '<i class="fas fa-chart-pie"></i>';
        } elseif ($type == "proforma") {
            $quotations = $quotationmanager->getListProformaByDate($companyId,$datefrom,$dateto);
            $typeCost = "P";
            $enteteIcon = '<i class="fas fa-chart-area"></i>';
        } elseif ($type == "facture") {
            $quotations = $quotationmanager->getListInvoiceByDate($companyId,$datefrom,$dateto);
            $typeCost = "F";
            $enteteIcon = '<i class="fas fa-chart-line"></i>';
        } elseif ($type == "avoir") {
            $quotations = $quotationmanager->getListAssetsByDate($companyId,$datefrom,$datetor);
            $typeCost = "A";
            $enteteIcon = '<i class="fas fa-chart-bar"></i>';
        }
    }   
    elseif (!empty($seller) && !empty($datefrom))
    {
        $filteredFolder = $foldermanager->getListByUser($seller, $companyId);
        if ($type == "devis") {
            $quotations = $quotationmanager->getListQuotationByFilteredFoldersAndDate($filteredFolder,$folder,$datefrom,$dateto);
            $typeCost = "D";
            $enteteIcon = '<i class="fas fa-chart-pie"></i>';
        } elseif ($type == "proforma") {
            $quotations = $quotationmanager->getListProformaByFilteredFoldersAndDate($filteredFolder, $folder,$datefrom,$dateto);
            $typeCost = "P";
            $enteteIcon = '<i class="fas fa-chart-area"></i>';
        } elseif ($type == "facture") {
            $quotations = $quotationmanager->getListInvoiceByFilteredFoldersAndDate($filteredFolder, $folder,$datefrom,$dateto);
            $typeCost = "F";
            $enteteIcon = '<i class="fas fa-chart-line"></i>';
        } elseif ($type == "avoir") {
            $quotations = $quotationmanager->getListAssetsByFilteredFoldersAndDate($filteredFolder, $folder,$datefrom,$dateto);
            $typeCost = "A";
            $enteteIcon = '<i class="fas fa-chart-bar"></i>';
        }

    }
    elseif(empty($seller) && !empty($datefrom) && !empty($customerSelected))
    {
        if ($type == "devis") {
            $quotations = $quotationmanager->getListQuotationByDateAndCustomer($companyId,$datefrom,$dateto,$customerSelected);
            $typeCost = "D";
            $enteteIcon = '<i class="fas fa-chart-pie"></i>';
        } elseif ($type == "proforma") {
            $quotations = $quotationmanager->getListProformaByDateAndCustomer($companyId,$datefrom,$dateto,$customerSelected);
            $typeCost = "P";
            $enteteIcon = '<i class="fas fa-chart-area"></i>';
        } elseif ($type == "facture") {
            $quotations = $quotationmanager->getListInvoiceByDateAndCustomer($companyId,$datefrom,$dateto,$customerSelected);
            $typeCost = "F";
            $enteteIcon = '<i class="fas fa-chart-line"></i>';
        } elseif ($type == "avoir") {
            $quotations = $quotationmanager->getListAssetsByDateAndCustomer($companyId,$datefrom,$datetor,$customerSelected);
            $typeCost = "A";
            $enteteIcon = '<i class="fas fa-chart-bar"></i>';
        }
    }

    //print_r($quotations);

    //récupération des coûts liés au dossier.

    $costs = $costmanager->getCostByFilteredQuotation($quotations,$quotation, $typeCost);
}

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <?php echo $enteteIcon; ?> Palmares des  <?php print ucwords($type); if($type != "devis"){echo "s";}?>  </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="all">Date</th>
                        <th class="desktop">Dossier</th>
                        <th class="desktop">Libellé</th>
                        <th class="none">Numéro de <?php echo $type; ?></th>
                        <th class="min-tablet">Client</th>
                        <th class="min-phone-l">Montant total</th>
                        <th class="min-tablet">Marge</th>
                        <th class="none">Coûts</th>
                        <th class="none">Détail</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($quotations)>0){
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
                            $montant = calculMontantTotalHT($description, $montant);
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

                        $costsFolder = $costsFolder->getByQuotationNumber($quotation->getQuotationNumber(), $quotation->getType(),$companyId);
                        $TotalCostFolder = 0;
                        /*récupérer les cout sur le dossier pour les devis */
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
                    //print_r($InvoiceFolderList);
                    foreach($folderList as $folder){
                        $customer = $customermanager->getById($folder->getCustomerId());
                        //initialisation au format date pour organiser le tableau
                        $date = date('d/m/y', strtotime($folder->getDate()));

                        ?>
                        <tr>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $folder->getFolderNumber(); ?></td>
                            <td><?php echo $folder->getLabel(); ?></td>
                            <td><?php echo $InvoiceFolderList[$folder->getIdFolder()]; ?></td>
                            <td><?php echo $customer->getName(); ?></td>
                            <td><?php echo number_format($TotalPalmaresDossier[$folder->getIdFolder()],0,","," "); ?> XPF</td>
                            <td><?php echo number_format($PercentDossier[$folder->getIdFolder()],0,","," "); ?> %</td>
                            <td><?php echo number_format($TotalCoutDossier[$folder->getIdFolder()],0,","," "); ?> XPF</td>

                            <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/afficher/'.$folder->getIdFolder(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                        </tr>
                        <?php
                    }
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
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="row static-info align-reverse">
            <div class="col-md-8 name"> Total HT : </div>
            <div class="col-md-3 value"> <?php echo number_format($TotalPalmares,0,","," "); ?> XPF</div>
        </div>
    </div>
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="row static-info align-reverse">
            <div class="col-md-8 name"> Total Coûts : </div>
            <div class="col-md-3 value"> <?php echo number_format($TotalCostFolder,0,","," "); ?> XPF</div>
        </div>
    </div>
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="well">
            <div class="row static-info align-reverse">
                <div class="col-md-8 name" style="font-weight: 800; font-size: 16px;"> Marge HT : </div>
                <div class="col-md-3 value" style="font-weight: 800; font-size: 16px;"> <?php echo number_format($TotalMarge,0,","," "); ?> XPF</div>
            </div>
        </div>
    </div>
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="well">
            <div class="row static-info align-reverse">
                <div class="col-md-8 name" style="font-weight: 800; font-size: 16px;"> Marge : </div>
                <div class="col-md-3 value" style="font-weight: 800; font-size: 16px;"> <?php echo number_format($PercentMarge,0,","," "); ?> %</div>
            </div>
        </div>
    </div>
    <form action="<?php echo URLHOST.$_COOKIE['company']."/palmares/".$type."/imprimer"; ?>" target="_blank" method="post" class="form-horizontal form-row-seperated">
        <input type="hidden" id="date_from" name="date_from" value="<?php echo $datefrom; ?>">
        <input type="hidden" id="date_to" name="date_to" value="<?php echo $dateto; ?>">
        <input type="hidden" id="seller" name="seller" value="<?php echo $seller; ?>">
        <input type="hidden" id="customer" name="customer" value="<?php echo $customerSelected; ?>">
        <div class="modal-footer">
            <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn green" name="imprimer">
                <i class="fas fa-print"></i> Imprimer</button>
        </div>
    </form>
</div>