<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class ContactManager
{
    /**
     * PDO Database instance PDO
     * @var
     */
    private $_db;

    /**
     * ContactManager constructor.
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
     * @param Contact $contact
     * Insertion contact in the DB
     */
    public function add(Contact $contact, Customers $customers)
    {
        $q = $this->_db->prepare('INSERT INTO contact (name, firstname,emailAddress,phoneNumber,isActive) VALUES (:name, :first_name, :email_address, :password, :phone_number, :isActive)');
        $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
        $q->bindValue(':first_name', $contact->getFirstName(), PDO::PARAM_STR);
        $q->bindValue(':email_address', $contact->getEmailAddress(), PDO::PARAM_STR);
        $q->bindValue(':phone_number', $contact->getPhoneNumber(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);

        $q->execute();

        for ($i = 0; $i < count($customers); $i++) {
            $q2 = $this->_db->prepare('INSERT INTO link_customers_contact (customers_idcustomer, contact_idcontact) VALUES (:idcustomer, :idcontact)');
            $q2->bindValue(':idcustomer', $contact->getIdContact(), PDO::PARAM_STR);
            $q2->bindValue(':idcontact', $customers[$i], PDO::PARAM_INT);
            $q2->execute();
        }
    }


    /*
        for ($i=0;$i<count($companies);$i++)
        {
            $q2 = $this->_db->prepare('INSERT INTO link_company_contact (contact_idContact, company_idcompany) VALUES (:idContact, :id_company)');
            $q2->bindValue(':idContact', $contact->getUsername(), PDO::PARAM_STR);
            $q2->bindValue(':id_company', $companies[$i], PDO::PARAM_INT);
            $q2->execute();
        }
    */
    }

    /**
     * @param Contact $contact
     * Disable contact instead of delete it
     */
    public function delete(Contact $contact)
    {
        $q = $this->_db->prepare('UPDATE contact SET isActive = \'0\' WHERE idContact = :idContact');
        $q->bindValue(':idContact', $contact->getIdContact(), PDO::PARAM_INT);

        $q->execute();
    }

    /**
     * Find a contact by his idContact
     * @param $idContact
     * @return Contact
     */
    public function get($idContact)
    {
        $idContact = (integer) $idContact;
        $q = $this->_db->query('SELECT * FROM contact WHERE idContact ='.$idContact);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Contact($donnees);
    }

    /**
     * Get all the contact in the BDD
     * @return array
     */
    public function getList()
    {
        $contact = [];

        $q=$this->_db->query("SELECT u.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS companyName FROM contact u INNER JOIN  link_contact_company lk ON u.idContact =  lk.contact_idContact INNER JOIN company c ON lk.company_idcompany = c.idcompany WHERE u.isActive='1' AND c.isActive='1' GROUP BY u.idContact");
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $contact[] = new Contact($donnees);
        }

        return $contact;
    }

    /**
     * Update contact information
     * @param Contact $contact
     */
    public function update(Contact $contact)
    {
        $q = $this->_db->prepare('UPDATE contact SET name = :name, firstname = :first_name, emailAddress = :email_address, phoneNumber = :phone_number, isActive = :isActive  WHERE idContact = :idContact');
        $q->bindValue(':idContact', $contact->getUsername(), PDO::PARAM_STR);
        $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
        $q->bindValue(':first_name', $contact->getFirstName(), PDO::PARAM_STR);
        $q->bindValue(':email_address', $contact->getEmailAddress(), PDO::PARAM_STR);
        $q->bindValue(':phone_number', $contact->getPhoneNumber(), PDO::PARAM_STR );
        $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);

        $q->execute();
    }

}