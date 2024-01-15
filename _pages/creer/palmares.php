<?php
/**
 * @author Amaury
 * @copyright 2019
 */

$array = array();
$companyNameData = $_GET["section"];

/*initilisation des objets */
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);

$user = new Users($array);
$usermanager = new UsersManager($bdd);

$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);

$company = $companymanager->getByNameData($companyNameData);
$companyId = $company->getIdcompany();

$today = date('d/m/Y');

$type = $_GET["souscat"]
?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject sbold uppercase">Création d'un palmares sur <?php echo $type; ?></span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST.$_COOKIE['company'].'/palmares/'.$type.'/afficher'; ?>" method="post" id="palmares" name="palmares" class="form-horizontal">
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
                                    <input type="text" name="date_from" class="form-control" value="" >
                                    <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        </span>
                                </div>
                                <span class="help-block">Cliquez sur la date pour la modifier</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Date de la fin du palmares
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-8">
                                <div class="input-group input-medium date date-picker"  data-date-lang="FR-fr" type="text">
                                    <input type="text" name="date_to" class="form-control" value="<?php echo $today; ?>" >
                                    <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fas fa-calendar-alt"></i>
                                            </button>
                                        </span>
                                </div>
                                <span class="help-block">Cliquez sur la date pour la modifier</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Utilisateurs
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-2">
                                <select id="users" class="username form-control" name="seller">
                                    <option value="">Sélectionnez ...</option>
                                    <?php
                                    $usermanager = $usermanager->getSellerByCompany($companyId);
                                    foreach ($usermanager as $user){
                                       ?>
                                        <option value="<?php echo $user->getUsername(); ?>"><?php echo $user->getFirstName()." ".$user->getName(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Clients
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-2">
                                <select id="users" class="username form-control" name="seller">
                                    <option value="">Sélectionnez ...</option>
                                    <?php
                                    $customermanager = $customerManager->getListByCompany($companyId);

                                    print_r($customermanager);
                                    foreach ($customermanager as $customer){
                                       ?>
                                        <option value="<?php echo $customer->getIdCustomer(); ?>"><?php echo $customer->getName(); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="type" name="type" value="<?php echo $type; ?>">
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
