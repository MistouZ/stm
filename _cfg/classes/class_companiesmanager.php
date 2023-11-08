<?php
/**
 * Created by PhpStorm.
 * company: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class CompaniesManager extends Features
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * companiesManager constructor.
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
        return $this->_db->query('SELECT COUNT(*) FROM company')->fetchColumn();
    }

    /**
     * @param companies $company
     * Insertion company in the DB
     */
    public function add(Company $company)
    {
        try{
            $q = $this->_db->prepare('INSERT INTO company (name, nameData, address,isActive) VALUES (:name, :nameData, :address, :isActive)');
            $q->bindValue(':name', $company->getName(), PDO::PARAM_STR);
            $companyName = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $company->getName()));
            $q->bindValue(':nameData', $companyName, PDO::PARAM_STR);
            $q->bindValue(':address', $company->getAddress(), PDO::PARAM_STR);
            $q->bindValue(':isActive', $company->getIsActive(), PDO::PARAM_INT);
    
            $q->execute();
            $companyId = $this->_db->lastInsertId();
            
            return $companyId;
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * @param companies $company
     * Disable company instead of delete it
     */
    public function delete(Company $company)
    {
        try{
            $q = $this->_db->prepare('UPDATE company SET isActive = \'0\' WHERE idcompany = '.$company->getIdcompany());
    
            $q->execute();
            
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Find a company by his ID
     * @param $companyId
     * @return company
     */
    public function getById($companyId)
    {
        $companyId = (integer) $companyId;
        $q = $this->_db->query('SELECT * FROM `company` WHERE `idcompany` ='.$companyId);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Company($donnees);
    }

    /**
     * Find a company by his name
     * @param $companyDataName
     * @return company
     */
    public function getByNameData($companyNameData)
    {
        $companyNameData = (string) $companyNameData;
        $q = $this->_db->query('SELECT * FROM `company` WHERE `nameData` ="'.$companyNameData.'"');
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Company($donnees);
    }


    /**
     * Get all the  activate companies in the BDD
     * @return array
     */
    public function getList()
    {
        $companies = [];
        $q=$this->_db->query('SELECT * FROM company WHERE isActive = \'1\' ORDER BY name');
        //$q=$this->_db->query($this->getListIsActive($company));
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $companies[] = new Company($donnees);
        }

        return $companies;
    }

    /**
     * Get all the companies in the BDD
     * @return array
     */
    public function getListAllCompanies()
    {
        $companies = [];
        $q=$this->_db->query('SELECT * FROM company ORDER BY name');
        //$q=$this->_db->query($this->getListIsActive($company));
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $companies[] = new Company($donnees);
        }

        return $companies;
    }

    /**
     * Update companies information
     * @param company $company
     */

    public function update(Company $company)
    {
        try{
            $q = $this->_db->prepare('UPDATE company SET name = :name, nameData = :nameData, address = :address, isActive = :isActive  WHERE idcompany = :idcompany');
            $q->bindValue(':idcompany', $company->getIdcompany(), PDO::PARAM_INT);
            $q->bindValue(':name', $company->getName(), PDO::PARAM_STR);
            $companyName = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','', $company->getName()));
            $q->bindValue(':nameData', $companyName, PDO::PARAM_STR);
            $q->bindValue(':address', $company->getAddress(), PDO::PARAM_STR);
            $q->bindValue(':isActive', $company->getIsActive(), PDO::PARAM_INT);
    
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }


    /**
     * @param $username
     * @return array
     */
    public function getCompanies($username)
    {
        $companies = [];
        $q=$this->_db->query('SELECT c.* FROM company c INNER JOIN  link_company_users lk ON c.idcompany =  lk.company_idcompany INNER JOIN users u ON lk.users_username = u.username WHERE u.username ="'.$username.'" AND u.isActive=\'1\' AND c.isActive=\'1\' ORDER BY c.name ');
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $companies[] = new Company($donnees);
        }

        return $companies;
    }

    /**
     * Reactivate the Company
     * @param Company $company
     */
    public function reactivate(Company $company)
    {
        try{
            $q = $this->_db->prepare('UPDATE company SET isActive = \'1\' WHERE idcompany = :idcompany');
            $q->bindValue(':idcompany', $company->getIdcompany(), PDO::PARAM_INT);
            $q->execute();
            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }


}