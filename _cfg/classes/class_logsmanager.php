<?php
/**
 * Created by PhpStorm.
 * Folder: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class LogsManager
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
     * @param username $username
     * @param type $type
     * @param action $action
     * @param id $id
     * @param date $date
     * @return string|null
     */
    
    public function add(Logs $logs)
    {
        print_r($logs);
        try{
            $q = $this->_db->prepare('INSERT INTO logs (users_username, company_idcompany, type, action, id, date) VALUES (:username, :company, :type,:action, :id, :date)');
            $q->bindValue(':username', $logs->getUsername(), PDO::PARAM_STR);
            $q->bindValue(':company', $logs->getCompany(), PDO::PARAM_INT);
            $q->bindValue(':type', $logs->getType(), PDO::PARAM_STR);
            $q->bindValue(':action', $logs->getAction(), PDO::PARAM_STR);
            $q->bindValue(':id', $logs->getId(), PDO::PARAM_INT);
            $q->bindValue(':date', $logs->getDate(), PDO::PARAM_STR);
   
            $q->execute();
            
            return "Ok";
        }
        catch(Exception $e){
            return null;
        }

    }    

}