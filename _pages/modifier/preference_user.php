<?php

$username = $_GET['soussoussouscat'];

//récupération des données de l'utilisateur
$array = array();
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$user = $usermanager->get($username);

//Liste des sociétés
$arrayCompanies = array();
$company = new Company($arrayCompanies);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject sbold uppercase">Modification des préférences de l'utilisateur <span style="font-style: italic; font-weight: 800;"><?php echo $user->getUsername(); ?></span></span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <div class="form-body">
                    <form action="<?php echo URLHOST."_pages/_post/modifier_preference_user.php"; ?>" method="post" id="modif_user" name="modif_user" class="form-horizontal">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> L'utilisateur a bien été créé </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Login
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="username" data-required="1" class="form-control" placeholder="Login" value="<?php echo $user->getUsername(); ?>" readonly /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Mot de passe
                            </label>
                            <div class="col-md-4">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Mot de passe" name="password" />
                                <span class="help-block"> Pour conserver l'ancien mot de passe, ne pas remplir cette case </span></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Confirmer le mot de passe</label>
                            <div class="col-md-4">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Confirmez" name="rpassword" /> </div>
                        </div>
                        <h4 class="form-section">Informations personnelles</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="name" id="name" type="text" class="form-control" value="<?php echo $user->getName(); ?>" readonly /> </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Prénom
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="firstname" id="firstname" type="text" class="form-control" value="<?php echo $user->getFirstName(); ?>" readonly /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse mail
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="email" id="email" type="mail" class="form-control" value="<?php echo $user->getEmailAddress(); ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Téléphone
                            </label>
                            <div class="col-md-4">
                                <input name="phone_number" id="phone_number" type="number" class="form-control" value="<?php echo $user->getPhoneNumber(); ?>" />
                            </div>
                        </div>
                        <?php
                        if((count($companies)>1) || ($_COOKIE["credential"] == "A")) {
                            ?>
                            <h4 class="form-section">Gestion société</h4>
                            <div class="form-group">
                                <label class="control-label col-md-3">Société par défaut
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-9">
                                    <div class="radio-list" data-error-container="#company_error">
                                        <?php
                                        $companiesList = explode(", ", $user->getCompanyName());
                                        foreach ($companies as $company) {

                                            $path_image = parse_url(URLHOST . "images/societe/" . $company->getNameData(), PHP_URL_PATH);
                                            $image = glob($_SERVER['DOCUMENT_ROOT'] . $path_image . ".*");
                                            ?>
                                            <label class="radio-inline">
                                                <?php
                                                echo '<input type="radio" name="defaultCompany" value="' . $company->getIdCompany() . '"';
                                                if ($user->getDefaultCompany() == $company->getIdCompany() ) {
                                                    echo "checked=\"checked\"";
                                                }
                                                echo ' />';
                                                ?>
                                                <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>"
                                                     alt="<?php echo $company->getName(); ?>" class="logo-default"
                                                     style="max-height: 20px;"/></a>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <span class="help-block"> Choissisez la société que vous souhaitez avoir par défaut à votre connexion </span>
                                    <div id="company_error"></div>
                                </div>
                            </div>
                            <?php
                      }
                        ?>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="valider" class="btn green">Valider</button>
                                <button type="button" class="btn grey-salsa btn-outline">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END FORM-->
            </form>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>
