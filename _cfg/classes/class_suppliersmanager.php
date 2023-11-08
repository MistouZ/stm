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
     * @param supplier $supplier
     * Insertion supplier in the DB
     */
    public function add(Suppliers $supplier, array $companies, $account, array $subaccount)
    {
        try{
            $q = $this->_db->prepare('INSERT INTO suppliers (name, physicalAddress,invoiceAddress,isActive) VALUES (:name, :physicalAddress, :invoiceAddress,:isActive)');
            $q->bindValue(':name', $supplier->getName(), PDO::PARAM_STR);
            $q->bindValue(':physicalAddress', $supplier->getPhysicalAddress(), PDO::PARAM_STR);
            $q->bindValue(':invoiceAddress', $supplier->getInvoiceAddress(), PDO::PARAM_STR );
            $q->bindValue(':isActive', $supplier->getIsActive(), PDO::PARAM_INT);
    
            $q->execute();

            $supplier = $this->getByName($supplier->getName());
    
            for ($i=0;$i<count($companies);$i++)
            {
                $q2 = $this->_db->prepare('INSERT INTO `link_company_suppliers` (company_idcompany, suppliers_idsupplier,account, subaccount) VALUES (:idcompany, :idsupplier,:account, :subaccount)');
                $q2->bindValue(':idsupplier', $supplier->getIdSupplier(), PDO::PARAM_INT);
                $q2->bindValue(':idcompany', $companies[$i], PDO::PARAM_INT);
                $q2->bindValue(':account', $account, PDO::PARAM_INT);
                $q2->bindValue(':subaccount', $subaccount[$companies[$i]], PDO::PARAM_STR );
                $q2->execute();
            }

            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * @param integer $idsupplier
     * Disable supplier instead of delete it
     */
    public function delete($idsupplier)
    {
        try{
            $q = $this->_db->prepare('UPDATE suppliers SET isActive = \'0\' WHERE idsupplier = :idsupplier');
            $q->bindValue(':idsupplier', $idsupplier, PDO::PARAM_INT);
    
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find a supplier by his name
     * @param $suppliername
     * @return supplier
     */
    public function getByName($suppliername)
    {
        $suppliername = (string) $suppliername;
        $q = $this->_db->query('SELECT * FROM suppliers WHERE name ="'.$suppliername.'"');
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Suppliers($donnees);
    }


    /**
     * @param $idsupplier
     * @return Suppliers
     */
    public function getByID($idsupplier)
    {
        $idsupplier = (integer) $idsupplier;
        $q = $this->_db->query('SELECT su.*, lk.account, GROUP_CONCAT(CONCAT_WS(\'_\', lk.company_idcompany, subaccount) SEPARATOR \', \') AS subaccount, GROUP_CONCAT(c.name SEPARATOR \', \') AS companyName FROM suppliers su INNER JOIN  link_company_suppliers lk ON su.idsupplier =  lk.suppliers_idsupplier INNER JOIN company c ON lk.company_idcompany = c.idcompany WHERE su.idsupplier='.$idsupplier.' AND su.isActive=\'1\' AND c.isActive=\'1\' GROUP BY su.name');
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        if($donnees != NULL )
        {
            return new Suppliers($donnees);
        }
        else
        {
            $array = array(
                'name' => "Fournisseur supprimé"
            );
            return new Suppliers($array);
        }

    }


    /**
     * Get all the active suppliers in the BDD
     * @return array
     */
    public function getList()
    {
        $suppliers = array();

        $q=$this->_db->query("SELECT * FROM suppliers WHERE isActive='1'");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $suppliers[] = new Suppliers($donnees);
        }

        return $suppliers;
    }

    /**
     * Get all the active suppliers in the BDD filtered by Company
     * @return array
     */
    public function getListByCompany($companyId)
    {
        $companyId = (integer) $companyId;
        $suppliers = array();
        $q=$this->_db->query('SELECT su.*, GROUP_CONCAT(c.name SEPARATOR \', \') AS companyName FROM suppliers su INNER JOIN  link_company_suppliers lk ON su.idsupplier =  lk.suppliers_idsupplier INNER JOIN company c ON lk.company_idcompany = c.idcompany WHERE c.idcompany='.$companyId.' AND su.isActive=\'1\' AND c.isActive=\'1\' GROUP BY su.name');
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $suppliers[] = new Suppliers($donnees);
        }

        return $suppliers;
    }

    /**
     * Get all the suppliers in the BDD filtered by Company
     * @return array
     */
    public function getListAllByCompany($companyId)
    {
        $companyId = (integer) $companyId;
        $suppliers = array();
        $q=$this->_db->query('SELECT su.*, GROUP_CONCAT(c.name SEPARATOR \', \') AS companyName FROM suppliers su INNER JOIN  link_company_suppliers lk ON su.idsupplier =  lk.suppliers_idsupplier INNER JOIN company c ON lk.company_idcompany = c.idcompany WHERE c.idcompany='.$companyId.' AND c.isActive=\'1\' GROUP BY su.name');
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $suppliers[] = new Suppliers($donnees);
        }

        return $suppliers;
    }

    /**
     * Update suppliers information
     * @param suppliers $suppliers
     */
    public function update(Suppliers $supplier, array $companies, $account, array $subaccount)
    {
        try{
            $q = $this->_db->prepare('UPDATE suppliers SET name = :name, physicalAddress = :physicalAddress, invoiceAddress = :invoiceAddress, isActive = :isActive  WHERE idsupplier = :idsupplier');
            $q->bindValue(':idsupplier', $supplier->getIdSupplier(), PDO::PARAM_INT);
            $q->bindValue(':name', $supplier->getName(), PDO::PARAM_STR);
            $q->bindValue(':physicalAddress', $supplier->getPhysicalAddress(), PDO::PARAM_STR);
            $q->bindValue(':invoiceAddress', $supplier->getInvoiceAddress(), PDO::PARAM_STR );
            $q->bindValue(':isActive', $supplier->getIsActive(), PDO::PARAM_INT);
    
            $q->execute();
            
            $delete=$this->_db->query('DELETE FROM `link_company_suppliers` WHERE suppliers_idsupplier ='.$supplier->getIdSupplier());
            $delete->execute();

            for ($i=0;$i<count($companies);$i++)
            {
                $q2 = $this->_db->prepare('INSERT INTO `link_company_suppliers` (company_idcompany, suppliers_idsupplier, account, subaccount) VALUES (:idcompany, :idsupplier, :account, :subaccount)');
                $q2->bindValue(':idsupplier', $supplier->getIdSupplier(), PDO::PARAM_INT);
                $q2->bindValue(':idcompany', $companies[$i], PDO::PARAM_INT);
                $q2->bindValue(':account', $account, PDO::PARAM_INT);
                $q2->bindValue(':subaccount', $subaccount[$companies[$i]], PDO::PARAM_STR );
                $q2->execute();
            }
    

            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Reactivate supplier
     * @param Suppliers $suppliers
     */
    public function reactivate(Suppliers $suppliers)
    {
       try{
           $q = $this->_db->prepare('UPDATE suppliers SET isActive = \'1\' WHERE idsupplier = :idsupplier');
           $q->bindValue(':idsupplier', $suppliers->getIdSupplier(), PDO::PARAM_INT);
           $q->execute();
           return "ok";
       }
       catch(Exception $e){
        return null;
       }
    }

}