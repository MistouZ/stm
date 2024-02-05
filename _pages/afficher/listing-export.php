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
        $companyId = $_POST["societe"];
    }else{
        $companyNameData = $_GET['section'];
        $company = $companymanager->getByNameData($companyNameData);
        $companyId = $company->getIdcompany();
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

     $filteredFolder = $foldermanager->getListByDate($companyId,$datefrom,$dateto);

     if ($type == "export") {
        $quotations = $quotationmanager->getListInvoiceByDate($companyId,$datefrom,$dateto);
        $enteteIcon = '<i class="fas fa-file-export"></i>';
     }
     //récupération des coûts liés au dossier.
 
     $costs = $costmanager->getCostByFilteredQuotation($quotations,$quotation,"F");
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
                            <th class="all">Date</th>
                            <th class="min-phone-l">Numéro de facture</th>
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
                           
                            /**
                             * 
                             * Initialisation des TGC et HT
                             * 
                             */
                             $test_tgc = false;

                             $montantHT = 0;
                             $total_tgc3 = 0;
                             $total_tgc6 = 0;
                             $total_tgc11 = 0;
                             $total_tgc22 = 0;
                             $total_tgc3_HT = 0;
                             $total_tgc6_HT = 0;
                             $total_tgc11_HT = 0;
                             $total_tgc22_HT = 0;
                             $total_sans_taxe = 0;
                             
                            /**
                             *Début de la 1ère ligne
                             * 
                             * Ajout de l'année et du mois de la facture avec le n° de pièce qui recommence à 1 à chaque génération de fichier
                             * Le CO 70 est une constante d'XL COMPTA
                            **/                           
                            $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t";

                            $customer = $customermanager->getById($quotation->getCustomerId());
                            $clt = $customer->getName();
                            
                            //On sépare les différents subaccounts
                            $subaccountsList = explode(", ",$customer->getSubaccount());
                            $i = 0;
                            $subaccounts = array();
                            while ($i < count($subaccountsList))
                            {
                                $subaccountsList2 = explode("_",$subaccountsList[$i] );
                                $j = $subaccountsList2[0];
                                $k = $subaccountsList2[1];
                                $subaccounts[$j] = $k;
                                $i++;
                            }
                            
                            /**
                             * 1ère ligne
                             * 
                             * Ajout des comptes clients et sous-comptes
                            **/
                            $data .= $customer->getAccount()."\t".$subaccounts[$companyId]."\t";

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
                            $descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber(),$quotation->getType(),$companyId);
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

                                /**
                                 * Préparation de la 2ème ligne
                                 * 
                                 * Calcul des montants des taxes et montant avant l'application des taxes
                                **/

                                switch($description->getTax()){
                                    Case 0:
                                        $total_sans_taxe = $total_sans_taxe + $montantLigne;
                                        $test_tgc = true;
                                        break;
                                    Case 0.03:
                                        $total_tgc3_HT = $total_tgc3_HT + $montantLigne;
                                        $total_tgc3 = $total_tgc3 + $taxe;
                                        $test_tgc = true;
                                        break;
                                    Case 0.06:
                                        $total_tgc6_HT = $total_tgc6_HT + $montantLigne;
                                        $total_tgc6 = $total_tgc6 + $taxe;
                                        $test_tgc = true;
                                        break;
                                    Case 0.11:
                                        $total_tgc11_HT = $total_tgc11_HT + $montantLigne;
                                        $total_tgc11 = $total_tgc11 + $taxe;
                                        $test_tgc = true;
                                        break;
                                    Case 0.22:
                                        $total_tgc22_HT = $total_tgc22_HT + $montantLigne;
                                        $total_tgc22 = $total_tgc22 + $taxe;
                                        $test_tgc = true;
                                        break;
                                  }

                                $totalTaxe = $totalTaxe+$taxe;
                                $montantHT = $montantHT+$montantLigne;
                                //$montant = $montant+$montantLigne+$taxe;
                                $montant = calculMontantTotalTTC($description, $montant);
                            }

                            /**
                             * 1ère ligne
                             * 
                             * Ajout de la date, du montant total, du client, du numéro de facture et du numéro de dossier
                            **/
                            $data .= date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t".Round($montant,0)."\t0\t".$client2." F ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()."\t";

                            if ($customer->getModalite() == '30JF'){
                                $date = date("dmY" , mktime(0,0,0,date('m', strtotime($quotation->getDate())),date('d', strtotime($quotation->getDate()))+30,date('Y', strtotime($quotation->getDate()))));
                            } else {
                                $date = date("dmY" , strtotime($quotation->getDate()));
                            }

                            /**
                             * 1ère ligne
                             * 
                             * Ajout des modalités de paiement et de la date de la facture
                             * 
                            **/
                            $data .= "FC\t".$customer->getModalite()."\t".$date."\r\n";
                            
                            /**
                             * 
                             * Fin de la 1ère ligne
                             * 
                            **/
                            
                            /**
                             * 
                             * 2ème ligne à 4ème ligne max -> cumul TGC par tranche
                             * 
                             */

                            for($ligne=1;$ligne<=4;$ligne++){
                                if($total_tgc3!=0 && $ligne == 1){
                                    $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t445714\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc3,0)."\t".$client2." F ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()."\t FC\t\t\t\r\n";
                                }elseif($total_tgc6!=0 && $ligne == 2){
                                    $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t445715\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc6,0)."\t".$client2." F ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()."\t FC\t\t\t\r\n";
                                }elseif($total_tgc11!=0 && $ligne == 3){
                                    $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t445716\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc11,0)."\t".$client2." F ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()."\t FC\t\t\t\r\n";
                                }elseif($total_tgc22!=0 && $ligne == 4){
                                    $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t445717\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc22,0)."\t".$client2." F ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()."\t FC\t\t\t\r\n";
                                }
                            }

                            /**
                             * 
                             * Dernières ou avant dernières lignes -> cumul des montants HT ayant une TGC par tranche
                             * 
                             */

                            if($companyId == '5' || $companyId == '4'){
                                    for($ligne=1;$ligne<=4;$ligne++){
                                        if($total_tgc3!=0 && $ligne == 1){
                                            $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t704001\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc3_HT,0)."\tF ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()." ".$client2."\tFC\t\t\t\r\n";
                                        }elseif($total_tgc6!=0 && $ligne == 2){
                                            $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t704002\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc6_HT,0)."\tF ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()." ".$client2."\tFC\t\t\t\r\n";
                                        }elseif($total_tgc11!=0 && $ligne == 3){
                                            $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t704003\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc11_HT,0)."\tF ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()." ".$client2."\tFC\t\t\t\r\n";
                                        }elseif($total_tgc22!=0 && $ligne == 4){
                                            $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t704004\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_tgc22_HT,0)."\tF ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()." ".$client2."\tFC\t\t\t\r\n";
                                        }
                                    }
                            }else{
                                    $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t704000\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($montantHT,0)."\tF ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()." ".$client2."\tFC\t\t\t\r\n";
                            }

                            /**
                             * 
                             * Dernière ligne sur les descriptions hors taxe (pas de TGC appliquée)
                             * 
                             */
                            if($total_sans_taxe != 0){
                                if(($companyId == '5') || ($companyId =='4')){
                                    $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t704005\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_sans_taxe,0)."\tF ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()." ".$client2."\tFC\t\t\r\n";
                                }else{
                                    $data .= "CO\t70\t".date('Y', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."\t".$piece."\t707000\t\t".date('d', strtotime($quotation->getDate()))."".date('m', strtotime($quotation->getDate()))."".date('Y', strtotime($quotation->getDate()))."\t0\t".Round($total_sans_taxe,0)."\tF ".$quotation->getQuotationNumber()." D ".$folder->getFolderNumber()." ".$client2."\tFC\t\t\r\n";
                                }
                            }

                            
                              
                              $date = date('d/m/y', strtotime($quotation->getDate()));

                            ?>
                            <tr>
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
                            $piece++;
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
     <form action="" target="_blank" method="post" class="form-horizontal form-row-seperated">
         <input type="hidden" id="date_from" name="date_from" value="<?php echo $datefrom; ?>">
         <input type="hidden" id="date_to" name="date_to" value="<?php echo $dateto; ?>">
         <input type="hidden" id="seller" name="seller" value="<?php echo $seller; ?>">
         <div class="modal-footer">
             <button type="button" class="btn grey-salsa btn-outline" onclick="history.go(-1)">Fermer</button>
             <button type="submit" class="btn green" name="telecharger" onclick="window.location.href='<?php echo URLHOST."_pages/_post/dl_export.php?path=".__DIR__."/export/MVTECO".$date2.".txt"; ?>';">
                <i class="fas fa-file-export"></i> Télécharger MVTECO</button>
         </div>
     </form>
 </div>