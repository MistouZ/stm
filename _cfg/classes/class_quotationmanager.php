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
            
            return "ok";
        }
        catch(Exception $e){
            return null;
        }

    }

    /**
     * @param Folder $folder
     * Disable folder instead of delete it
     */
    public function delete($idFolder)
    {
        try{
            $q = $this->_db->prepare('UPDATE folder SET isActive = \'0\' WHERE idFolder = :idFolder');
            $q->bindValue(':idFolder', $idFolder, PDO::PARAM_INT);
            $q->execute();

            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find a folder by his foldername
     * @param $foldername
     * @return folder
     */
    public function get($folderId)
    {
        try{
            $folderId = (integer) $folderId;
            $q = $this->_db->query('SELECT * FROM folder WHERE idFolder ='.$folderId);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
    
            return new Folder($donnees);
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Get all the folder in the BDD for the selected company
     * @return array
     */
    public function getList($companyid)
    {
        $folders = [];

        $q=$this->_db->query("SELECT * FROM folder WHERE companyId='$companyid'");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $folders[] = new Folder($donnees);
        }

        return $folders;
    }

    /**
     * Get all the active folder in the BDD for the selected company
     * @return array
     */
    public function getListActive($companyid)
    {
        $folders = [];

        $q=$this->_db->query("SELECT * FROM folder WHERE companyId=$companyid AND isActive ='1' ");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $folders[] = new Folder($donnees);
        }

        return $folders;
    }

    /**
     * Update folders information
     * @param folder $folder
     */
    public function update(Folder $folder)
    {
        try{
            $q = $this->_db->prepare('UPDATE folder SET label = :label, year = :year,month = :month,day = :day,isActive = :isActive,description = :description,seller = :seller, companyId = :companyId, customerId = :customerId, contactId = :contactId WHERE idFolder= :idFolder');
            $q->bindValue(':idFolder', $folder->getIdFolder(), PDO::PARAM_INT);
            $q->bindValue(':label', $folder->getLabel(), PDO::PARAM_STR);
            $q->bindValue(':year', $folder->getYear(), PDO::PARAM_INT);
            $q->bindValue(':month', $folder->getMonth(), PDO::PARAM_INT);
            $q->bindValue(':day', $folder->getDay(), PDO::PARAM_INT );
            $q->bindValue(':isActive', $folder->getIsActive(), PDO::PARAM_INT);
            $q->bindValue(':description', $folder->getDescription(), PDO::PARAM_STR);
            $q->bindValue(':seller', $folder->getSeller(), PDO::PARAM_STR);
            $q->bindValue(':companyId', $folder->getCompanyId(), PDO::PARAM_INT);
            $q->bindValue(':customerId', $folder->getCustomerId(), PDO::PARAM_INT);
            $q->bindValue(':contactId', $folder->getContactId(), PDO::PARAM_INT);
    
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Reactivate delete Folder
     * @param Folder $folder
     */
    public function reactivate(Folder $folder)
    {
        try{
            $q = $this->_db->prepare('UPDATE folder SET isActive = \'1\' WHERE idFolder = :idFolder');
            $q->bindValue(':idFolder', $folder->getIdFolder(),PDO::PARAM_INT);
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

}