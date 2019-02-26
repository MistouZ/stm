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
        $q = $this->_db->prepare('INSERT INTO tax (percent, name, value,isActive) VALUES (:percent, :name, :value,:isActive)');
        $q->bindValue(':percent', $tax->getPercent(), PDO::PARAM_STR);
        $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
        $q->bindValue(':value', $tax->getValue(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);

        $q->execute();
    }

     /**
     * @param Tax $tax
     * Disable tax instead of delete it
     */
    public function delete(Tax $tax)
    {
        $q = $this->_db->prepare('UPDATE tax SET isActive = \'0\' WHERE percent = :percent');
        $q->bindValue(':idTax', $tax->getPercent(), PDO::PARAM_STR);

        $q->execute();
    }

    /**
     * Find a tax by his idTax
     * @param $idtax
     * @return Tax
     */
    public function getByPercent($percenttax)
    {
        $percenttax = (integer) $percenttax;
        $q = $this->_db->query('SELECT * FROM tax WHERE percent ='.$percenttax);
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
     * Get all the taxes in the BDD
     * @return array
     */
    public function getList()
    {
        $taxes = [];


       $q=$this->_db->query("SELECT * FROM tax WHERE isActive='1' ORDER BY name ASC");
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

        $q=$this->_db->query("SELECT t.* FROM tax t INNER JOIN  link_customers_taxes lk ON t.percent =  lk.tax_percent INNER JOIN customers c ON lk.customers_idcustomers = c.idcustomer WHERE t.isActive='1' and c.isActive='1' and c.idcustomer =".$customerId);
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
        $q = $this->_db->prepare('UPDATE tax SET name = :name, percent = :percent, value = :value, isActive = :isActive  WHERE percent = :percent');
        $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
        $q->bindValue(':percent', $tax->getPercent(), PDO::PARAM_STR);
        $q->bindValue(':values', $tax->getValue(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);

        $q->execute();
    }

}