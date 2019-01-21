<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 27/11/2018
 * Time: 14:40
 */

class DB
{
    private $host = 'mysql:host=localhost;port=3306; dbname=stm_compta';
    private $username = 'root';
    private $password = '';
    private $bdd;

    /**
     * DB constructor.
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $bdd
     */
    public function __construct()
    {
    }


    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getBdd()
    {
        return $this->bdd;
    }

    /**
     * @param mixed $bdd
     */
    public function setBdd($bdd)
    {
        $this->bdd = $bdd;
    }

    public function connexion()
    {
        try {
            $this->setBdd(new PDO($this->getHost(), $this->getUsername(), $this->getPassword(),array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")));
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function __call($name, array $arguments)
    {

        if(method_exists($this->bdd, $name)){
            try{
                return call_user_func_array(array(&$this->bdd, $name), $arguments);
            }
            catch(Exception $e){
                throw new Exception('Database Error: "'.$name.'" does not exists');
            }
        }
    }
}