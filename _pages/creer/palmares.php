<?php
/**
 * @author Amaury
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

$companyNameData = $_GET["section"];
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);

echo "all loaded";
/*
$company = $companymanager->getByNameData($companyNameData);
$idCompany = $company->getIdcompany();

$dateToday = date('d/m/Y');


?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject sbold uppercase">Création d'une taxe</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/creer_palmares.php"; ?>" method="post" id="palmares" name="palmares" class="form-horizontal">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Le palmares a bien été créé </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Date de début du palmares
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date date-picker"  data-date-lang="FR-fr" type="text">
                                    <input type="text" name="date_from" class="form-control" value="<?php echo $dateToday; ?>" >
                                    <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        </span>
                                </div>
                                <span class="help-block">Si aucune date n'est sélectionnée, la date par défaut sera celle du jour</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Date de fin du palmares
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date date-picker"  data-date-lang="FR-fr" type="text">
                                    <input type="text" name="date_to" class="form-control" value="<?php echo $dateToProforma; ?>" >
                                    <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        </span>
                                </div>
                                <span class="help-block">Si aucune date n'est sélectionnée, la date par défaut sera celle du jour</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Utilisateurs</label>
                            <select id="users" class="username form-control" name="users">
                                <option value="">Sélectionnez ...</option>
                                <?php
                                $usermanager = $usermanager->getSellerByCompany($idCompany);
                                foreach ($usermanager as $user){
                                   ?>
                                    <option value="<?php echo $user->getUsername(); ?>"><?php echo $user->getFirstName()." ".$user->getName(); ?></option>
                                    <?php
                                }
                                ?>
                            </select>
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
                </form>
                <!-- END FORM-->
            </div>
        </div>
        <!-- END VALIDATION STATES-->
    </div>
</div>
