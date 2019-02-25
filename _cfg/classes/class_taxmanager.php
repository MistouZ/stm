<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 27/11/2018
 * Time: 10:42
 */

class TaxManager
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
     * @param Tax $Tax
     * Insertion tax in the DB
     */
    public function addToCustomers(Tax $tax, $customers)
    {
        $q = $this->_db->prepare('INSERT INTO tax (name, values,isActive) VALUES (:name, :values,:isActive)');
        $q->bindValue(':name', $tax->getName(), PDO::PARAM_STR);
        $q->bindValue(':values', $tax->getValue(), PDO::PARAM_STR);
        $q->bindValue(':isActive', $tax->getIsActive(), PDO::PARAM_INT);

        $q->execute();

        $tax = $this->getByName($tax->getName());

        $q2 = $this->_db->prepare('INSERT INTO link_customers_taxes (customers_idcustomers, tax_idtax) VALUES (:idcustomer, :idtax)');
        $q2->bindValue(':idcustomer', $customers, PDO::PARAM_INT);
        $q2->bindValue(':idcontact', $contact->getIdContact(), PDO::PARAM_INT);

        $q2->execute();

    }


    /*Reprendre ici la gestion des TAXES remplacer les contacts par Tax*/

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
        $query = 'SELECT * FROM contact WHERE name ="'.$contactName.'" AND firstname="'.$contactFirstName.'"';
        $q = $this->_db->query($query);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return new Contact($donnees);
    }

    /**
     * Get all the contact in the BDD
     * @return array
     */
    public function getList($customerId)
    {
        $contact = [];

        $q=$this->_db->query("SELECT cont.* FROM contact cont INNER JOIN  link_customers_contact lk ON cont.idContact =  lk.contact_idContact INNER JOIN customers c ON lk.customers_idcustomers = c.idcustomer WHERE cont.isActive='1' and c.isActive='1' and c.idcustomer =".$customerId);
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
        $q = $this->_db->prepare('UPDATE contact SET name = :name, firstname = :firstname, emailAddress = :emailAddress, phoneNumber = :phoneNumber, isActive = :isActive  WHERE idContact = :idContact');
        $q->bindValue(':idContact', $contact->getUsername(), PDO::PARAM_STR);
        $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
        $q->bindValue(':firstname', $contact->getFirstName(), PDO::PARAM_STR);
        $q->bindValue(':emailAddress', $contact->getEmailAddress(), PDO::PARAM_STR);
        $q->bindValue(':phoneNumber', $contact->getPhoneNumber(), PDO::PARAM_STR );
        $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);

        $q->execute();
    }

}