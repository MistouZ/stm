<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$array = array();
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$companymanager = $companymanager->getList();

?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject sbold uppercase">Création d'un utilisateur</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/creer_user.php"; ?>" method="post" id="inscription" name="inscription" class="form-horizontal register-form">
                    <div class="form-body">
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
                            <label class="control-label col-md-3">Mot de passe</label>
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
                                <input name="first_name" id="first_name" type="text" class="form-control" /> </div>
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
                            <div class="col-md-9">
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
                                ?>
                                        <label class="checkbox-inline">
                                <?php
                                        echo'<input type="checkbox" id="case[]" name="case[]" value="'.$company->getIdCompany().'" />';
                                ?>
                                            <img src="<?php echo URLHOST; ?>images/societe/<?php echo $company->getNameData(); ?>.jpg" alt="<?php echo $company->getName(); ?>" class="logo-default" style="max-height: 20px;"/></a>
                                        </label>
                                <?php
                                    }
                                ?>
                                </div>
                                <span class="help-block"> Cocher la ou les société(s) affiliée(s) au client </span>
                                <div id="company_error"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Droits
                            </label>
                            <div class="col-md-9">
                                <div class="radio-list">
                                    <label class="radio-inline"><input name="credential" id="credential" type="radio" value="U" class="form-control" />Utilisateur</label>
                                    <label class="radio-inline"><input name="credential" id="credential" type="radio" value="C" class="form-control" />Compta</label>
                                    <label class="radio-inline"><input name="credential" id="credential" type="radio" value="F" class="form-control" />Facturation</label>
                                    <label class="radio-inline"><input name="credential" id="credential" type="radio" value="A" class="form-control" />Administrateur</label>
                                </div>
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
                                <button type="submit" class="btn green">Valider</button>
                                <button type="button" class="btn grey-salsa btn-outline">Annuler</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>


<h1>Création d'un utilisateur </h1>
<form name="inscription" method="post" action="<?php echo URLHOST."_pages/_post/creer_user.php"; ?>">
    <label for="login">Login :</label><input type="text" name="username" id="login" autofocus required/> <br/>
    <label for="passwd">Mot de passe : </label><input type="password" name="password" id="passwd" required/><br/>
    <label for="name">Nom : </label><input type="text" name="name" id="name" required/><br/>
    <label for="first_name">Prénom : </label><input type="text" name="firstname" id="firstname" required/><br/>
    <label for="ad_mail">Adresse mail : </label><input type="email" name="email_address"id="ad_mail" required/><br/>
    <label for="phone_number">Téléphone : </label><input type="tel" name="phone_number" id="phone_number" required/><br/>
    <label for="company">Société :</label> <?php
    foreach ($companies as $company)
    {
        echo'<input type="checkbox" name="case[]" value="'.$company->getIdCompany().'" />';
        echo $company->getName();
    }
    ?> <br/>
    <label for="credential">Droits d'accès : </label>
    <select name="credential" id="credential" required>
        <option value="U">Utilisateur</option>
        <option value="C">Compta</option>
        <option value="F">Facturation</option>
        <option value="A">Administrateur</option>
    </select><br/>
    <!--<label for="rights">Type Utilisateurs</label><input type="range" min="1" max="4" step="1" list="user_right"/>
    <datalist id="user_right">
      <option value="U" label="Utilisateur"></option>
      <option value="C" label="Compta"></option>
      <option value="F" label="Facturation"></option>
      <option value="A" label="Administrateur"></option>
    </datalist>-->
    <br />
    <label for="is_seller"></label>Commercial : <input type="checkbox" id"=is_seller" name="is_seller" value="is_seller" /> <br />
    <input type="submit" name="valider" value="Send"/>
</form>

