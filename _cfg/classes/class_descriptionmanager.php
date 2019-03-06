<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 06/03/2019
 * Time: 10:39
 */

class DescriptionManager
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

    public function add(array $description, $quotationNumber)
    {
        try{
            for ($i=0;$i<count($description);$i++)
            {
                $q = $this->_db->prepare('INSERT INTO `description` (quotationNumber, description,quantity,discount,price,tax) VALUES (:quotationNumber, :description,:quantity,:discount,:price,tax)');
                $q->bindValue(':quotationNumber', $quotationNumber, PDO::PARAM_STR);
                $q->bindValue(':description', $description["description"][$i], PDO::PARAM_STR);
                $q->bindValue(':quantity', $description["quantity"][$i], PDO::PARAM_INT);
                $q->bindValue(':quantity', $description["discount"][$i], PDO::PARAM_INT);
                $q->bindValue(':quantity', $description["price"][$i], PDO::PARAM_INT);
                $q->bindValue(':quantity', $description["tax"][$i], PDO::PARAM_STR);
                $q->execute();
            }


            return "ok";
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
        $description = array();
        try{
            $quotationNumber = (string) $quotationNumber;
            $q = $this->_db->query("SELECT * FROM description WHERE quotationNumber = '$quotationNumber'");
            while($donnees = $q->fetch(PDO::FETCH_ASSOC))
            {
                $description[] =new Description($donnees);
            }

            return $description;
        }
        catch(Exception $e){
            return null;
        }
    }

}