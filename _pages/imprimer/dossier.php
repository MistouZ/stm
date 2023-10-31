<?php

/**
 * @author Amaury
 * @copyright 2020
 */

include("../../_cfg/cfg.php");
$array = array();
$companyNameData = $_GET["section"];

if(isset($_POST['imprimer'])) {
    $folderId = $_GET['soussouscat'];

    $company = new Company($array);
    $companymanager = new CompaniesManager($bdd);
    $folder = new Folder($array);
    $foldermanager = new FoldersManager($bdd);
    $user = new Users($array);
    $usermanager = new UsersManager($bdd);
    $customer = new Customers($array);
    $customermanager = new CustomersManager($bdd);
    $contact = new Contact($array);
    $contactmanager = new ContactManager($bdd);


    $folder = $foldermanager->get($folderId);


    $company = $companymanager->getByNameData($companyNameData);
    $user = $usermanager->get($folder->getSeller());
    $customer = $customermanager->getById($folder->getCustomerId());
    $contact = $contactmanager->getById($folder->getContactId());

    $date = date('d/m/Y', strtotime(str_replace('/', '-', "" . $folder->getDate() . "")));
    $company = $companymanager->getByNameData($companyNameData);
}
?>
<div class="row" xmlns="http://www.w3.org/1999/html">
    <div id="myCanvas">
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
                                    <div class="col-md-5 name"> Dossier N°: </div>
                                    <div class="col-md-7 value"><?php echo $folder->getFolderNumber(); ?></div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Date: </div>
                                    <div class="col-md-7 value"> <?php echo $date; ?></div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Libellé : </div>
                                    <div class="col-md-7 value"> <?php echo $folder->getLabel(); ?> </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Commercial : </div>
                                    <div class="col-md-7 value"> <?php echo $user->getName().' '.$user->getFirstName(); ?> </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">&nbsp;</div>
                                    <div class="col-md-7 value">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="portlet blue-hoki box">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fas fa-user-tie"></i>Informations client </div>
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
            </div>
        </div>
        <div>
            <div class="col-md-12">
                <div class="portlet box green">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fas fa-folder-open"></i> <span style="margin-left: 5px">Observation sur le dossier</span></div>
                    </div>
                    <div style="height: 700px; background-color : white">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="filename" name="filename" value="Dossier - <?php echo $company->getName()."-".$folder->getFolderNumber(); ?>">
    <button id="Exporter" onclick="ExportPdf()">Exporter</button>
</div>


<link rel="stylesheet" href="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.default-v2.min.css"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/js/kendo.all.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/js/jszip.min.js"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.common-boostrap.min.css"></script>
<script src="https://kendo.cdn.telerik.com/2020.2.513/styles/kendo.boostrap.min.css"></script>
src="
<script>
    // Import DejaVu Sans font for embedding
    kendo.pdf.defineFont({
        "DejaVu Sans":
            "http://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans.ttf",

        "DejaVu Sans|Bold":
            "http://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",

        "DejaVu Sans|Bold|Italic":
            "http://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",

        "DejaVu Sans|Italic":
            "http://cdn.kendostatic.com/2020.2.513/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",

        "WebComponentsIcons"      :
            "https://kendo.cdn.telerik.com/2020.2.513/styles/fonts/glyphs/WebComponentsIcons.ttf",

        "FontAwesome":
            "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/webfonts/fa-solid-900.ttf"


    });
</script>
<script type="x/kendo-template" id="page-template">
    <div class="page-template">
        <div class="header" >
            <img src="<?php echo URLHOST; ?>images/societe/<?php echo $companyNameData; ?>.jpg" alt="<?php echo $companyNameData; ?>" class="logo-default" style="max-height: 60px;" />
        </div>
        <div class="footer">
            <h5> #:pageNum# / #:totalPages# </h5>
        </div>
    </div>
</script>
<script type="text/javascript" language="javascript">

    window.onload = function() {
        document.getElementById('Exporter').click();
    }

    function closeWindow() {
        setTimeout(function() {
            window.close();
        }, 3000); // 300 pour NC sur serveur MLS
    }

    function ExportPdf(){
        var filename = document.getElementById("filename").value;
        kendo.drawing
            .drawDOM("#myCanvas",
                {
                    paperSize: "A4",
                    multiPage : true,
                    margin: { top: "4cm", bottom: "2cm", right: "1cm", left: "1cm" },
                    scale: 0.65,
                    height: 500,
                    template: $("#page-template").html(),
                    keepTogether: ".prevent-split"
                })
            .then(function(group){
                kendo.drawing.pdf.saveAs(group, filename+".pdf")
            });
       window.onload = closeWindow();
    }
</script>
<style>
    /*
        Make sure everything in the page template is absolutely positioned.
        All positions are relative to the page container.
    */
    .page-template > * {
        position: absolute;
        left: 20px;
        right: 20px;
        font-size: 90%;
    }
    .page-template .header {
        top: 20px;
        text-align: center;
    }
    .page-template .footer {
        bottom: 20px;
        border-top: 1px solid #000;
        text-align: center;
    }
    .fas{
        font-family : FontAwesome;
    }
    /*
        Use the DejaVu Sans font for display and embedding in the PDF file.
        The standard PDF fonts have no support for Unicode characters.
    */
    #myCanvas {
        font-family: "DejaVu Sans", "Arial", sans-serif;
    }

</style>