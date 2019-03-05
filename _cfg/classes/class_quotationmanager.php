<?php
/**
 * Created by PhpStorm.
 * Folder: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class FoldersManager
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
     * @return mixed
     */
    public function count($companyId)
    {
       return $this->_db->query('SELECT COUNT(*) FROM quotation WHERE companyId='.$companyId.' GROUP BY companyId')->fetchColumn();
    }

    /**
     * @param Quotation $quotation
     * Insertion Quotation in the DB
     */
    public function add(Quotation $quotation)
    {
        $quotationNumber = $this->count($quotation->getCompanyId());
        $quotationNumber = $quotationNumber + 1;
        
        try{
            $q = $this->_db->prepare('INSERT INTO quotation (quotationNumber, status, year,month,day,type,comment, companyId, customerId, contactId) VALUES (:quotationNumber, :status, :year, :month, :day, :comment, :companyId, :customerId, :contactId,)');
            $q->bindValue(':quotationNumber', $quotationNumber, PDO::PARAM_STR);
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':comment', $quotation->getComment(), PDO::PARAM_STR);
            $q->bindValue(':companyId', $quotation->getCompanyId(), PDO::PARAM_INT);
            $q->bindValue(':customerId', $quotation->getCustomerId(), PDO::PARAM_INT);
            $q->bindValue(':contactId', $quotation->getContactId(), PDO::PARAM_INT);

    
            $q->execute();
            
            return $quotationNumber;
        }
        catch(Exception $e){
            return null;
        }

    }

    /**
     * @param QuotationID
     * Disable quotation instead of delete it
     */
    public function delete($idQuotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET isActive = \'0\' WHERE 	idQuotation = :idQuotation');
            $q->bindValue(':idQuotation', $idQuotation, PDO::PARAM_INT);
            $q->execute();

            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find a Quotation by his iD
     * @param $idQuotation
     * @return quotation
     */
    public function get($idQuotation)
    {
        try{
            $idQuotation = (integer) $idQuotation;
            $q = $this->_db->query('SELECT * FROM quotation WHERE $idQuotation ='.$idQuotation);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
    
            return new Quotation($donnees);
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Get all the quotation in the BDD for the selected company
     * @return array
     */
    public function getList($companyid)
    {
        $quotations = [];

        $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid'");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $quotations[] = new Quotation($donnees);
        }

        return $quotations;
    }

    /**
     * Get all the active quotation in the BDD for the selected company
     * @return array
     */
    public function getListActive($companyid)
    {
        $quotations = [];

        $q=$this->_db->query("SELECT * FROM quotation WHERE companyId=$companyid AND isActive ='1' ");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $quotations[] = new Quotation($donnees);
        }

        return $quotations;
    }

    /**
     * Update quotation information
     * @param quotation $quotation
     */
    public function update(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET status = :status, year = :year,month = :month,day = :day,comment = :comment,companyId = :companyId,customerId = :customerId, customerId = :customerId, contactId = :contactId WHERE $idQuotation= :$idQuotation');
            $q->bindValue(':$idQuotation', $quotation->getIdQuotation(), PDO::PARAM_INT);
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':comment', $quotation->getComment(), PDO::PARAM_STR);
            $q->bindValue(':companyId', $quotation->getCompanyId(), PDO::PARAM_INT);
            $q->bindValue(':customerId', $quotation->getCustomerId(), PDO::PARAM_INT);
            $q->bindValue(':contactId', $quotation->getContactId(), PDO::PARAM_INT);
    
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Reactivate delete quotation
     * @param quotation $quotation
     */
    public function reactivate(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET isActive = \'1\' WHERE $idQuotation = :$idQuotation');
            $q->bindValue(':$idQuotation', $quotation->getIdQuotation(), PDO::PARAM_INT);
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    public function toProforma(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET status = \'P\', year = :year,month = :month,day = :day,comment = :comment WHERE $idQuotation= :$idQuotation');
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':comment', $quotation->getComment(), PDO::PARAM_STR);
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }

    }

    public function toInvoice(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET status = \'F\', year = :year,month = :month,day = :day,comment = :comment WHERE $idQuotation= :$idQuotation');
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':comment', $quotation->getComment(), PDO::PARAM_STR);
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }

    }

    public function toAsset(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET status = \'A\', year = :year,month = :month,day = :day,comment = :comment WHERE $idQuotation= :$idQuotation');
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':comment', $quotation->getComment(), PDO::PARAM_STR);
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }

    }

}