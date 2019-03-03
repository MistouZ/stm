<?php

/**
 * @author Amaury
 * @copyright 2019
 */

$array = array();
$company = new Company($array);
$companies = new CompaniesManager($bdd);
$companies = $companies->getList();

?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light form-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Création d'une société</span>
                </div>
            </div>
            <div class="portlet-body form">
                <?php if($_GET['soussouscat']=="files"){ ?>
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Le fichier sélectionner n'a pu être téléchargé. Veuillez en sélectionner un autre. </span>
                </div>
                <?php } ?>
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/creer_societe.php"; ?>" id="societe" name="societe" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Tous les champs doivent être remplis !</div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Création de société effectuée avec succès !</div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom de la société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name" data-required="1" class="form-control" placeholder="Nom" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Adresse physique
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Adresse" /> </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-md-3">Logo de la société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                    <div>
                                        <span class="btn red btn-outline btn-file">
                                            <span class="fileinput-new"> Choisir ... </span>
                                            <span class="fileinput-exists"> Changer </span>
                                            <input type="file" accept="image/png, image/jpeg" id="nameData" name="nameData"/> </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Annuler </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-danger">Attention</span> Le logo doit être un fichier image au format .PNG ou .JPEG.</div>
                                <div class="clearfix margin-top-10">
                                    <span class="label label-success">NOTE</span> Pour un meilleur rendu, supprimez les bords blancs autour du logo.</div> 
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" name="valider" id="valider" class="btn green">Valider</button>
                                <button type="button" class="btn default">Annuler</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END FORM-->
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>