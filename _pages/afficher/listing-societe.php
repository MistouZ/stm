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
                        <th class="none">test</th>
                        <th class="min-tablet">Modifier</th>
                        <th class="min-tablet">Supprimer</th>
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
                            <td><img src="<?php echo URLHOST; ?>images/societe/<?php echo $company->getNameData(); ?>.jpg" alt="<?php echo $company->getNameData();?>" style="max-height: 30px;"/></td>
                            <td><?php echo $company->getIsActive();?></td>
                            <td><?php 
                                
                                    $image = glob(URLHOST."images/societe/".$company->getNameData().".{jpg,jpeg,png,gif}");
                                    echo var_dump($image);
                                    echo $image['basename'];
                                    echo pathinfo($image, PATHINFO_EXTENSION);
                                
                            ?></td>
                            <td><a href="<?php echo URLHOST.$_COOKIE['company'].'/societe/modifier/'.$company->getIdcompany();; ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
                            <td><a href="<?php echo URLHOST.$_COOKIE['company'].'/societe/supprimer/'.$company->getIdcompany(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i></a></td>
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