<?php
/**
 * @author Amaury DEWYNTER
 * @copyright 2019
 */
include '../_cfg/cfg.php';
$array = array();
$companyNameData = $_GET["section"];
$username = $_COOKIE['username'];
/*
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$quotations = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);
$company = $companymanager->getByNameData($companyNameData);
*/
echo $username;
echo $companyNameData;
/*
print_r($company);

$foldermanager = $foldermanager->getListActiveByUser($username, $company->getIdcompany());
$quotations = $quotationmanager->getListQuotationByUser($foldermanager, $folder);
*/
?>


<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="dashboard-stat blue">
        <div class="visual">
            <i class="fas fa-folder-plus"></i>
        </div>
        <div class="details">
            <div class="number">
                +</span>
            </div>
            <div class="desc"> Nouveau dossier </div>
        </div>
        <a class="more" href="<?php echo URLHOST.$_COOKIE['company'];?>/dossier/creer"> Créer un dossier
            <i class="m-icon-swapright m-icon-white"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="dashboard-stat red">
        <div class="visual">
            <i class="fas fa-file-medical"></i>
        </div>
        <div class="details">
            <div class="number">
                + </div>
            <div class="desc"> Nouveau devis </div>
        </div>
        <a class="more" href="<?php echo URLHOST.$_COOKIE['company'];?>/devis/creer"> Créer un devis
            <i class="m-icon-swapright m-icon-white"></i>
        </a>
    </div>
</div>
<!--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="dashboard-stat green">
        <div class="visual">
            <i class="fas fa-file-contract"></i>
        </div>
        <div class="details">
            <div class="number">
                <i class="fas fa-search"></i></span>
            </div>
            <div class="desc"> Voir </div>
        </div>
        <a class="more" href="<?php echo URLHOST.$_COOKIE['company'];?>/devis/afficher"> Afficher la liste des devis
            <i class="m-icon-swapright m-icon-white"></i>
        </a>
    </div>
</div>-->
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="dashboard-stat green">
        <div class="visual">
            <i class="fas fa-file-contract"></i>
        </div>
        <div class="details">
            <div class="number">
                <i class="fas fa-search"><?php echo count($quotations)?></i></span>
            </div>
            <div class="desc"> Voir </div>
        </div>
        <a class="more" href="<?php echo URLHOST.$_COOKIE['company'].'/devis/afficher/cours/'.$username; ?>"> Afficher la liste des devis
            <i class="m-icon-swapright m-icon-white"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="dashboard-stat purple">
        <div class="visual">
            <i class="fas fa-folder-open"></i>
        </div>
        <div class="details">
            <div class="number">
                <i class="fas fa-search"></i></span></div>
            <div class="desc"> Voir </div>
        </div>
        <a class="more" href="<?php echo URLHOST.$_COOKIE['company'];?>/dossier/afficher"> Afficher la liste des dossiers
            <i class="m-icon-swapright m-icon-white"></i>
        </a>
    </div>
</div>