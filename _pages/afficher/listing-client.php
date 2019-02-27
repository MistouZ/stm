<?php
$array = array();
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$customermanager = $customermanager->getList();


?>
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['cat']); ?>  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Nom</th>
                            <th class="desktop">Afficher</th>
                            <th class="min-tablet">Modifier</th>
                            <th class="min-phone-l">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        //$donnees_client = R::getAll("SELECT * from customers"," ORDER BY name DESC");

                        foreach($customermanager as $customer) {
                    ?>
                        <tr>
                            <td><?php echo $customer->getName(); ?></td>
                            <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/client/afficher/'.$customer->getIdCustomer(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                            <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/client/modifier/'.$customer->getIdCustomer(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                            <td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le client <?php echo $customer->getName(); ?> ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="<?php echo  URLHOST."_pages/_post/supprimer_client.php?idCustomer=".$customer->getIdCustomer(); ?>"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>
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