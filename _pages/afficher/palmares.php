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
    $idCompany = $company->getIdcompany();

    if(empty($seller) && empty($datefrom)){
        $filteredFolder = $foldermanager->getList($idCompany);
    }
    elseif(empty($seller))
    {
        $filteredFolder = $foldermanager->getListByDate($idCompany,$datefrom,$dateto);
    }
    elseif(!empty($seller) && empty($datefrom))
    {
        $filteredFolder = $foldermanager->getListByUser($idCompany, $seller);
    }
    elseif (!empty($seller) && !empty($datefrom))
    {
        $filteredFolder = $foldermanager->getListByDateAndUser($idCompany,$seller,$datefrom,$dateto);
    }

    if($type == "devis"){
        $quotations = $quotationmanager->getListQuotationByFilteredFolders($filteredFolder,$folder);
    }
    elseif ($type == "proforma")
    {
        echo $type;
        $quotations = $quotationmanager->getListProformaByFilteredFolders($filteredFolder,$folder);
    }
    elseif ($type == "facture")
    {
        $quotations = $quotationmanager->getListInvoiceByFilteredFolders($filteredFolder,$folder);
    }
    elseif ($type == "avoir")
    {
        echo $type;
        $quotations = $quotationmanager->getListAssetsByFilteredFolders($filteredFolder,$folder);
    }

    //récupération des coûts liés au dossier.

    $costs = $costmanager->getCostByFilteredQuotation($quotations,$quotation);
}

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Palmares des  <?php print ucwords($type); ?>  </div>
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
                        <th class="none">Détail</th>
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

                        //initialisation au format date pour organiser le tableau
                        $date = date('d/m/y', strtotime($quotation->getDate()));

                        $customer = $customermanager->getById($quotation->getCustomerId());

                        $folderQuotation = new Folder($array);
                        $foldermanagerQuotation = new FoldersManager($bdd);

                        $folderQuotation = $foldermanagerQuotation->get($quotation->getFolderId());
                        if($k == 0)
                        {
                            $folderList[$k] = $folderQuotation;
                        }

                        $descriptions = new Description($array);
                        $descriptionmanager = new DescriptionManager($bdd);

                        $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());

                        //Calcul du montant des devis / factures et cumul pour le Palmares
                        $montant = 0;
                        foreach ($descriptions as $description) {
                            $montant = calculMontantTotalTTC($description, $montant);
                            //Calcul du cumul du montant par dossier avec vérification de l'ID pour le cumul
                            if($i == $j && $k == 0 ){
                                $TotalPalmaresDossier[$i] = $montant;
                                $InvoiceFolderList[$i] = $quotation->getQuotationNumber();
                            }
                            elseif($i == $j && $k != 0 ){
                                $TotalPalmaresDossier[$i] = $TotalPalmaresDossier[$i] + $montant;
                                $InvoiceFolderList[$i] = $InvoiceFolderList[$i]." / ".$quotation->getQuotationNumber();
                            }
                            else{
                                $TotalPalmaresDossier[$j] = 0;
                                $TotalPalmaresDossier[$j] = $montant;
                                $folderList[$k] = $folderQuotation;
                                $InvoiceFolderList[$j] = $quotation->getQuotationNumber();
                            }

                        }

                        if($quotation->getStatus() == "En cours"){
                            $status = "cours";
                        }
                        elseif($quotation->getStatus() == "Validated"){
                            $status = "valides";
                        }

                        $TotalPalmares = $TotalPalmares + $montant;


                        $TotalCost = 0;
                        foreach ($costs as $cost) {
                            $TotalCost = calculCoutTotal($cost, $TotalCost);
                        }

                        $costFolder = new Cost($array);
                        $costsFolder = new CostManager($bdd);

                        $costsFolder = $costsFolder->getByFolderId($i);
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
                            $TotalCoutDossier[$j] = 0;
                            $TotalCoutDossier[$j] = $TotalCostFolder;
                        }


                        $TotalMarge = $TotalPalmares - $TotalCost;
                        echo "FolderId :".$i." ".$TotalPalmaresDossier[$i].' - '.$TotalCoutDossier[$i];
                        $TotalMargeDossier[$i] = $TotalPalmaresDossier[$i] - $TotalCoutDossier[$i];
                        $PercentMarge = calculMarge($TotalPalmares, $TotalMarge);
                        $PercentDossier[$i] = calculMarge($TotalPalmaresDossier[$i], $TotalMargeDossier[$i]);
                        $i = $j;
                        $k++;

                    }
                    foreach($folderList as $folder){

                        ?>
                        <tr>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $folder->getFolderNumber(); ?></td>
                            <td><?php echo $folder->getLabel(); ?></td>
                            <td><?php echo $InvoiceFolderList[$folder->getIdFolder()]; ?></td>
                            <!--<td><?php echo $quotation->getQuotationNumber(); ?></td>-->
                            <td><?php echo $customer->getName(); ?></td>
                            <td><?php echo number_format($TotalPalmaresDossier[$folder->getIdFolder()],0,","," "); ?> XPF</td>
                            <td><?php echo number_format($PercentDossier[$folder->getIdFolder()],0,","," "); ?> %</td>
                            <!--<td><?php echo number_format($montant,0,","," "); ?> XPF</td>
                            <td><?php echo number_format($PercentMarge,0,","," "); ?> %</td>-->
                            <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/afficher/'.$folder->getIdFolder(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
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
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="row static-info align-reverse">
            <div class="col-md-8 name"> Total TTC : </div>
            <div class="col-md-3 value"> <?php echo number_format($TotalPalmares,0,","," "); ?> XPF</div>
        </div>
    </div>
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="row static-info align-reverse">
            <div class="col-md-8 name"> Total Coûts : </div>
            <div class="col-md-3 value"> <?php echo number_format($TotalCost,0,","," "); ?> XPF</div>
        </div>
    </div>
    <div class="col-md-6"> </div>
    <div class="col-md-6">
        <div class="well">
            <div class="row static-info align-reverse">
                <div class="col-md-8 name" style="font-weight: 800; font-size: 16px;"> Marge TTC : </div>
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
</div>