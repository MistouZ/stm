﻿<?php

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
                <!-- BEGIN FORM-->
                <form action="<?php echo URLHOST."_pages/_post/creer_societe.php"; ?>" id="inscription" name="inscription" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Tous les champs doivent être remplis </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Création de société effectuée avec succès </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Nom de la société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="name" data-required="1" class="form-control" /> </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Adresse physique
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="email" name="address" id="address" class="form-control" placeholder="Adresse"> </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Logo de la société
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                        <span class="btn green fileinput-button">
                                            <i class="fa fa-plus"></i>
                                            <span> Choisir le fichier... </span>
                                            <input type="file" name="nameData" id="nameData"  accept="image/png, image/jpeg" /> </span>
                                        <!-- The global file processing state -->
                                        <span class="fileupload-process"> </span>
                                    </div>
                                </div>
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



<html>
    <body>
    <h1>Création d'une société</h1>
        <form name="inscription" method="post" action="<?php echo URLHOST."_pages/_post/creer_societe.php"; ?>" enctype="multipart/form-data">
            <label for="name">Nom de la société :</label><input type="text" name="name" id="name"/> <br/>
            <label for="physical_address">Adresse physique du client : </label><input type="text" name="address" id="address"/><br/>
            <label for="nameData">Uploader le logo de la société : </label><input type="file" name="nameData" id="nameData"  accept="image/png, image/jpeg" /><br/>
            <input type="submit" name="valider" value="OK"/>
        </form>
    </body>
</html>