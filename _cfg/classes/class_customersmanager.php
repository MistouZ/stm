<?php
/**
 * Created by PhpStorm.
 * customer: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class CustomersManager
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * customersManager constructor.
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
     * @param customers $customer
     * Insertion customer in the DB
     */
    public function add(Customers $customer, array $companies)
    {
        $q = $this->_db->prepare('INSERT INTO customers (name, physicalAddress,invoiceAddress,isActive) VALUES (:name, :physicalAddress, :invoiceAddress,:isActive)');
        $q->bindValue(':name', $customer->getName(), PDO::PARAM_STR);
        $q->bindValue(':physicalAddress', $customer->getPhysicalAddress(), PDO::PARAM_STR);
        $q->bindValue(':invoiceAddress', $customer->getInvoiceAddress(), PDO::PARAM_STR );
        $q->bindValue(':isActive', $customer->getisActive(), PDO::PARAM_INT);

        $q->execute();



        for ($i=0;$i<count($companies);$i++)
        {
            $q2 = $this->_db->prepare('INSERT INTO link_company_customers (customers_idcustomer, company_idcompany) VALUES (:idcustomer, :idcompany)');
            $q2->bindValue(':idcustomer', $customer->getIdCustomer(), PDO::PARAM_INT);
            $q2->bindValue(':idcompany', $companies[$i], PDO::PARAM_INT);
            $q2->execute();
        }
    }

    /**
     * @param customers $customer
     * Disable customer instead of delete it
     */
    public function delete(Customers $customer)
    {
        $q = $this->_db->prepare('UPDATE customers SET isActive = 0 WHERE idcustomers = :idcustomers');
        $q->bindValue(':idcustomers', $customer->getIdCustomer(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * Find a customer by his customername
     * @param $customername
     * @return customers
     */
    public function getByName($customername)
    {
        $customername = (string) $customername;
        $q = $this->_db->query('SELECT * FROM customers WHERE name ='.$customername);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Customers($donnees);
    }


    /**
     * @param $idcustomer
     * @return Customers
     */
    public function getByID($idcustomer)
    {
        $idcustomer = (integer) $idcustomer;
        $q = $this->_db->query('SELECT * FROM `customers` WHERE `idcustomer` ='.$idcustomer);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Customers($donnees);
    }


    /**
     * Get all the customers in the BDD
     * @return array
     */
    public function getList()
    {
        $customers = array();

        $q=$this->_db->query("SELECT * FROM customers WHERE isActive = '1' ORDER BY name DESC");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $customers[] = new Customers($donnees);
        }

        return $customers;
    }

    /**
     * Update customers information
     * @param customers $customer
     */
    public function update(customers $customer)
    {
        $q = $this->_db->prepare('UPDATE customers SET name = :name, pysicalAddress = :physicalAddress, invoiceAddress = :invoiceAddress, isActive = :isActive  WHERE idcustomers = :idcustomers');
        $q->bindValue(':idcustomers', $customer->getIdCustomer(), PDO::PARAM_STR);
        $q->bindValue(':name', $customer->getName(), PDO::PARAM_STR);
        $q->bindValue(':physicalAddress', $customer->getPhysicalAddress(), PDO::PARAM_STR);
        $q->bindValue(':invoiceAddress', $customer->getInvoiceAddress(), PDO::PARAM_STR );
        $q->bindValue(':isActive', $customer->getisActive(), PDO::PARAM_INT);

        $q->execute();
    }

}