<?php
include("../../_cfg/cfg.php");

/**
 * @author Nicolas
 * @copyright 2019
 */

/*$array = array();
$companyNameData = $_GET["section"];

$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);

$company = $companymanager->getByNameData($companyNameData);
$foldermanager = $foldermanager->getListActive($company->getIdcompany());*/

?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue-chambray">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fas fa-file-medical"></i>Création d'un nouveau devis</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <form action="#" id="devis" name="devis" class="form-horizontal">
                    <div class="form-actions top">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green"><i class="fas fa-save"></i> Enregistrer</button>
                                <button type="button" class="btn default"><i class="fas fa-ban"></i> Annuler</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label class="control-label">Dossier</label>
                                <select class="form-control" name="folder">
                                    <option value="">Choisissez un dossier...</option>
                                    <?php
                                        /*foreach ($foldermanager as $folder){
                                            $customer = $customermanager->getByID($folder->getCustomerId());
                                    ?>
                                    <option value="<?php echo $folder->getIdFolder(); ?>">N° <?php echo $folder->getFolderNumber()." ".$folder->getLabel()." (".strtoupper($customer->getName()).")"; ?></option>
                                    <?php
                                    }*/
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Email Address</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" placeholder="Email Address"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Password</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Password">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Left Icon</label>
                            <div class="col-md-4">
                                <div class="input-icon">
                                    <i class="fa fa-bell-o"></i>
                                    <input type="text" class="form-control" placeholder="Left icon"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Right Icon</label>
                            <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fa fa-microphone"></i>
                                    <input type="text" class="form-control" placeholder="Right icon"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Input With Spinner</label>
                            <div class="col-md-4">
                                <input type="password" class="form-control spinner" placeholder="Password"> </div>
                        </div>
                        <div class="form-group last">
                            <label class="col-md-3 control-label">Static Control</label>
                            <div class="col-md-4">
                                <p class="form-control-static"> email@example.com </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions fluid">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green"><i class="fas fa-save"></i> Enregistrer</button>
                                <button type="button" class="btn default"><i class="fas fa-ban"></i> Annuler</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>