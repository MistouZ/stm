<?php
include("../../_cfg/cfg.php");

/**
 * @author Nicolas
 * @copyright 2019
 */

$array = array();
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
$idCompany = $company->getIdcompany();
$foldermanager = $foldermanager->getListActive($idCompany);

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
                            <div class="col-md-12">
                                <div class="portlet box blue-soft">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-folder"></i>
                                            <span class="caption-subject bold uppercase"> Sélection du dossier </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="display: block;">
                                        <div class="row form-section" style="padding: 12px 20px 15px 20px; margin: 10px 0px 10px 0px !important;">
                                            <label class="col-md-2 control-label">Dossier
                                            <span class="required" aria-required="true"> * </span>
                                            </label>
                                            <div class="col-md-10">
                                                <select class="form-control" name="folder">
                                                    <option value="">Choisissez un dossier...</option>
                                                    <?php
                                                        foreach ($foldermanager as $folder){
                                                            $customer = $customermanager->getByID($folder->getCustomerId());
                                                    ?>
                                                    <option value="<?php echo $folder->getIdFolder(); ?>">N° <?php echo $folder->getFolderNumber()." ".$folder->getLabel()." (".strtoupper($customer->getName()).")"; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="infos" class="row form-section" style="margin: 10px 0px 10px 0px !important;">
                                            <div class="col-md-6">
                                                <div class="portlet box purple-sharp" style="margin-bottom: 0px !important;">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fas fa-building"></i>
                                                            <span class="caption-subject bold uppercase"> Informations de la société </span>
                                                        </div>
                                                        <div class="tools">
                                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body" style="display: block;">
                                                        <h5 style="font-weight: 800;">Société : </h5>
                                                        <h5 style="font-weight: 800;">Comercial : </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="portlet box purple-sharp" style="margin-bottom: 0px !important;">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fas fa-user-tie"></i>
                                                            <span class="caption-subject bold uppercase"> Informations client </span>
                                                        </div>
                                                        <div class="tools">
                                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body" style="display: block;">
                                                        <h5 style="font-weight: 800;">Client : </h5>
                                                        <h5 style="font-weight: 800;">Contact : </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box blue-dark">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-cogs"></i>
                                            <span class="caption-subject bold uppercase"> Détails du devis </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="collapse" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body form" style="display: block;">
                                        <div class="row" style="margin-left: 0px !important; margin-right: 0px !important;">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Description</label>
                                                        <textarea class="wysihtml5 form-control" id="description" name="description[]" rows="4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Quantité</label>
                                                        <input type="digits" id="quantite" name="quantite[]" class="form-control" placeholder="Qt.">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Remise (%)</label>
                                                        <input type="digits" id="remise" name="remise[]" class="form-control" placeholder="xx">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Taxes</label>
                                                        <select class="form-control" name="folder">
                                                            <option value="">Taxes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group" style="margin-left: 0px !important; margin-right: 0px !important;">
                                                        <label class="control-label">Prix HT</label>
                                                        <input type="digits" id="prix" name="prix[]" class="form-control" placeholder="HT">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="portlet box grey-cascade" style="margin-bottom: 0px !important;">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fas fa-sliders-h"></i>
                                            <span class="caption-subject bold uppercase"> Options du devis </span>
                                        </div>
                                        <div class="tools">
                                            <a href="" class="expand" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="display: none;">
                                        <h5 style="font-weight: 800;">Société : </h5>
                                        <h5 style="font-weight: 800;">Comercial : </h5>
                                    </div>
                                </div>
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