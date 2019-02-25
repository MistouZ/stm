<?php

/**
 * @author Amaury
 * @copyright 2019
 */

include("../../_cfg/cfg.php");

$array = array();
$companyNameData = $_GET["section"];


/*initialisation des objets pour l'affichage*/
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);


/*récupération des objets en base*/
$company = $companymanager->getByNameData($companyNameData);
$foldermanager = $foldermanager->getList($company->getIdcompany());

$user->getFirstName();


?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['section']); ?>  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Numéro de Dossier</th>
                            <th class="min-phone-l">Intitulé du dossier</th>
                            <th class="min-tablet">Client</th>
                            <th class="none">Commercial</th>
                            <th class="none">Contact</th>
                            <th class="none">Statut du dossier</th>
                            <th class="none">Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($foldermanager as $folder)
                    {
                       $customer = $customermanager->getByID($folder->getCustomerId());
                       $user = $usermanager->get($folder->getSeller());
                       $contact = $contactmanager->getById($folder->getContactId());
                        ?>
                        <tr>
                            <td><?php echo $folder->getFolderNumber(); ?></td>
                            <td><?php echo $folder->getLabel();?></td>
                            <td><?php echo $customer->getName(); ?></td>
                            <td><?php echo $user->getName(); ?></td>
                            <td><?php echo $contact->getName()." ".$contact->getFirstname(); ?></td>
                            <td><?php echo $folder->getStatus();?></td>
                            <td><?php echo $folder->getYear()."/".$folder->getMonth()."/".$folder->getDay();?></td>
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