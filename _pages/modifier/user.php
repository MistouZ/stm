<?php

$username = $_GET['soussouscat'];

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
                    <span class="caption-subject sbold uppercase">Modification de l'utilisateur <span style="font-style: italic; font-weight: 800;"><?php echo $user->getUsername(); ?></span></span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <div class="form-body">
                    <form action="<?php echo URLHOST."_pages/_post/modifier_user.php"; ?>" method="post" id="form_sample_3" name="form_sample_3" class="form-horizontal">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> L'utilisateur a bien été créé </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Login
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="username" data-required="1" class="form-control" placeholder="Login" value="<?php echo $user->getUsername(); ?> "/> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Mot de passe
                            </label>
                            <div class="col-md-4">
                                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Mot de passe" name="password" value="" /> </div>
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
                                <input name="name" id="name" type="text" class="form-control" value="<?php echo $user->getName(); ?>" /> </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Prénom
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="firstname" id="firstname" type="text" class="form-control" value="<?php echo $user->getFirstName(); ?>" /> </div>
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
                        <h4 class="form-section">Droits d'accès</h4>
                        <?php echo $user->getCompanyName(); ?>
                        <div class="form-group">
                            <label class="control-label col-md-3">Société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="checkbox-list" data-error-container="#company_error">
                                <?php
                                    $companiesList = explode(", ",$user->getCompanyName());
                                    foreach ($companies as $company){

                                    $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                    $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                ?>
                                        <label class="checkbox-inline">
                                <?php
                                        echo'<input type="checkbox" name="societe[]" value="'.$company->getIdCompany().'"';
                                        if(in_array($company->getName(),$companiesList)){ echo "checked=\"checked\""; }
                                        echo' />';
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
                                    <label class="radio-inline"><input name="credential" id="credential1" type="radio" value="U" class="form-control" <?php if($user->getCredential()=="U"){echo "checked=\"checked\"" ;} ?> />Utilisateur</label>
                                    <label class="radio-inline"><input name="credential" id="credential2" type="radio" value="C" class="form-control" <?php if($user->getCredential()=="C"){echo "checked=\"checked\"" ;} ?>/>Compta</label>
                                    <label class="radio-inline"><input name="credential" id="credential3" type="radio" value="F" class="form-control" <?php if($user->getCredential()=="F"){echo "checked=\"checked\"" ;} ?>/>Facturation</label>
                                    <label class="radio-inline"><input name="credential" id="credential4" type="radio" value="A" class="form-control" <?php if($user->getCredential()=="A"){echo "checked=\"checked\"" ;} ?>/>Administrateur</label>
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

<body>
<h1>Modification de l'utilisateur <span><?php echo $user->getName()." ".$user->getFirstName(); ?></span> </h1>
<form name="inscription" method="post" action="<?php echo URLHOST."_pages/_post/modifier_user.php"; ?>">
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
</body>
