<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 06/03/2019
 * Time: 10:39
 */

class DescriptionManager
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * UsersManager constructor.
     * @param $_db
     */
    public function __construct($_db)
    {
        $this->_db = $_db;
    }

    /**
     * @param mixed $db
     */
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }

    /**
     * @param array $descriptions
     * @param $quotationNumber
     * @return string|null
     */
    public function add(array $descriptions, $quotationNumber,$quotationType,$companyId)
    {
        try{
            $array = array();
            $description = new Description($array);
           foreach ($descriptions as $description)
            {
                $q = $this->_db->prepare('INSERT INTO description (quotationNumber, quotationType, description,quantity,discount,price,tax,companyId) VALUES (:quotationNumber, :quotationType,  :description, :quantity, :discount, :price, :tax, :companyId)');
                $q->bindValue(':quotationNumber', $quotationNumber, PDO::PARAM_STR);
                $q->bindValue(':quotationType', $quotationType, PDO::PARAM_STR);
                $q->bindValue(':description', $description->getDescription(), PDO::PARAM_STR);
                $q->bindValue(':quantity', $description->getQuantity(),PDO::PARAM_STR);
                $q->bindValue(':discount',  $description->getDiscount(),PDO::PARAM_INT);
                $q->bindValue(':price', $description->getPrice(),PDO::PARAM_INT);
                $q->bindValue(':tax', $description->getTax(),PDO::PARAM_STR);
                $q->bindValue(':companyId', $companyId,PDO::PARAM_INT);
                $q->execute();
            }

          return "ok";
        }
        catch(Exception $e){
            return null;
        }

    }

    /**
     * Find a Quotation by his iD
     * @param $quotationNumber
     * @return quotation
     */
    public function getByQuotationNumber($quotationNumber, $quotationType,$companyId)
    {
        $description = array();
        try{
            $quotationNumber = (string) $quotationNumber;
            $q = $this->_db->query("SELECT * FROM description WHERE quotationNumber = '$quotationNumber' and quotationType = '$quotationType' AND companyId='$companyId' ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $description[] =new Description($donnees);
            }

            return $description;
        }
        catch(Exception $e){
            return null;
        }
    }

    /*
    * Modification du type de quotation en proforma, devis, facture ou avoir sur la description
    *
    */

    public function changeQuotationType($quotationNumber,$quotationType,$companyId)
    {
        $q = $this->_db->prepare('UPDATE description SET quotationType = :quotationType WHERE quotationNumber = :quotationNumber AND companyId = :companyId');
            
            $q->bindValue(':quotationNumber', $quotationNumber, PDO::PARAM_STR);
            $q->bindValue(':quotationType', $quotationType, PDO::PARAM_STR);
            $q->bindValue(':companyId', $companyId, PDO::PARAM_INT);

            $q->execute();
            return $quotationNumber;

    }

    /**
     * @param $quotationNumber
     * @return array|null
     */
    public function getOption($quotationNumber)
    {
        $description = array();
        try{
            $quotationNumber = (string) $quotationNumber;
            $q = $this->_db->query("SELECT * FROM description WHERE quotationNumber = '".$quotationNumber."_option'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $description[] =new Description($donnees);
            }

            return $description;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * @param $quotationNumber
     * @return string|null
     */
    public function delete($quotationNumber, $quotationType, $companyId)
    {
        try{

            $delete=$this->_db->query("DELETE FROM `description` WHERE quotationNumber ='$quotationNumber' and quotationType = '".$quotationType."' AND companyId = '$companyId'");
            $delete->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * @param array $description
     * @param $quotationNumber
     * @return array|null
     */
    public function update(array $description, $quotationNumber, $quotationType, $quotationNewType, $companyId)
    {
        try{
            $test = $this->delete($quotationNumber, $quotationType, $companyId);
            if(!is_null($test))
            {
                echo "suppresion réussie ".$quotationNumber;
            }
            $test2 =$this->add($description,$quotationNumber,$quotationNewType, $companyId);
            if(!is_null($test2))
            {
                echo "Ajout réussie ".$quotationNumber;
            }
            return $description;
        }
        catch(Exception $e){
            return null;
        }
    }

}