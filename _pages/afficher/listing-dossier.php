<?php

/**
 * @author Amaury
 * @copyright 2019
 */

 require_once("_cfg/cfg.php");

$array = array();
$companyNameData = $_GET["section"];
$retour = $_GET['soussouscat'];


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

$credential = $userlogged->getCredential();
/*récupération des objets en base*/
$company = $companymanager->getByNameData($companyNameData);
if($credential == "A"){
    $foldermanager = $foldermanager->getList($company->getIdcompany());
}
else{
    $foldermanager = $foldermanager->getListActive($company->getIdcompany());
}

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['cat']); ?>s  </div>
                <div class="actions">
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/creer'; ?>" class="btn btn-sm grey-mint">
                        <i class="fa fa-plus"></i> Créer </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php if($retour == "errorsuppr") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le dossier n'a donc pas pu être supprimé !</div>
                <?php }elseif($retour == "successsuppr"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le dossier a bien été supprimé !</div>
                <?php }elseif($retour == "errormodif") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le dossier n'a donc pas pu être modifié !</div>
                <?php }elseif($retour == "erroractivate") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le dossier n'a donc pas pu être réactivé !</div>
                <?php }elseif($retour == "successmodif"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le dossier a bien été modifié !</div>
                <?php }elseif($retour == "successactivate"){ ?>
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button> Le dossier a bien été réactivé !</div>
                <?php }elseif($retour == "error") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le dossier n'a donc pas pu être créé !</div>
                <?php }elseif($retour == "success"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le dossier a bien été créé !</div>
                <?php } ?>
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all"></th>
                            <th class="all">Numéro de Dossier</th>
                            <th class="min-phone-l">Intitulé du dossier</th>
                            <th class="min-tablet">Client</th>
                            <th class="desktop">Afficher</th>
                            <th class="min-tablet">Modifier</th>
                            <?php if($credential == "A"){
                                echo "<th class=\"min-tablet\">Supprimer / Réactiver</th>";
                            }
                            else{
                                echo "<th class=\"min-tablet\">Supprimer</th>";
                             }?>
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
                       //$customer = $customermanager->getByID($folder->getCustomerId());
                       //$user = $usermanager->get($folder->getSeller());
                       //$contact = $contactmanager->getById($folder->getContactId());
                        if($folder->getIsActive() == 1)
                        {
                            $actif = "Ouvert";
                            $label = "success";
                        }
                        elseif($folder->getIsActive() == 0)
                        {
                            $actif = "Fermé";
                            $label = "danger";
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td><?php echo $folder->getFolderNumber(); ?></td>
                            <td><?php echo $folder->getLabel();?></td>
                            <td><?php echo //$customer->getName(); ?></td>
                            <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/afficher/'.$folder->getIdFolder(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/dossier/modifier/'.$folder->getIdFolder(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                            <?php
                            if($folder->getIsActive() == 1)
                            {
                                echo '<td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le dossier n° '.$folder->getFolderNumber().' ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/supprimer_dossier.php?idFolder='.$folder->getIdFolder().'"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>';
                            }
                            elseif($folder->getIsActive() == 0 && $credential == 'A')
                            {
                                echo '<td><a class="btn green-dark" data-placement="top" data-toggle="confirmation" data-title="Reactiver le dossier '.$folder->getFolderNumber().'?" data-btn-ok-label="Reactiver" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/reactiver_dossier.php?idFolder='.$folder->getIdFolder().'"><i class="fas fa-toggle-on" alt="Reactiver"></i> Reactiver</a></td>';
                            }
                            ?>
                            <td><?php echo //$user->getName().' '.$user->getFirstName(); ?></td>
                            <td><?php echo //$contact->getFirstname()." ".$contact->getName(); ?></td>
                            <td><span class="label label-<?php echo $label; ?>" ><?php echo $actif;?></span></td>
                            <td><?php echo  $date = date('d/m/y', strtotime( $folder->getDate()));;?></td>
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