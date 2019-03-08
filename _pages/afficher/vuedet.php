<?php

/**
 * @author Nicolas
 * @copyright 2019
 */
include("../../_cfg/cfg.php");

$array = array();
$companyNameData = $_GET["section"];
$type = $_GET['cat'];
$type2 = $_GET['soussouscat'];
$idQuotation = $_GET['soussoussouscat'];

$company = new Company($array);
$companymanager = new CompaniesManager($bdd);
$folder = new Folder($array);
$foldermanager = new FoldersManager($bdd);
$user = new Users($array);
$usermanager = new UsersManager($bdd);
$customer = new Customers($array);
$customermanager = new CustomersManager($bdd);
$quotation = new Quotation($array);
$quotationmanager = new QuotationManager($bdd);


switch($type){
    case "devis":
        //echo $idQuotation;
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation);
        print_r($quotation);
        break;
    case "proforma":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation);
        break;
    case "facture":
        $quotation = $quotationmanager->getByQuotationNumber($idQuotation);
        break;
}
$folder = $foldermanager->get($quotation->getFolderId());
$company = $companymanager->getByNameData($companyNameData);
$descriptions = new Description($array);
$descriptionmanager = new DescriptionManager($bdd);
$descriptions = $descriptionmanager->getByQuotationNumber($quotation->getQuotationNumber());
$contact = $contactmanager->getById($folder->getContactId());
$user = $usermanager->get($folder->getSeller());
$customer = $customermanager->getById($quotation->getCustomerId());
$date = date('d/m/Y',strtotime(str_replace('/','-',"".$quotation->getDay().'/'.$quotation->getMonth().'/'.$quotation->getYear()."")));


?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="portlet yellow-crusta box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fas fa-info"></i>Informations</div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-5 name"> <?php echo ucwords($type); ?>: </div>
                            <div class="col-md-7 value"> <?php echo $quotation->getQuotationNumber(); ?></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Date: </div>
                            <div class="col-md-7 value"> <?php echo $date; ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Dossier N°: </div>
                            <div class="col-md-7 value"><?php echo $folder->getFolderNumber(); ?></div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Libellé : </div>
                            <div class="col-md-7 value"> <?php echo $folder->getLabel(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Commercial : </div>
                            <div class="col-md-7 value"> <?php echo $user->getName().' '.$user->getFirstName(); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="portlet blue-hoki box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Informations client </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row static-info">
                            <div class="col-md-5 name"> Client: </div>
                            <div class="col-md-7 value"> <?php echo $customer->getName(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Adresse: </div>
                            <div class="col-md-7 value"> <?php echo $customer->getInvoiceAddress(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Contact: </div>
                            <div class="col-md-7 value"> <?php echo $contact->getFirstname()." ".$contact->getName(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Téléphone: </div>
                            <div class="col-md-7 value"> <?php echo $contact->getPhoneNumber(); ?> </div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-5 name"> Mail: </div>
                            <div class="col-md-7 value"> <?php echo $contact->getEmailAddress(); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet grey-cascade box">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Shopping Cart </div>
                        <div class="actions">
                            <a href="javascript:;" class="btn btn-default btn-sm">
                                <i class="fa fa-pencil"></i> Edit </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Product </th>
                                        <th> Item Status </th>
                                        <th> Original Price </th>
                                        <th> Price </th>
                                        <th> Quantity </th>
                                        <th> Tax Amount </th>
                                        <th> Tax Percent </th>
                                        <th> Discount Amount </th>
                                        <th> Total </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="javascript:;"> Product 1 </a>
                                        </td>
                                        <td>
                                            <span class="label label-sm label-success"> Available </td>
                                        <td> 345.50$ </td>
                                        <td> 345.50$ </td>
                                        <td> 2 </td>
                                        <td> 2.00$ </td>
                                        <td> 4% </td>
                                        <td> 0.00$ </td>
                                        <td> 691.00$ </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="javascript:;"> Product 1 </a>
                                        </td>
                                        <td>
                                            <span class="label label-sm label-success"> Available </td>
                                        <td> 345.50$ </td>
                                        <td> 345.50$ </td>
                                        <td> 2 </td>
                                        <td> 2.00$ </td>
                                        <td> 4% </td>
                                        <td> 0.00$ </td>
                                        <td> 691.00$ </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="javascript:;"> Product 1 </a>
                                        </td>
                                        <td>
                                            <span class="label label-sm label-success"> Available </td>
                                        <td> 345.50$ </td>
                                        <td> 345.50$ </td>
                                        <td> 2 </td>
                                        <td> 2.00$ </td>
                                        <td> 4% </td>
                                        <td> 0.00$ </td>
                                        <td> 691.00$ </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="javascript:;"> Product 1 </a>
                                        </td>
                                        <td>
                                            <span class="label label-sm label-success"> Available </td>
                                        <td> 345.50$ </td>
                                        <td> 345.50$ </td>
                                        <td> 2 </td>
                                        <td> 2.00$ </td>
                                        <td> 4% </td>
                                        <td> 0.00$ </td>
                                        <td> 691.00$ </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"> </div>
            <div class="col-md-6">
                <div class="well">
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Sub Total: </div>
                        <div class="col-md-3 value"> $1,124.50 </div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Shipping: </div>
                        <div class="col-md-3 value"> $40.50 </div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Grand Total: </div>
                        <div class="col-md-3 value"> $1,260.00 </div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Total Paid: </div>
                        <div class="col-md-3 value"> $1,260.00 </div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Total Refunded: </div>
                        <div class="col-md-3 value"> $0.00 </div>
                    </div>
                    <div class="row static-info align-reverse">
                        <div class="col-md-8 name"> Total Due: </div>
                        <div class="col-md-3 value"> $1,124.50 </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>