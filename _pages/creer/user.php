<?php
$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companymanager = $companymanager->getList();

?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject sbold uppercase">Création d'un utilisateur</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <div class="form-body">
                    <form action="<?php echo URLHOST."_pages/_post/creer_user.php"; ?>" method="post" id="user" name="user" class="form-horizontal">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> L'utilisateur a bien été créé </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Login
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="username" data-required="1" class="form-control" placeholder="Login"/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Mot de passe
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Mot de passe" name="password" /> </div>
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
                                <input name="name" id="name" type="text" class="form-control" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Prénom
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="firstname" id="firstname" type="text" class="form-control" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Adresse mail
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="email" id="email" type="mail" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Téléphone
                            </label>
                            <div class="col-md-4">
                                <input name="phone_number" id="phone_number" type="number" class="form-control" />
                            </div>
                        </div>
                        <h4 class="form-section">Droits d'accès</h4>
                        <div class="form-group">
                            <label class="control-label col-md-3">Société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#company_error">
                                <?php
                                    foreach ($companymanager as $company){

                                    $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                    $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                ?>
                                        <label class="checkbox-inline">
                                <?php
                                        echo'<input type="checkbox" name="societe[]" value="'.$company->getIdCompany().'" />';
                                ?>
                                            <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/></a>
                                        </label>
                                <?php
                                    }
                                ?>
                                </div>
                                <span class="help-block"> Cocher la ou les société(s) affiliée(s) à l'utilisateur </span>
                                <div id="company_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Droits
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="radio-list" data-error-container="#credential_error">
                                    <label class="radio-inline"><input name="credential" id="credential1" type="radio" value="U" class="form-control" />Utilisateur</label>
                                    <label class="radio-inline"><input name="credential" id="credential2" type="radio" value="C" class="form-control" />Compta</label>
                                    <label class="radio-inline"><input name="credential" id="credential3" type="radio" value="F" class="form-control" />Facturation</label>
                                    <label class="radio-inline"><input name="credential" id="credential4" type="radio" value="A" class="form-control" />Administrateur</label>
                                </div>
                                <div id="credential_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Commercial
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="is_seller" name="is_seller" id="is_seller" /></label>
                                </div>
                                <span class="help-block"> Cocher si cet utilisateur est commercial </span>
                                <div id="form_2_services_error"> </div>
                            </div>
                        </div>
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

