<?php
/**
 * Created by PhpStorm.
 * Folder: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class QuotationManager
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
    public function count()
    {
       return $this->_db->query('SELECT max(idQuotation) FROM quotation ORDER BY idQuotation')->fetchColumn();
    }

    /**
     * @param Quotation $quotation
     * Insertion Quotation in the DB
     */
    public function add(Quotation $quotation)
    {
        $lastId = $this->count();
        $quotationNumber = $quotation->getYear().$quotation->getMonth().($lastId + 1);
        $quotation->setQuotationNumber($quotationNumber);
        //print_r($quotation);
        try{
            $q = $this->_db->prepare('INSERT INTO quotation (quotationNumber, status, label, year,month,day, type, comment, companyId,folderId,customerId, contactId) VALUES (:quotationNumber, :status, :label, :year, :month, :day, :type, :comment, :companyId, :folderId, :customerId, :contactId)');
            $q->bindValue(':quotationNumber', $quotation->getQuotationNumber(), PDO::PARAM_INT);
            $q->bindValue(':label', $quotation->getLabel(), PDO::PARAM_STR);
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':type', $quotation->getType(), PDO::PARAM_STR);
            $q->bindValue(':comment', $quotation->getComment(), PDO::PARAM_STR);
            $q->bindValue(':companyId', $quotation->getCompanyId(), PDO::PARAM_INT);
            $q->bindValue(':folderId', $quotation->getFolderId(), PDO::PARAM_INT);
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
            $idQuotation = (integer) $idQuotation;
            $q = $this->_db->query("DELETE FROM quotation WHERE idQuotation='$idQuotation'");
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
     * Find a Quotation by his iD
     * @param $quotationNumber
     * @return quotation
     */
    public function getByQuotationNumber($quotationNumber)
    {
        try{
            $quotationNumber = (integer) $quotationNumber;
            $q = $this->_db->query("SELECT * FROM `quotation` WHERE quotationNumber = '$quotationNumber'");
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new Quotation($donnees);
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find a Quotation by his iD
     * @param $folderId
     * @return quotation
     */
    public function getByFolderId($folderId)
    {
        try{
            $folderId = (string) $folderId;
            $q = $this->_db->query("SELECT * FROM `quotation` WHERE folderId = '$folderId'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Get all the quotation in the BDD for the selected company
     * @return array
     */
    public function getListQuotation($companyid)
    {
        try{
            $quotations = [];
            $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid' AND type ='D' ORDER BY quotationNumber DESC");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the quotation in the BDD for the selected user
     * @return array
     */
    public function getListQuotationByUser($folders, $folder)
    {
        try{
            $quotations = [];
            foreach ($folders as $folder)
            {
                $folderId = $folder->getIdFolder();
                $query = "SELECT * FROM quotation WHERE folderId='$folderId' AND type ='D' ORDER BY quotationNumber DESC";
                $q=$this->_db->query($query);
                while($donnees = $q->fetch(PDO::FETCH_ASSOC))
                {
                    $quotations[] = new Quotation($donnees);
                }
            }
            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the quotation in the BDD for the selected company
     * @return array
     */
    public function getListShatteredQuotation($companyid)
    {
        try{
            $quotations = [];

            $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid' AND type ='S' ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the proforma in the BDD for the selected company
     * @return array
     */
    public function getListProforma($companyid)
    {
        try{
            $quotations = [];

            $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid' AND type ='P' ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the invoice in the BDD for the selected company
     * @return array
     */
    public function getListInvoice($companyid)
    {
        try{
            $quotations = [];

            $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid' AND type ='F' ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }
    
    /**
     * Get all the invoice in the BDD for the selected company
     * @return array
     */
    public function getListAsset($companyid)
    {
        try{
            $quotations = [];

            $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid' AND type ='A' ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the invoice in the BDD for the selected company
     * @return array
     */
    public function getListValidatedQuotation($companyid)
    {
        try{
            $quotations = [];

            $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid' AND type ='P'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the invoice in the BDD for the selected company
     * @return array
     */
    public function getListArchivedQuotation($companyid)
    {
        try{
            $quotations = [];

            $q=$this->_db->query("SELECT * FROM quotation WHERE companyId='$companyid' AND type ='AR'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $quotations[] = new Quotation($donnees);
            }

            return $quotations;
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Update quotation information
     * @param quotation $quotation
     */
    public function update(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET status = :status, label = :label, year = :year, month = :month, day = :day, type = :type, comment = :comment, companyId = :companyId, folderId = :folderId, customerId = :customerId, contactId = :contactId WHERE idQuotation= :idQuotation');
            $q->bindValue(':idQuotation', $quotation->getIdQuotation(), PDO::PARAM_INT);
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':label', $quotation->getLabel(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':type', $quotation->getType(), PDO::PARAM_STR);
            $q->bindValue(':comment', $quotation->getComment(), PDO::PARAM_STR);
            $q->bindValue(':companyId', $quotation->getCompanyId(), PDO::PARAM_INT);
            $q->bindValue(':folderId', $quotation->getFolderId(), PDO::PARAM_INT);
            $q->bindValue(':customerId', $quotation->getCustomerId(), PDO::PARAM_INT);
            $q->bindValue(':contactId', $quotation->getContactId(), PDO::PARAM_INT);
    
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    public function changeType(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET type = :type, status = :status, year = :year, month = :month, day = :day WHERE idQuotation= :idQuotation');
            $q->bindValue(':idQuotation', $quotation->getIdQuotation(), PDO::PARAM_INT);
            $q->bindValue(':status', $quotation->getStatus(), PDO::PARAM_STR);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->bindValue(':type', $quotation->getType(), PDO::PARAM_STR);
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
            $q = $this->_db->prepare('UPDATE quotation SET type = \'F\', year = :year,month = :month,day = :day,comment = :comment WHERE $idQuotation= :$idQuotation');
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
            $q = $this->_db->prepare('UPDATE quotation SET type = \'A\', year = :year,month = :month,day = :day,comment = :comment WHERE $idQuotation= :$idQuotation');
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
    
    public function changeDate(Quotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE quotation SET year = :year, month = :month, day = :day WHERE idQuotation= :idQuotation');
            $q->bindValue(':idQuotation', $quotation->getIdQuotation(), PDO::PARAM_INT);
            $q->bindValue(':year', $quotation->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $quotation->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $quotation->getDay(), PDO::PARAM_INT );
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

}