<?php
$bdd = new DB();
$bdd->connexion();
$array = array();
$supplier = new Suppliers($array);
$suppliermanager = new SuppliersManager($bdd);
$suppliermanager = $suppliermanager->getList();
?>
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['section']); ?>  </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="all">Nom</th>
                        <th class="min-phone-l">Afficher</th>
                        <th class="min-tablet">Modifier</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //$donnees_client = R::getAll("SELECT * from customers"," ORDER BY name DESC");

                    foreach($suppliermanager as $supplier) {
                        ?>
                        <tr>
                            <td><?php echo $supplier->getName(); ?></td>
                            <td><a href="<?php echo URLHOST.'client/afficher/'.$supplier->getIdCustomer(); ?>"><i class="fas fa-eye" alt="Détail"></i></a></td>
                            <td><a href="<?php echo URLHOST.'client/modifier/'.$supplier->getIdCustomer(); ?>"><i class="fas fa-edit" alt="Editer"></i></a></td>
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