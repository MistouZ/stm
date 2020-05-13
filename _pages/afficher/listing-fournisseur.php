<?php
$retour = $_GET['soussouscat'];
$companyNameData = $_GET["section"];
$credential = $userlogged->getCredential();

$array = array();
$supplier = new Suppliers($array);
$suppliermanager = new SuppliersManager($bdd);
$company = new Company($array);
$companymanager = new CompaniesManager($bdd);

/*récupération des objets en base*/
$company = $companymanager->getByNameData($companyNameData);

if($credential == "A"){
    $suppliermanager = $suppliermanager->getListAllByCompany($company->getIdcompany());
}
else{
    $suppliermanager = $suppliermanager->getListByCompany($company->getIdcompany());
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
                        <a href="<?php echo URLHOST.$_COOKIE['company'].'/fournisseur/creer'; ?>" class="btn btn-sm grey-mint">
                            <i class="fa fa-plus"></i> Créer </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if($retour == "error") { ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button> Une erreur est survenue, le fournisseur n'a donc pas pu être créé !</div>
                    <?php }elseif($retour == "success"){ ?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button> Le fournisseur a bien été créé !</div>
                    <?php }elseif($retour == "errorsuppr") { ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button> Une erreur est survenue, le fournisseur n'a donc pas pu être supprimé !</div>
                    <?php }                elseif($retour == "erroractivate") { ?>
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button> Une erreur est survenue, le fournisseur n'a donc pas pu être réactivé !</div>
                    <?php }elseif($retour == "successsuppr"){ ?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button> Le fournisseur a bien été supprimé !</div>
                    <?php }elseif($retour == "successactivate"){ ?>
                        <div class="alert alert-success">
                            <button class="close" data-close="alert"></button> Le fournisseur a bien été réactivé !</div>
                    <?php } ?>
                    <table class="table table-striped table-bordered table-hover dt-responsive sample_3" width="100%" id="sample_3" cellspacing="0" width="100%">
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

                        foreach($suppliermanager as $supplier) {
                            ?>
                            <tr>
                                <td><?php echo $supplier->getName(); ?></td>
                                <td><a class="btn green-meadow" href="<?php echo URLHOST.$_COOKIE['company'].'/fournisseur/afficher/'.$supplier->getIdSupplier(); ?>"><i class="fas fa-eye" alt="Détail"></i> Afficher</a></td>
                                <td><a class="btn blue-steel" href="<?php echo URLHOST.$_COOKIE['company'].'/fournisseur/modifier/'.$supplier->getIdSupplier(); ?>"><i class="fas fa-edit" alt="Editer"></i> Modifier</a></td>
                                <?php
                                if($supplier->getIsActive() == 1 && ($credential == "A" || $credential== "C"))
                                {
                                    echo '<td><a class="btn red-mint" data-placement="top" data-toggle="confirmation" data-title="Supprimer le fournisseur '.$supplier->getName().' ?" data-content="ATTENTION ! La suppression est irréversible !" data-btn-ok-label="Supprimer" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/supprimer_fournisseur.php?idSupplier='.$supplier->getIdSupplier().'"><i class="fas fa-trash-alt" alt="Supprimer"></i> Supprimer</a></td>';
                                }
                                elseif($supplier->getIsActive() == 0 && $credential == 'A')
                                {
                                    echo '<td><a class="btn green-dark" data-placement="top" data-toggle="confirmation" data-title="Réactiver le fournisseur '.$supplier->getName().'?" data-btn-ok-label="Réactiver" data-btn-ok-class="btn-success" data-btn-cancel-label="Annuler" data-btn-cancel-class="btn-danger" data-href="'.URLHOST.'_pages/_post/reactiver_fournisseur.php?idSupplier='.$supplier->getIdSupplier().'"><i class="fas fa-toggle-on" alt="Reactiver"></i> Reactiver</a></td>';
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