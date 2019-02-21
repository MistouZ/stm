<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$array = array();
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$usermanager = $usermanager->getList();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);


?>
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des utilisateurs  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Prénom</th>
                            <th class="min-phone-l">Nom</th>
                            <th class="min-tablet">Login</th>
                            <th class="none">Adresse email</th>
                            <th class="none">Numéro de téléphone</th>
                            <th class="none">Accréditation</th>
                            <th class="desktop">Société par défaut</th>
                            <th class="none">Sociétés affiliées</th>
                            <th class="none">Commercial</th>
                            <th class="none">Actif</th>
                            <th class="min-phone-l">Afficher</th>
                            <th class="min-tablet">Modifier</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($usermanager as $user) {
                        $company = $companymanager->getById($user->getDefaultCompany());

                        ?>
                        <tr>
                            <td><?php echo $user->getFirstName(); ?></td>
                            <td><?php echo $user->getName(); ?></td>
                            <td><?php echo $user->getUsername();?></td>
                            <td><?php echo $user->getEmailAddress();?></td>
                            <td><?php echo $user->getPhoneNumber();?></td>
                            <td><?php echo $user->getCredential();?></td>
                            <td><?php echo $company->getName();?></td>
                            <td></td>
                            <td><?php echo $user->getIsSeller();?></td>
                            <td><?php echo $user->getIsActive();?></td>
                            <td><a href="<?php echo URLHOST.'user/afficher/'.$user->getUsername(); ?>"><i class="fas fa-eye" alt="Détail"></i></a></td>
                            <td><a href="<?php echo URLHOST.'user/modifier/'.$user->getUsername(); ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
</html>