<?php
/**
 * Created by PhpStorm.
 * supplier: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class SuppliersManager
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * suppliersManager constructor.
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
     * @param suppliers $supplier
     * Insertion supplier in the DB
     */
    public function add(Suppliers $supplier, array $companies)
    {
        $q = $this->_db->prepare('INSERT INTO suppliers (name, pysicalAddress,invoiceAddress,isActive) VALUES (:name, :physicalAddress, :invoiceAddress,:isActive)');
        $q->bindValue(':name', $supplier->getName(), PDO::PARAM_STR);
        $q->bindValue(':physicalAddress', $supplier->getPhysicalAddress(), PDO::PARAM_STR);
        $q->bindValue(':invoiceAddress', $supplier->getInvoiceAddress(), PDO::PARAM_STR );
        $q->bindValue(':isActive', $supplier->getisActive(), PDO::PARAM_INT);

        $q->execute();



        for ($i=0;$i<count($companies);$i++)
        {
            $q2 = $this->_db->prepare('INSERT INTO link_company_suppliers (suppliers_idsupplier, company_idcompany) VALUES (:idsupplier, :id_company)');
            $q2->bindValue(':idsupplier', $supplier->getIdSupplier(), PDO::PARAM_STR);
            $q2->bindValue(':id_company', $companies[$i], PDO::PARAM_INT);
            $q2->execute();
        }
    }

    /**
     * @param suppliers $supplier
     * Disable supplier instead of delete it
     */
    public function delete(Suppliers $supplier)
    {
        $q = $this->_db->prepare('UPDATE suppliers SET isActive = 0 WHERE idsuppliers = :idsuppliers');
        $q->bindValue(':idsuppliers', $supplier->getIdSupplier(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * @param $idsupplier
     * @return Suppliers
     */
    public function getById($idsupplier)
    {
        $idsupplier = (int) $idsupplier;
        $query = 'SELECT * FROM suppliers WHERE id ='.$idsupplier;
        echo $query;
        /*$q = $this->_db->query('SELECT * FROM suppliers WHERE id ='.$idsupplier);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Suppliers($donnees);*/
    }

    /**
     * Find a supplier by his suppliername
     * @param $suppliername
     * @return suppliers
     */
    public function getByName($suppliername)
    {
        $suppliername = (string) $suppliername;
        $q = $this->_db->query('SELECT * FROM suppliers WHERE name ='.$suppliername);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Suppliers($donnees);
    }



    /**
     * Get all the suppliers in the BDD
     * @return array
     */
    public function getList()
    {
        $suppliers = [];

        $q=$this->_db->query("SELECT * FROM suppliers WHERE isActive = '1' ORDER BY NAME ASC ");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $suppliers[] = new Suppliers($donnees);
        }

        return $suppliers;
    }

    /**
     * Update suppliers information
     * @param suppliers $supplier
     */
    public function update(Suppliers $supplier)
    {
        $q = $this->_db->prepare('UPDATE suppliers SET name = :name, pysicalAddress = :physicalAddress, invoiceAddress = :invoiceAddress, isActive = :isActive  WHERE idsuppliers = :idsuppliers');
        $q->bindValue(':idsuppliers', $supplier->getIdSupplier(), PDO::PARAM_STR);
        $q->bindValue(':name', $supplier->getName(), PDO::PARAM_STR);
        $q->bindValue(':physicalAddress', $supplier->getPhysicalAddress(), PDO::PARAM_STR);
        $q->bindValue(':invoiceAddress', $supplier->getInvoiceAddress(), PDO::PARAM_STR );
        $q->bindValue(':isActive', $supplier->getisActive(), PDO::PARAM_INT);

        $q->execute();
    }

}