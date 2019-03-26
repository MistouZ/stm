<?php
/**
 * Created by PhpStorm.
 * Folder: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class CostManager
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * folderManager constructor.
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
     * @param Cost $cost
     * @param $quotationNumber
     * @return string|null
     */
    public function add(array $costs, $quotationNumber)
    {

        try{
            $array = array();
            $cost = new Cost($array);
            foreach ($costs as $cost)
            {
                $q = $this->_db->prepare('INSERT INTO cost (description, value, quotationNumber, folderId,supplierId) VALUES (:description, :value, :quotationNumber, :folderId, :supplierId)');
                $q->bindValue(':quotationNumber', $quotationNumber, PDO::PARAM_STR);
                $q->bindValue(':description', $cost->getDescription(), PDO::PARAM_STR);
                $q->bindValue(':value', $cost->getValue(), PDO::PARAM_INT);
                $q->bindValue(':folderId', $cost->getFolderId(), PDO::PARAM_INT);
                $q->bindValue(':supplierId', $cost->getSupplierId(), PDO::PARAM_INT);

                $q->execute();
            }
            return "ok";
        }
        catch(Exception $e){
            return null;
        }

    }

    /**
     * @param $quotationNumber
     * @return string|null
     */
    public function deleteByQuotationNumber($quotationNumber)
    {
        try{
            $query = "DELETE FROM cost WHERE quotationNumber='$quotationNumber'";
            echo $query;
            //$q = $this->_db->query("DELETE FROM cost WHERE quotationNumber='$quotationNumber'");
            //$q->execute();

           return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * @param $costId
     * @return string|null
     */
    public function delete($costId)
    {
        try{
            $q = $this->_db->query("DELETE FROM cost WHERE idcost='$costId'");
            $q->execute();

            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find a Cost by his iD
     * @param $quotationNumber
     * @return cost
     */
    public function getByQuotationNumber($quotationNumber)
    {
        $cost = array();
        try{
            $quotationNumber = (string) $quotationNumber;
            $q = $this->_db->query("SELECT * FROM cost WHERE quotationNumber = '$quotationNumber'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $cost[] =new Cost($donnees);
            }

            return $cost;
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Find a Cost by his iD
     * @param $folderId
     * @return cost
     */
    public function getByFolderId($folderId)
    {
        $cost = array();
        try{
            $folderId = (string) $folderId;
            $q = $this->_db->query("SELECT * FROM `cost` WHERE folderId = '$folderId'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $cost[] = new Cost($donnees);
            }

            return $cost;
        }
        catch(Exception $e){
            return null;
        }
    }
    /**
     * Find a Cost by his iD
     * @param $supplierId
     * @return cost
     */
    public function getBySupplierId($supplierId)
    {
        $cost = array();
        try{
            $supplierId = (string) $supplierId;
            $q = $this->_db->query("SELECT * FROM `cost` WHERE supplierId = '$supplierId'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $cost[] = new Cost($donnees);
            }

            return $cost;
        }
        catch(Exception $e){
            return null;
        }
    }



    /**
     * @param array $cost
     * @param $quotationNumber
     * @return array|null
     */
    public function update(array $cost, $quotationNumber)
    {
        try{
            print_r($cost);
            $test = $this->deletedeleteByQuotationNumber($quotationNumber);
            if(!is_null($test))
            {
                echo "suppresion réussie ".$quotationNumber;
            }
            $this->add($cost,$quotationNumber);
            return $cost;
        }
        catch(Exception $e){
            return null;
        }
    }

}