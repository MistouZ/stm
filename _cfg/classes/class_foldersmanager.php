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
        
        try{
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
        try{
            $folders = [];

            $q=$this->_db->query("SELECT * FROM folder WHERE companyId='$companyid' ORDER BY folderNumber DESC");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $folders[] = new Folder($donnees);
            }

            return $folders;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the active folder in the BDD for the selected company
     * @return array
     */
    public function getListActive($companyid)
    {
        try{
            $folders = [];

            $q=$this->_db->query("SELECT * FROM folder WHERE companyId=$companyid AND isActive ='1' ORDER BY folderNumber DESC ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $folders[] = new Folder($donnees);
            }

            return $folders;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Get all the active folder in the BDD for the user
     * @return array
     */
    public function getListByUser($username, $companyid)
    {
        try{
            $folders = [];

            $q=$this->_db->query("SELECT * FROM folder WHERE seller='".$username."' AND companyId=$companyid AND isActive ='1' ORDER BY folderNumber DESC ");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $folders[] = new Folder($donnees);
            }

            return $folders;
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * Get all the active folder in the BDD between
     * @return array
     */
    public function getListByDate($companyid, $datefrom, $dateto)
    {
        try{
            $dateTab = explode("/",$datefrom);
            $yearfrom = $dateTab[2];
            $monthfrom = $dateTab[1];
            $dayfrom = $dateTab[0];

            $dateTab2 = explode("/",$dateto);
            $yearto = $dateTab2[2];
            $monthto = $dateTab2[1];
            $dayto = $dateTab2[0];

            if($dayfrom == $dayto)
            {
                $dayto = NULL;
            }

            $folders = [];

            $q=$this->_db->query("SELECT * FROM folder WHERE companyId=$companyid AND `year` >= $yearfrom AND `month` >= $monthfrom AND `day` >= $dayfrom AND `year` <= $yearto AND `month` <= $monthto AND `day` <= $dayto AND isActive ='1' ORDER BY folderNumber ASC");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $folders[] = new Folder($donnees);
            }

            return $folders;
        }
        catch(Exception $e){
            return null;
        }
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