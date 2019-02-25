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
       return $this->_db->query('SELECT COUNT(*) FROM folder WHERE companyId='.$companyId.' GROUP BY companyId')->fetchColumn();
    }

    /**
     * @param Folder $folder
     * Insertion folder in the DB
     */
    public function add(Folder $folder)
    {
        $folderNumber = $this->count($folder->getCompanyId());
        $folderNumber = $folderNumber + 1;

        $q = $this->_db->prepare('INSERT INTO folder (folderNumber, label, year,month,day,isActive,description,seller, companyId, customerId, contactId) VALUES (:folderNumber, :label, :year, :month, :day, :isActive, :description, :seller, :companyId,:customerId,:contactId)');
        $q->bindValue(':folderNumber', $folderNumber, PDO::PARAM_STR);
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

    }

    /**
     * @param Folder $folder
     * Disable folder instead of delete it
     */
    public function delete(Folder $folder)
    {
        $q = $this->_db->prepare('DELETE FROM folder WHERE folderId = :folderId');
        $q->bindValue(':folderId', $folder->getIdFolder(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * Find a folder by his foldername
     * @param $foldername
     * @return folder
     */
    public function get($folderId)
    {
        $folderId = (integer) $folderId;
        $q = $this->_db->query('SELECT * FROM folder WHERE folderId ='.$folderId);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Folder($donnees);
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

        $q=$this->_db->query("SELECT * FROM folder WHERE companyId='$companyid' AND isActive ='\1\' ");
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
        $q = $this->_db->prepare('UPDATE folder SET folderNumber = :folderNumber, label = :label, year = :year,month = :month,day = :day,isActive = :isActive,description = :description,seller = :seller, companyId = :companyId, customerId = :customerId, contactId = :contactId WHERE folderId= :folderId');
        $q->bindValue(':folderId', $folder->getFolderId(), PDO::PARAM_INT);
        $q->bindValue(':folderNumber', $folder->getFolderNumber(), PDO::PARAM_STR);
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
    }

}