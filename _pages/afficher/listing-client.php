<?php
$retour = $_GET['soussouscat'];
$companyNameData = $_GET["section"];
$credential = $userlogged->getCredential();

$array = array();
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);

/*récupération des objets en base*/
$company = $companymanager->getByNameData($companyNameData);

if($credential == "A"){
    $customermanager = $customermanager->getListAllByCompany($company->getIdcompany());
}
else{
    $customermanager = $customermanager->getListByCompany($company->getIdcompany());
}

?>
<html>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>Liste des <?php print ucwords($_GET['cat']); ?>  </div>
                <div class="actions">
                    <a href="<?php echo URLHOST.$_COOKIE['company'].'/client/creer'; ?>" class="btn btn-sm grey-mint">
                        <i class="fa fa-plus"></i> Créer </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php if($retour == "error") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le client n'a donc pas pu être créé !</div>
                <?php }elseif($retour == "success"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le client a bien été créé !</div>
                <?php }elseif($retour == "errorsuppr") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le client n'a donc pas pu être supprimé !</div>
                <?php }                elseif($retour == "erroractivate") { ?>
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button> Une erreur est survenue, le client n'a donc pas pu être réactivé !</div>
                <?php }elseif($retour == "successsuppr"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le client a bien été supprimé !</div>
                <?php }elseif($retour == "successactivate"){ ?>
                    <div class="alert alert-success">
                        <button class="close" data-close="alert"></button> Le client a bien été réactivé !</div>
                <?php } ?>
                <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="all">Nom</th>
                            <th class="desktop">Afficher</th>
                            <th class="min-tablet">Modifier</th>
                            <?php if($credential == "A"){
                                echo "<th class=\"min-phone-l\">Supprimer / Réactiver</th>";
                            }
                            elseif($credential == "C"){
                                echo "<th class=\"min-phone-l\">Supprimer</th>";
                            }?>
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
                            <?php
                            if($customer->getIsActive() == 1 && ($credential == "A" || $credential== "C"))
                            {
                                echo '<td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le client '.$customer->getName().' ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/supprimer_client.php?idCustomer='.$customer->getIdCustomer().'"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>';
                            }
                            elseif($customer->getIsActive() == 0 && $credential == 'A')
                            {
                                echo '<td><a class="btn green-dark" data-placement="top" data-toggle="confirmation" data-title="Réactiver le client '.$customer->getName().'?" data-btn-ok-label="Réactiver" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/reactiver_client.php?idCustomer='.$customer->getIdCustomer().'"><i class="fas fa-toggle-on" alt="Reactiver"></i> Reactiver</a></td>';
                            }
                            ?>
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
<?php

?>