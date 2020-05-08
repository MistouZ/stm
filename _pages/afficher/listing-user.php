<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$retour = $_GET['soussouscat'];

$array = array();
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$usermanager = $usermanager->getAllUsers();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companies = $companymanager->getList();

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des utilisateurs  </div>
                <div class="actions">
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/user/creer'; ?>" class="btn btn-sm grey-mint">
                        <i class="fa fa-plus"></i> Créer </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php if($retour == "errorsuppr") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, l'utilisateur n'a donc pas pu être supprimé !</div>
                <?php }elseif($retour == "successsuppr"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> L'utilisateur a bien été supprimé !</div>
                <?php }elseif($retour == "erroractivate") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, l'utilisateur n'a donc pas pu être réactivé !</div>
                <?php }elseif($retour == "errormodif") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, l'utilisateur n'a donc pas pu être modifié !</div>
                <?php }elseif($retour == "successmodif"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> L'utilisateur a bien été modifié !</div>
                <?php }elseif($retour == "error") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, l'utilisateur n'a donc pas pu être créé !</div>
                <?php }elseif($retour == "success"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> L'utilisateur a bien été créé !</div>
                <?php }elseif($retour == "successactivate"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> L'utilisateur a bien été réactivé !</div>
                <?php } ?>
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Login</th>
                            <th class="desktop">Prénom</th>
                            <th class="desktop">Nom</th>
                            <th class="desktop">Adresse email</th>
                            <th class="none">Numéro de téléphone</th>
                            <th class="none">Accréditation</th>
                            <th class="desktop">Société par défaut</th>
                            <th class="none">Sociétés affiliées</th>
                            <th class="none">Commercial</th>
                            <th class="none">Actif</th>
                            <th class="min-tablet">Modifier</th>
                            <th class="min-phone-l">Supprimer / Réactiver</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($usermanager as $user) {
                        $company = $companymanager->getById($user->getDefaultCompany());
                        if($user->getIsSeller() == 1)
                        {
                            $user->setIsSeller("Oui");
                        }
                        else {
                            $user->setIsSeller("Non");
                        }
                        if($user->getIsActive() == 1)
                        {
                            $user->setIsActive("Oui");
                            $label = "success";
                        }
                        else {
                            $user->setIsActive("Non");
                            $label = "danger";
                        }
                        ?>
                        <tr>
                            <td><?php echo $user->getUsername();?></td>
                            <td><?php echo $user->getFirstName(); ?></td>
                            <td><?php echo $user->getName(); ?></td>
                            <td><?php echo $user->getEmailAddress();?></td>
                            <td><?php echo $user->getPhoneNumber();?></td>
                            <td><?php echo $user->getCredential();?></td>
                            <td><?php echo $company->getName();?></td>
                            <td>
                                <?php
                                    $companiesList = explode(", ",$user->getCompanyName());
                                    foreach ($companies as $company)
                                    {
                                        $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                        $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                        if(in_array($company->getName(),$companiesList)){
                                ?>
                                    <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/>
                                <?php
                                    }}
                                ?>
                            </td>
                            <td><?php echo $user->getIsSeller();?></td>
                            <td><span class="label label-<?php echo $label; ?>" ><?php echo $user->getIsActive();?></span></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/user/modifier/'.$user->getUsername(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                            <?php
                            if($user->getIsActive() == "Oui")
                            {
                                echo '<td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer l\'utilisateur '.$user->getUsername().' ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/supprimer_user.php?username='.$user->getUsername().'"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>';
                            }
                            else{
                                echo '<td><a class="btn green-dark" data-placement="top" data-toggle="confirmation" data-title="Réactiver l\'utilisateur '.$user->getUsername().'?" data-btn-ok-label="Reactiver" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/reactiver_user.php?username='.$user->getUsername().'"><i class="fas fa-toggle-on" alt="Reactiver"></i> Reactiver</a></td>';
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
        <div>
            Note pour les accréditations : U = Utilisateur, F = U + Possibilité de Facturation, C = F + Création de Client, A = Administrateur
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>