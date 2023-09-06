<?php
/**
 * Created by PhpStorm.
 * Folder: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class CounterManager
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
     * Create counter for @param $companyId
     */

     public function initiation($companyId)
     {
        try{
            $companyId = (integer) $companyId;
            $q = $this->_db->query('INSERT INTO `company_counting` (`company`, `folder`, `quotation`, `invoice`) VALUES ('.$companyId.', 0, 0, 0)');
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
     }

    /**
     * get all counter value for @param $companyId
     * @return Counter
     */

     public function getCount($companyId)
    {
        try{
            $companyId = (integer) $companyId;
            $q = $this->_db->query("SELECT * FROM company_counting WHERE company =".$companyId);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);
            return new Counter($donnees);
        }  
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Update counter
     * @param Counter $counter
     * @return string|null
     */
    
    public function updateCounter(Counter $counter)
    {
        try{
            $q = $this->_db->prepare('UPDATE company_counting SET folder = :folder, quotation = :quotation, invoice = :invoice, asset = :asset WHERE company = :idcompany');
            $q->bindValue(':folder', $counter->getFolder(), PDO::PARAM_INT);
            $q->bindValue(':quotation', $counter->getQuotation(), PDO::PARAM_INT);
            $q->bindValue(':invoice', $counter->getInvoice(), PDO::PARAM_INT);
            $q->bindValue(':asset', $counter->getAsset(), PDO::PARAM_INT);
            $q->bindValue(':idcompany', $counter->getCompany(), PDO::PARAM_INT);
   
            $q->execute();

            
            return "Ok";
        }
        catch(Exception $e){
            return null;
        }

    }

    /**
     * Get all the counter in the BDD
     * @return array
     */
    public function getList()
    {
        $counters = [];


       $q=$this->_db->query("SELECT * FROM company_counting ORDER BY company ASC");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $counters[] = new Counter($donnees);
        }

        return $counters;
    }
    
}