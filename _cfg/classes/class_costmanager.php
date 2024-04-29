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
    public function add(array $costs, $quotationNumber, $type, $companyId)
    {

        try{
            $array = array();
            $cost = new Cost($array);
            foreach ($costs as $cost)
            {
                $q = $this->_db->prepare('INSERT INTO cost (description, value, quotationNumber, type, folderId,supplierId,companyId) VALUES (:description, :value, :quotationNumber, :type, :folderId, :supplierId, :companyId)');
                $q->bindValue(':quotationNumber', $quotationNumber, PDO::PARAM_INT);
                $q->bindValue(':type', $type, PDO::PARAM_STR);
                $q->bindValue(':description', $cost->getDescription(), PDO::PARAM_STR);
                $q->bindValue(':value', $cost->getValue(), PDO::PARAM_INT);
                $q->bindValue(':folderId', $cost->getFolderId(), PDO::PARAM_INT);
                $q->bindValue(':supplierId', $cost->getSupplierId(), PDO::PARAM_INT);
                $q->bindValue(':companyId', $companyId, PDO::PARAM_INT);

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
    public function deleteByQuotationNumber($quotationNumber, $type, $companyId)
    {
        try{
            $q = $this->_db->query("DELETE FROM cost WHERE quotationNumber='$quotationNumber' AND type='$type' AND companyId='$companyId'");
            $q->execute();

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
     * @param $costId
     * @return cost
     */

    public function getByCostId($costId)
    {
        
        try{
            $costId = (integer) $costId;
            $q = $this->_db->query("SELECT * FROM cost WHERE idcost='$costId'");
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new Cost($donnees);
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
    public function getByQuotationNumber($quotationNumber, $type,$companyId)
    {
        $costs = array();
        try{
            $quotationNumber = (string) $quotationNumber;
            $q = $this->_db->query("SELECT * FROM cost WHERE quotationNumber = '$quotationNumber' AND type='$type' AND companyId = '$companyId' ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $costs[] =new Cost($donnees);
            }

            return $costs;
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
        $costs = array();
        try{
            $folderId = (string) $folderId;
            $q = $this->_db->query("SELECT * FROM `cost` WHERE folderId = '$folderId'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $costs[] = new Cost($donnees);
            }

            return $costs;
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Find all Costs from Filtered Folders
     * @param $folders
     * @param $folder
     * @return Cost
     */
    public function getCostByFilteredFolder($folders, $folder)
    {
        $costs = array();
        try{
            foreach ($folders as $folder) {
                $folderId = $folder->getIdFolder();
                $q = $this->_db->query("SELECT * FROM `cost` WHERE folderId = '$folderId'");
                while ($donnees = $q->fetch(PDO::FETCH_ASSOC)) {
                    $costs[] = new Cost($donnees);
                }
            }
            return $costs;
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
        $costs = array();
        try{
            $supplierId = (string) $supplierId;
            $q = $this->_db->query("SELECT * FROM `cost` WHERE supplierId = '$supplierId'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $costs[] = new Cost($donnees);
            }

            return $costs;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the cost in the BDD from the Filtered Folders
     * @return array
     */
    public function getCostByFilteredQuotation($quotations, $quotation, $type)
    {
        try{
            $costs = [];
            foreach ($quotations as $quotation)
            {
                $quotationNumber = $quotation->getQuotationNumber();
                $query = "SELECT * FROM `cost` WHERE quotationNumber='$quotationNumber' AND type ='$type' ORDER BY quotationNumber DESC";
                $q=$this->_db->query($query);
                while($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                    $costs[] = new Cost($donnees);
                }
            }
            return $costs;
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
    public function update(array $cost, $quotationNumber, $type, $companyId)
    {
        try{
            //print_r($cost);
            $this->deleteByQuotationNumber($quotationNumber, $type, $companyId);
            /*if(!is_null($test))
            {
                echo "suppresion réussie ".$quotationNumber;
            }*/
            $test = $this->add($cost,$quotationNumber, $type,$companyId);
            return $cost;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find Update Cost type while quotation type change
     * @param $quotationNumber
     * @return cost
     */
    public function UpdateCostType($quotatioNumberEdited, $quotationNumber, $type,$companyId)
    {
        try{
            $q = $this->_db->prepare("UPDATE cost SET quotationNumber = :quotationNumberEdited, type = :type WHERE quotationNumber = :quotationNumber AND companyId ='$companyId'");
            $q->bindValue(':quotationNumberEdited', $quotatioNumberEdited, PDO::PARAM_INT);
            $q->bindValue(':quotationNumber', $quotationNumber, PDO::PARAM_INT);
            $q->bindValue(':type', $type, PDO::PARAM_STR);   
            $q->execute();

            
            return "Ok";
        }
        
        catch(Exception $e){
            return null;
        }
    }



    

}