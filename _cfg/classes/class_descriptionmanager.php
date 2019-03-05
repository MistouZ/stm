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

    public function add(array $description)
    {
        try{
            for ($i=0;$i<count($description);$i++)
            {
                $q = $this->_db->prepare('INSERT INTO `description` (quotationNumber, description,quantity,discount,price,tax) VALUES (:quotationNumber, :description,:quantity,:discount,:price,tax)');
                $q->bindValue(':quotationNumber', $description["quotationNumber"][$i], PDO::PARAM_STR);
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

}