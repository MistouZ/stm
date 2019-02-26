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
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des sociétés </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="all">Nom de société</th>
                        <th class="none">Adresse</th>
                        <th class="min-phone-1">Logo</th>
                        <th class="none">Actif</th>
                        <th class="min-tablet">Modifier</th>
                        <th class="min-phone-1">Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($companymanager as $company) {

                        if($company->getIsActive() == 1)
                        {
                            $company->setIsActive("Oui");
                        }
                        else {
                            $company->setIsActive("Non");
                        }
                        ?>
                        <tr>
                            <td><?php echo $company->getName(); ?></td>
                            <td><?php echo $company->getAddress(); ?></td>
                            <td>
                                <?php
                                    $path_image = parse_url(URLHOST."images/societe/".$company->getNameData(), PHP_URL_PATH); 
                                    $image = glob($_SERVER['DOCUMENT_ROOT'].$path_image.".*");
                                ?>
                                <img src="<?php echo URLHOST; ?>images/societe/<?php echo basename($image[0]); ?>" alt="<?php echo $company->getNameData();?>" style="max-height: 30px;" />
                            </td>
                            <td><?php echo $company->getIsActive();?></td>
                            <td><a href="<?php echo URLHOST.$_COOKIE['company'].'/societe/modifier/'.$company->getIdcompany();; ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
                            <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer la société <?php echo $company->getName(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo  URLHOST."_pages/_post/supprimer_societe.php?idCompany=".$company->getIdcompany(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
</html>