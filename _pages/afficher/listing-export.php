<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
$array = array();

 $company = new Company($array);
 $companymanager = new CompaniesManager($bdd);

 if(isset($_POST['valider'])) {
    if(isset($_POST["societe"])){
        $idCompany = $_POST["societe"];
    }else{
        $companyNameData = $_GET['section'];
        $company = $companymanager->getByNameData($companyNameData);
        $idCompany = $company->getIdcompany();
    }
    
     $type = $_POST['type'];

     $datefrom = $_POST["date_from"];
     $dateto = $_POST["date_to"];

     /*initilisation des objets */
 
     $user = new Users($array);
     $usermanager = new UsersManager($bdd);
 
     $folder = new Folder($array);
     $foldermanager = new FoldersManager($bdd);
 
     $quotation = new Quotation($array);
     $quotationmanager = new QuotationManager($bdd);

     $tax = new Tax($array);
     $taxmanager = new TaxManager($bdd);
 
     $customer = new Customers($array);
     $customermanager = new CustomersManager($bdd);
 
     $cost = new Cost($array);
     $costmanager = new CostManager($bdd);

     $filteredFolder = $foldermanager->getListByDate($idCompany,$datefrom,$dateto);

     if ($type == "export") {
        $quotations = $quotationmanager->getListInvoiceByDate($idCompany,$datefrom,$dateto);
        $enteteIcon = '<i class="fas fa-file-export"></i>';
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
                     <?php echo $enteteIcon; ?> Liste des factures pour l'export</div>
             </div>
             <div class="portlet-body">
             <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th style="text-align: center !important;" class="desktop"><input id="select-all" type="checkbox" title="Sélectionner / Désélectionner tout" /></th>
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro de <?php echo $type; ?></th>
                            <th class="min-tablet">Client</th>
                            <th class="desktop">Dossier</th>
                            <th class="desktop">Libellé</th>
                            <th class="none">Montant total</th>
                            <th class="desktop">Détail</th>
                            <th class="desktop">Supprimer</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        /**
                         * Génération du fichier txt MVTECO
                         */
                        $piece =1;
                        $data = "";

                        foreach($quotations as $quotation){
                           
                            //initialisation au format date pour organiser le tableau
                            $date = date('d/m/y', strtotime($quotation->getDate()));

                            $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t";

                            $customer = $customermanager->getById($quotation->getCustomerId());
                            $clt = $customer->getName();
                            $client = STR_replace("é","E",$clt);
                            $client = STR_replace("è","E",$client);
                            $client = STR_replace("ê","E",$client);
                            $client = STR_replace("à","A",$client);
                            $client = STR_replace("â","A",$client);
                            $client = STR_replace("ù","U",$client);
                            $client = STR_replace("û","U",$client);
                            $client = STR_replace("ô","O",$client);
                            $client2 = STRTOUPPER($client);

                            $folder = $foldermanager->get($quotation->getFolderId());
                            $descriptions = new Description($array);
                            $descriptionmanager = new DescriptionManager($bdd);
                            $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$quotation->getType());
                            $montant = 0;
                            $arrayTaxesKey =  array();
                            foreach ($descriptions as $description) {
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
                                //$montant = $montant+$montantLigne+$taxe;
                                $montant = calculMontantTotalTTC($description, $montant);
                            }
                            $data .= date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t".Round($montant,0)."\t0\t".$client2." F ".$quotation->getQuotationNumber()." D ";
                            $data .= $folder->getFolderNumber()."\t";

                            if ($customer->getModalite() == '30JF'){
                                $date = date("dmY" , mktime(0,0,0,date('m', strtotime($quotation->getDate())),date('d', strtotime($quotation->getDate()))+30,date('Y', strtotime($quotation->getDate()))));
                            } else {
                                $date = date("dmY" , strtotime($quotation->getDate()));
                            }
                            $data .= "FC\t".$customer->getModalite()."\t".$date."\r\n";
                            ?>
                            <tr>
                                <td><input class="selection" type="checkbox" name="selection[]" value="<?php echo $quotation->getQuotationNumber(); ?>" /></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $quotation->getQuotationNumber(); ?></td>
                                <td><?php echo $customer->getName(); ?></td>
                                <td><?php echo $folder->getFolderNumber(); ?></td>
                                <td><?php echo $folder->getLabel(); ?></td>
                                <td><?php echo number_format($montant,0,","," "); ?> XPF</td>
                                <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/facture/afficher/'.$quotation->getType().'/'.$quotation->getQuotationNumber(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer <?php echo $type; ?> n° <?php echo $quotation->getQuotationNumber(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo URLHOST.'_pages/_post/supprimer_devis.php?idQuotation='.$quotation->getIdQuotation().'&quotationNumber='.$quotation->getQuotationNumber().'&type='.$type; ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
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
     <?php

         //$data = "coucou !";
 
         $jour = date('d');
         $mois = date('m');
         $annee = date('Y');
         
         $date2 = $annee."".$mois."".$jour;
        
         $fichier = __DIR__."/export/MVTECO".$date2.".txt";
        
         if(file_exists($fichier)){
             unlink($fichier) ;
         }
        
         $fp = fopen (__DIR__."/export/MVTECO".$date2.".txt", "w+");
         fseek ($fp, 0);
         fputs ($fp, $data);
         fclose ($fp);
     ?>
     <form action="<?php echo URLHOST.$_COOKIE['company']."/palmares/".$type."/imprimer"; ?>" target="_blank" method="post" class="form-horizontal form-row-seperated">
         <input type="hidden" id="date_from" name="date_from" value="<?php echo $datefrom; ?>">
         <input type="hidden" id="date_to" name="date_to" value="<?php echo $dateto; ?>">
         <input type="hidden" id="seller" name="seller" value="<?php echo $seller; ?>">
         <div class="modal-footer">
             <button type="button" class="btn grey-salsa btn-outline" data-dismiss="modal">Fermer</button>
             <button type="submit" class="btn green" name="imprimer">
                 <i class="fas fa-print"></i> Imprimer</button>
         </div>
     </form>
 </div>