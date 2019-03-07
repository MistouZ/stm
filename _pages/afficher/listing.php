<?php

/**
 * @author Nicolas
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

$array = array();
$companyNameData = $_GET["section"];

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

$quotations = $quotationmanager->getListQuotation($company->getIdcompany());


?>
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['cat']); ?>  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro de devis</th>
                            <th class="min-tablet">Client</th>
                            <th class="none">Dossier</th>
                            <th class="none">Libellé</th>
                            <th class="none">Montant total</th>
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
                                echo "montant ligne : ".$montantLigne." / taxe : ".$taxe." remise : ".$remise;
                            }
                        ?>
                        <tr>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $quotation->getQuotationNumber(); ?></td>
                            <td><?php echo $customer->getName(); ?></td>
                            <td><?php echo $folder->getFolderNumber(); ?></td>
                            <td><?php echo $folder->getLabel(); ?></td>
                            <td><?php echo $montant; ?></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/devis/modifier/'.$quotation->getQuotationNumber(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                            <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le dossier n° '.$folder->getFolderNumber().' ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo URLHOST.'_pages/_post/supprimer_dossier.php?idFolder='.$folder->getIdFolder(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
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
</html>