<?php

/**
 * @author Amaury
 * @copyright 2019
 */
$retour = $_GET['soussouscat'];

$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companymanager = $companymanager->getListAllCompanies();


?>
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des sociétés </div>
                <div class="actions">
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/societe/creer'; ?>" class="btn btn-sm grey-mint">
                        <i class="fa fa-plus"></i> Créer </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php if($retour == "errorsuppr") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, la société n'a donc pas pu être supprimée !</div>
                <?php }elseif($retour == "successsuppr"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> La société a bien été supprimée !</div>
                <?php }elseif($retour == "erroractivate") { ?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button> Une erreur est survenue, la société n'a donc pas pu être réactivée !</div>
                <?php }elseif($retour == "errormodif") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, la société n'a donc pas pu être modifiée !</div>
                <?php }elseif($retour == "successmodif"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> La société a bien été modifié !</div>
                <?php }elseif($retour == "error") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, la société n'a donc pas pu être créée !</div>
                <?php }elseif($retour == "success"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> La société a bien été créé !</div>
                <?php }elseif($retour == "successactivate"){ ?>
                <div class="alert alert-success">
                    <button class="close" data-close="alert"></button> La société a bien été réactivée !</div>
                <?php } ?>
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="all">Nom de société</th>
                        <th class="none">Adresse</th>
                        <th class="desktop">Logo</th>
                        <th class="none">Actif</th>
                        <th class="min-tablet">Modifier</th>
                        <th class="min-phone-1">Supprimer / Réactiver</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($companymanager as $company) {

                        if($company->getIsActive() == 1)
                        {
                            $company->setIsActive("Oui");
                        }
                        else {
                            $company->setIsActive("Non");
                        }
                        ?>
                        <tr>
                            <td><?php echo $company->getName(); ?></td>
                            <td><?php echo $company->getAddress(); ?></td>
                            <td>
                                <?php
                                    $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                    $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                ?>
                                <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getNameData();?>" style="max-height: 30px;" />
                            </td>
                            <td><?php echo $company->getIsActive();?></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/societe/modifier/'.$company->getIdcompany();; ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                            <?php
                            if($company->getIsActive() == "Oui")
                            {
                                echo '<td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer la société '.$company->getName().' ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/supprimer_societe.php?idCompany='.$company->getIdcompany().'"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>';
                            }
                            else{
                                echo '<td><a class="btn green-dark" data-placement="top" data-toggle="confirmation" data-title="Reactiver la société '.$company->getName().'?" data-btn-ok-label="Reactiver" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/reactiver_societe.php?idCompany='.$company->getIdcompany().'"><i class="fas fa-toggle-on" alt="Reactiver"></i> Reactiver</a></td>';
                            }
                            ?>
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