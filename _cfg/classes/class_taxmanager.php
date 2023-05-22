<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class TaxManager
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * ContactManager constructor.
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
     * Adding taxes to the programme
     * @param Tax $tax
     */
    public function add(Tax $tax)
    {

        try{
            $q = $this->_db->prepare('INSERT INTO tax (percent, name, value,isActive, isDefault) VALUES (:percent, :name, :value,:isActive, :isDefault)');
            $q->bindValue(':percent', $tax->getPercent(), PDO::PARAM_STR);
            $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
            $q->bindValue(':value', $tax->getValue(), PDO::PARAM_STR);
            $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);
            $q->bindValue(':isDefault', $tax->getIsDefault(), PDO::PARAM_INT);

            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

     /**
     * @param Tax $tax
     * Disable tax instead of delete it
     */
    public function delete(Tax $tax)
    {
        try{
            $q = $this->_db->prepare('UPDATE tax SET isActive = \'0\' WHERE idTax = :idTax');
            $q->bindValue(':idTax', $tax->getIdTax(), PDO::PARAM_STR);
            $q->execute();
            
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find a tax by his idTax
     * @param $idtax
     * @return Tax
     */
    public function getById($idTax)
    {
        $idTax = (integer) $idTax;
        $q = $this->_db->query('SELECT * FROM tax WHERE idTax ='.$idTax);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Tax($donnees);
    }

    /**
     * Find a tax by his TaxName
     * @param $taxName
     * @return Tax
     */
    public function getByName($taxName)
    {
        $taxName = (string) $taxName;
        $q = $this->_db->query('SELECT * FROM tax WHERE name ="'.$taxName.'"');
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        return new Tax($donnees);
    }
    /**
     * Find a tax by his TaxName
     * @param $taxName
     * @return Tax
     */
    public function getByPercent($taxPercent)
    {
        try{
            $q = $this->_db->query('SELECT * FROM tax WHERE percent LIKE "'.$taxPercent.'"');
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
            if($donnees)
            {
                return new Tax($donnees);
            }
            else
            {
                return null;
            }
        }

        catch(Exception $e){
            return null;
        }


    }


    /**
     * Get all the taxes in the BDD
     * @return array
     */
    public function getList()
    {
        $taxes = [];


       $q=$this->_db->query("SELECT * FROM tax WHERE isActive='1' ORDER BY value ASC");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $taxes[] = new Tax($donnees);
        }

        return $taxes;
    }

    /**
     * Get all the taxes in the BDD
     * @return array
     */
    public function getAllTaxes()
    {
        $taxes = [];


        $q=$this->_db->query("SELECT * FROM tax  ORDER BY value ASC");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $taxes[] = new Tax($donnees);
        }

        return $taxes;
    }

    /**
     * Get all the taxes in the BDD link to customers
     * @return array
     */
    public function getListByCustomer($customerId)
    {
        $taxes = [];


        $q=$this->_db->query("SELECT t.* FROM tax t INNER JOIN  link_customers_taxes lk ON t.idTax =  lk.tax_idTax INNER JOIN customers c ON lk.customers_idcustomer = c.idcustomer WHERE t.isActive='1' and c.isActive='1' and c.idcustomer =".$customerId);
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $taxes[] = new Tax($donnees);
        }

        return $taxes;
    }

    /**
     * Update tax information
     * @param Tax $tax
     */

    public function update(Tax $tax)
    {
        try{
            $q = $this->_db->prepare('UPDATE tax SET name = :name, percent = :percent, value = :value, isActive = :isActive, isDefault = :isDefault  WHERE idTax = :idTax');
            $q->bindValue(':idTax', $tax->getIdTax(), PDO::PARAM_INT);
            $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
            $q->bindValue(':percent', $tax->getPercent(), PDO::PARAM_STR);
            $q->bindValue(':value', $tax->getValue(), PDO::PARAM_STR);
            $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);
            $q->bindValue(':isDefault', $tax->getIsDefault(), PDO::PARAM_INT);

            $q->execute();
            
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Reactivate the tax
     * @param Tax $tax
     */
    public function reactivate(Tax $tax)
    {
        try{
            $q = $this->_db->prepare('UPDATE tax SET isActive = \'1\' WHERE idTax = :idTax');
            $q->bindValue(':idTax', $tax->getIdTax(), PDO::PARAM_INT);
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

}