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
        $q = $this->_db->prepare('INSERT INTO tax (name, value,isActive) VALUES (:name, :value,:isActive)');
        $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
        $q->bindValue(':values', $tax->getValue(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * @param Tax $Tax
     * Insertion tax in the DB
     */
    public function addToCustomers(Tax $tax, $customers)
    {
        $q = $this->_db->prepare('INSERT INTO tax (name, value,isActive) VALUES (:name, :value,:isActive)');
        $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
        $q->bindValue(':values', $tax->getValue(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);

        $q->execute();

        $tax = $this->getByName($tax->getName());

        $q2 = $this->_db->prepare('INSERT INTO link_customers_taxes (customers_idcustomers, tax_idtax) VALUES (:idcustomer, :idtax)');
        $q2->bindValue(':idcustomer', $customers, PDO::PARAM_INT);
        $q2->bindValue(':idtax', $tax->getIdTax(), PDO::PARAM_INT);

        $q2->execute();

    }

    /**
     * @param Tax $tax
     * Disable tax instead of delete it
     */
    public function delete(Tax $tax)
    {
        $q = $this->_db->prepare('UPDATE tax SET isActive = \'0\' WHERE idTax = :idTax');
        $q->bindValue(':idTax', $tax->getIdTax(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * Find a tax by his idTax
     * @param $idtax
     * @return Tax
     */
    public function getById($idtax)
    {
        $idtax = (integer) $idtax;
        $q = $this->_db->query('SELECT * FROM tax WHERE idTax ='.$idtax);
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

        $query = "SELECT t.* FROM tax t WHERE t.isActive='1'";
        echo $query;

       /* $q=$this->_db->query("SELECT t.* FROM tax t WHERE t.isActive='1'");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $taxes[] = new Tax($donnees);
        }

        return $taxes;*/
    }


    /**
     * Get all the taxes in the BDD link to customers
     * @return array
     */
    public function getListByCustomer($customerId)
    {
        $taxes = [];

        $q=$this->_db->query("SELECT t.* FROM tax t INNER JOIN  link_customers_taxes lk ON t.idTax =  lk.tax_idtax INNER JOIN customers c ON lk.customers_idcustomers = c.idcustomer WHERE t.isActive='1' and c.isActive='1' and c.idcustomer =".$customerId);
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
        $q = $this->_db->prepare('UPDATE tax SET name = :name, value = :value, isActive = :isActive  WHERE idTax = :idTax');
        $q->bindValue(':idTax', $tax->getIdTax(), PDO::PARAM_INT);
        $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
        $q->bindValue(':values', $tax->getValue(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);

        $q->execute();
    }

}