<?php
/**
 * Created by PhpStorm.
 * Folder: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class ShatteredQuotationManager
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
     * @param ShatteredQuotation $quotation
     * @return string|null
     */
    public function add(ShatteredQuotation $quotation)
    {
        try{
            $q = $this->_db->prepare('INSERT INTO shattered_quotation (quotationNumber, percent) VALUES (:quotationNumber, :percent)');
            $q->bindValue(':quotationNumber', $quotation->getQuotationNumber(), PDO::PARAM_STR);
            $q->bindValue(':percent', $quotation->getPercent(), PDO::PARAM_INT);

    
            $q->execute();
            
            return "Ok";
        }
        catch(Exception $e){
            return null;
        }

    }

    /**
     * @param $idShatteredQuotation
     * @return string|null
     */
    public function delete($idShatteredQuotation)
    {
        try{
            $idShatteredQuotation = (integer) $idShatteredQuotation;
            $q = $this->_db->query("DELETE FROM shattered_quotation WHERE $idShatteredQuotation='$idShatteredQuotation'");
            $q->execute();

           return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * @param $idShatteredQuotation
     * @return ShatteredQuotation|null
     */
    public function get($idShatteredQuotation)
    {
        try{
            $idShatteredQuotation = (integer) $idShatteredQuotation;
            $q = $this->_db->query('SELECT * FROM shattered_quotation WHERE $idShatteredQuotation ='.$idShatteredQuotation);
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new ShatteredQuotation($donnees);
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * @param $quotationNumber
     * @return ShatteredQuotation|null
     */
    public function getByQuotationNumber($quotationNumber)
    {
        try{
            $quotationNumber = (string) $quotationNumber;
            $q = $this->_db->query("SELECT * FROM `shattered_quotation` WHERE quotationNumber = '$quotationNumber'");
            $donnees = $q->fetch(PDO::FETCH_ASSOC);

            return new ShatteredQuotation($donnees);
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * @param ShatteredQuotation $quotation
     * @return string|null
     */
    public function update(ShatteredQuotation $quotation)
    {
        try{
            $q = $this->_db->prepare('UPDATE shattered_quotation SET percent = :percent,  WHERE idShatteredQuotation= :idShatteredQuotation');
            $q->bindValue(':idShatteredQuotation', $quotation->getIdShatteredQuotation(), PDO::PARAM_INT);
            $q->bindValue(':percent', $quotation->getPercent(), PDO::PARAM_INT);
    
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }


}