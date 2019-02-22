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

$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);


/*récupération des objets en base*/
$company = $companymanager->getByNameData($companyNameData);
$usermanager = $usermanager->getListByCompany($company->getIdcompany());
$customermanager = $customermanager->getListByCompany($company->getIdcompany());

//print_r($customermanager);

foreach($customermanager as $customer) {

    echo $customer->getName();
}
?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings"></i>
                    <span class="caption-subject sbold uppercase">Création d'un dossier</span>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/creer_dossier.php"; ?>" id="folder_creation" name="folder_creation" class="form-horizontal">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Une erreur s'est produite, merci de renseigner les champs requis. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Le dossier a bien été créé </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="label">Intitulé du dossier
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="label" id="label" data-required="1" class="form-control" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="description">Description
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="description" id="description" type="text" class="form-control" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="seller-select">Commercial
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <select id="seller-select" name="seller-select" class="form-control">
                                    <option value="">--Choississez le commercial--</option>
                                    <?php
                                        foreach ($usermanager as $user)
                                        {
                                            if($user->getIsSeller() == 1)
                                            {
                                                echo "<option value=".$user->getUsername().">".$user->getFirstName()." ".$user->getName()."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3" for="seller-select">Client
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <select id="customer-select" name="customer-select" class="form-control">
                                    <option value="">--Choississez le client--</option>
                                    <?php/*
                                        foreach ($customermanager as $customer)
                                        {
                                            echo "<option value=" . $customer->getIdCustomer() . ">".$customer->getName()."</option>";
                                        }*/
                                    ?>
                                </select>
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
