<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 21/02/2019
 * Time: 09:43
 */

include("../../_cfg/cfg.php");
$contactId = $_GET["idContact"];

echo $contactId;

$array = array();
$contact = new Contact($array);
$contactmanager = new ContactManager($bdd);
$contactmanager->delete($contactId);
echo "Contact removed successfully </br/>";

?>
