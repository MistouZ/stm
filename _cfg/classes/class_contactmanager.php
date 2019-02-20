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
    public function addToCustomers(Contact $contact, $customers)
    {
        $q = $this->_db->prepare('INSERT INTO contact (name, firstname,emailAddress,phoneNumber,isActive) VALUES (:name, :first_name, :email_address, :password, :phone_number, :isActive)');
        $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
        $q->bindValue(':first_name', $contact->getFirstName(), PDO::PARAM_STR);
        $q->bindValue(':email_address', $contact->getEmailAddress(), PDO::PARAM_STR);
        $q->bindValue(':phone_number', $contact->getPhoneNumber(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);

        $q->execute();

        $contact = $this->getByName($contact->getName(), $contact->getFirstName());

        $q2 = $this->_db->prepare('INSERT INTO link_customers_contact (customers_idcustomer, contact_idcontact) VALUES (:idcustomer, :idcontact)');
        $q2->bindValue(':idcontact', $contact->getIdContact(), PDO::PARAM_INT);
        $q2->bindValue(':idcustomer', $customers, PDO::PARAM_INT);
        $q2->execute();

    }


    /**
     * @param Contact $contact
     * Insertion contact in the DB
     */
    public function addToSuppliers(Contact $contact,Suppliers $suppliers)
    {
        $q = $this->_db->prepare('INSERT INTO contact (name, firstname,emailAddress,phoneNumber,isActive) VALUES (:name, :first_name, :email_address, :password, :phone_number, :isActive)');
        $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
        $q->bindValue(':first_name', $contact->getFirstName(), PDO::PARAM_STR);
        $q->bindValue(':email_address', $contact->getEmailAddress(), PDO::PARAM_STR);
        $q->bindValue(':phone_number', $contact->getPhoneNumber(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);

        $q->execute();

        $q2 = $this->_db->prepare('INSERT INTO link_suppliers_contact (suppliers_idsupplier, contact_idcontact) VALUES (:idsupplier, :idcontact)');
        $q2->bindValue(':idcontact', $contact->getIdContact(), PDO::PARAM_INT);
        $q2->bindValue(':idcustomer', $suppliers->getIdSupplier(), PDO::PARAM_INT);
        $q2->execute();

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
    public function getById($idContact)
    {
        $idContact = (integer) $idContact;
        $q = $this->_db->query('SELECT * FROM contact WHERE idContact ='.$idContact);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Contact($donnees);
    }
    /**
     * Find a contact by his idContact
     * @param $idContact
     * @return Contact
     */
    public function getByName($contactName, $contactFirstName)
    {
        $contactName = (string) $contactName;
        $contactFirstName = (string) $contactFirstName;
        $q = $this->_db->query('SELECT * FROM contact WHERE name ="'.$contactName.'" AND firstname="'.$contactFirstName.'"');
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