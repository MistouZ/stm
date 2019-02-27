<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class UsersManager
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * UsersManager constructor.
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
     * @param Users $user
     * Insertion user in the DB
     */
    public function add(Users $user, array $companies)
    {
        $user->setName(strtoupper($user->getName()));
        $q = $this->_db->prepare('INSERT INTO users (username, name, firstname,emailAddress,password,phoneNumber,credential,defaultCompany,isSeller, isActive) VALUES (:username, :name, :firstname, :emailAddress, :password, :phoneNumber, :credential, :defaultCompany, :isSeller, :isActive)');
        $q->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $q->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $q->bindValue(':firstname', $user->getFirstName(), PDO::PARAM_STR);
        $q->bindValue(':emailAddress', $user->getEmailAddress(), PDO::PARAM_STR);
        $q->bindValue(':password', $user->getPassword(), PDO::PARAM_STR );
        $q->bindValue(':phoneNumber', $user->getPhoneNumber(), PDO::PARAM_STR );
        $q->bindValue(':credential', $user->getCredential(), PDO::PARAM_STR );
        $q->bindValue(':defaultCompany', $user->getDefaultCompany(), PDO::PARAM_INT );
        $q->bindValue(':isSeller', $user->getIsSeller(), PDO::PARAM_INT);
        $q->bindValue(':isActive', $user->getIsActive(), PDO::PARAM_INT);

        $q->execute();



        for ($i=0;$i<count($companies);$i++)
        {
            $q2 = $this->_db->prepare('INSERT INTO link_company_users (users_username, company_idcompany) VALUES (:username, :id_company)');
            $q2->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
            $q2->bindValue(':id_company', $companies[$i], PDO::PARAM_INT);
            $q2->execute();
        }
    }

    /**
     * @param Users $user
     * Disable user instead of delete it
     */
    public function delete(Users $user)
    {
        $q = $this->_db->prepare('UPDATE users SET isActive = \'0\' WHERE username = :username');
        $q->bindValue(':username', $user->getUsername(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * Find a user by his username
     * @param $username
     * @return Users
     */
    public function get($username)
    {
        $username = (string) $username;
        $q=$this->_db->query("SELECT u.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS companyName FROM users u INNER JOIN  link_company_users lk ON u.username =  lk.users_username INNER JOIN company c ON lk.company_idcompany = c.idcompany WHERE u.isActive='1' AND lk.users_username='$username' AND c.isActive='1' GROUP BY u.username");
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Users($donnees);
    }

    /**
     * Connect user to the portal
     * @param $username
     * @param $password
     * @return Users
     */
    public function connectUser($username, $password)
    {
        $username = (string) $username;
        $password = (string) $password;
        $q = $this->_db->query('SELECT * FROM users WHERE username="'.$username.'"');
        $data = $q->fetch(PDO::FETCH_ASSOC);

        $isPasswordCorrect = password_verify($password, $data["password"]);

        if (!$data)
        {
            $data = array();
            $user = new Users($data);
            if(isset($_COOKIE['nom'])){ setcookie('nom', false, time() - 365*24*3600, '/');}
            if(isset($_COOKIE['prenom'])){ setcookie('prenom', false, time() - 365*24*3600, '/'); }
            if(isset($_COOKIE['username'])){ setcookie('username', false, time() - 365*24*3600, '/'); }
            if(isset($_COOKIE['company'])){ setcookie('company', false, time() - 365*24*3600, '/'); }
            setcookie('connected', "false", time() + 365*24*3600, '/');
        }
        else
        {
            if ($isPasswordCorrect)
            {
                $user = new Users($data);
                setcookie('nom', $user->getName(), time() + 365*24*3600, '/');
                setcookie('prenom', $user->getFirstName(), time() + 365*24*3600, '/');
                setcookie('username', $user->getUsername(), time() + 365*24*3600, '/');
                if(isset($_COOKIE['connected'])){ unset($_COOKIE['connected']); }
                setcookie('connected', "true", time() + 365*24*3600, '/');
            }
            else
            {
                $data = array();
                $user = new Users($data);
                if(isset($_COOKIE['nom'])){ setcookie('nom', false, time() - 365*24*3600, '/'); }
                if(isset($_COOKIE['prenom'])){ setcookie('prenom', false, time() - 365*24*3600, '/'); }
                if(isset($_COOKIE['username'])){ setcookie('username', false, time() - 365*24*3600, '/'); }
                if(isset($_COOKIE['company'])){ setcookie('company', false, time() - 365*24*3600, '/'); }
                setcookie('connected', "false", time() + 365*24*3600, '/'); 
            }
        }

        return $user;
    }

    /**
     * Get all the users in the BDD
     * @return array
     */
    public function getList()
    {
        $users = [];

        $q=$this->_db->query("SELECT u.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS companyName FROM users u INNER JOIN  link_company_users lk ON u.username =  lk.users_username INNER JOIN company c ON lk.company_idcompany = c.idcompany WHERE u.isActive='1' AND c.isActive='1' GROUP BY u.username");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $users[] = new Users($donnees);
        }

        return $users;
    }

    /**
     * Get all the users in the BDD
     * @return array
     */
    public function getListByCompany($idcompany)
    {
        $idcompany = (integer) $idcompany;
        $users = [];
        $q=$this->_db->query("SELECT u.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS companyName FROM users u INNER JOIN  link_company_users lk ON u.username =  lk.users_username INNER JOIN company c ON lk.company_idcompany = c.idcompany WHERE c.idcompany='$idcompany' AND u.isActive='1' AND c.isActive='1' GROUP BY u.username");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $users[] = new Users($donnees);
        }

        return $users;
    }

    /**
     * Update users information
     * @param Users $user
     */
    public function update(Users $user, array $companies, $oldusername)
    {
        $user->setName(strtoupper($user->getName()));
        $q = $this->_db->prepare("UPDATE users SET name = :name, firstname = :firstname, emailAddress = :email_address, password = :password, phoneNumber = :phone_number, credential = :credential, defaultCompany = :defaultCompany, isSeller = :isSeller, isActive = :isActive  WHERE username = '$oldusername'");
        $q->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $q->bindValue(':name', $user->getName(), PDO::PARAM_STR);
        $q->bindValue(':firstname', $user->getFirstName(), PDO::PARAM_STR);
        $q->bindValue(':email_address', $user->getEmailAddress(), PDO::PARAM_STR);
        $q->bindValue(':password', $user->getEmailAddress(), PDO::PARAM_STR );
        $q->bindValue(':phone_number', $user->getPhoneNumber(), PDO::PARAM_STR );
        $q->bindValue(':credential', $user->getCredential(), PDO::PARAM_STR );
        $q->bindValue(':defaultCompany', $user->getDefaultCompany(), PDO::PARAM_INT);
        $q->bindValue(':isSeller', $user->getIsSeller(), PDO::PARAM_INT);
        $q->bindValue(':isActive', $user->getIsActive(), PDO::PARAM_INT);

        $q->execute();
        
        $delete=$this->_db->query('DELETE FROM `link_company_users` WHERE users_username ='.$oldusername);
        $delete->execute();
        
        for ($i=0;$i<count($companies);$i++)
        {
            $q2 = $this->_db->prepare('INSERT INTO `link_company_users` (users_username, company_idcompany) VALUES (:username, :idcompany)');
            $q2->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
            $q2->bindValue(':idcompany', $companies[$i], PDO::PARAM_INT);
            $q2->execute();
        }
    }

}