<?php session_start(); 

?>
<body class=" login">
        <div class="loginfond" style="background: url('<?php echo URLHOST; ?>images/fond.jpg') !important;"></div>
        <!-- BEGIN LOGO -->
        <div class="logo">
            <img style="max-width: 200px;" src="../images/logo.png" alt="" />
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="<?php echo URLHOST."_pages/_post/login_check.php"; ?>" method="post" >
                <h3 class="form-title">Connectez vous</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Entrez vos logins et mot de passe </span>
                </div>
                <?php if($_GET['cat']=="false"){ ?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Login ou mot de passe incorrectes </span>
                </div>
                <?php } ?>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Login</label>
                    <div class="input-icon">
                        <i class="fa fa-user"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Login" name="username" id="username" /> </div>
                </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Mot de passe</label>
                    <div class="input-icon">
                        <i class="fa fa-lock"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Mot de passe" name="password" id="password" /> </div>
                </div>
                <div class="form-actions">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="1" /> Rester connecté </label>
                    <button type="submit" class="btn green pull-right" id="valider" name="valider" value="valider"> Connexion </button>
                </div>
                <div class="forget-password">
                    <h4>Mot de passe oublié ?</h4>
                    <p> Pas de souci
                        <a href="javascript:;" id="forget-password"> ICI </a> pour réinitialiser votre mot de passe. </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="<?php echo URLHOST."_pages/_post/reset_password.php"; ?>" method="post">
                <h3>Mot de passe oublié ?</h3>
                <p> Entrez votre adresse mail pour réinitialiser votre mot de passe </p>
                <div class="form-group">
                    <div class="input-icon">
                        <i class="fa fa-envelope"></i>
                        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn grey-salsa btn-outline"> Annuler </button>
                    <button type="submit" class="btn green pull-right"> Envoyer </button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
        </div>
