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

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['cat']); ?>s  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Numéro de Dossier</th>
                            <th class="min-phone-l">Intitulé du dossier</th>
                            <th class="min-tablet">Client</th>
                            <th class="min-tablet">Modifier</th>
                            <th class="min-tablet">Supprimer</th>
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
                        if($folder->getIsActive() == 1)
                        {
                            $folder->setIsActive("Ouvert");
                            $label = "success";
                        }
                        elseif($folder->getIsActive() == 0)
                        {
                            $folder->setIsActive("Fermé");
                            $label = "danger";
                        }
                        ?>
                        <tr>
                            <td><?php echo $folder->getFolderNumber(); ?></td>
                            <td><?php echo $folder->getLabel();?></td>
                            <td><?php echo $customer->getName(); ?></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/modifier/'.$folder->getIdFolder(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                            <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le dossier n° <?php echo $folder->getFolderNumber(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo  URLHOST."_pages/_post/supprimer_dossier.php?idCustomer=".$folder->getIdFolder(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                            <td><?php echo $user->getName()." ".$user->getFirstName(); ?></td>
                            <td><?php echo $contact->getName()." ".$contact->getFirstname(); ?></td>
                            <td><span class="label label-<?php echo $label; ?>" ><?php echo $folder->getIsActive();?></span></td>
                            <td><?php echo $folder->getDay()."/".$folder->getMonth()."/".$folder->getYear();?></td>
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
<?php

?>