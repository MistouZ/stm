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
        if($contact->getIdContact() == NULL)
        {
            try
            {
                $contact->setName(strtoupper($contact->getName()));
                $q = $this->_db->prepare('INSERT INTO contact (name, firstname,emailAddress,phoneNumber,isActive) VALUES (:name, :firstname, :emailAddress, :phoneNumber,:isActive)');
                $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
                $q->bindValue(':firstname', $contact->getFirstname(), PDO::PARAM_STR);
                $q->bindValue(':emailAddress', $contact->getEmailAddress(), PDO::PARAM_STR );
                $q->bindValue(':phoneNumber', $contact->getPhoneNumber(), PDO::PARAM_INT);
                $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);
                $q->execute();

            }
            catch(Exception $e){
                return null;
            }
            $contact = $this->getByName($contact->getName(), $contact->getFirstname());
        }
        $this->linkToCustomer($contact,$customers);
    }

    /**
     * @param Contact $contact
     * @param Customer $idCustomer
     * Ajouter le contact au client 
     */

     public function linkToCustomer(Contact $contact, $customers)
    {
        try
        {
            $q2 = $this->_db->prepare('INSERT INTO link_customers_contact (customers_idcustomers, contact_idcontact) VALUES (:idcustomer, :idcontact)');
            $q2->bindValue(':idcustomer', $customers, PDO::PARAM_INT);
            $q2->bindValue(':idcontact', $contact->getIdContact(), PDO::PARAM_INT);
            $q2->execute();
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * @param Contact $contact
     * Insertion contact in the DB
     */
    public function addToSuppliers(Contact $contact,$suppliers)
    {
        if($contact->getIdContact() == NULL)
        {
            try
            {
                $contact->setName(strtoupper($contact->getName()));
                $q = $this->_db->prepare('INSERT INTO contact (name, firstname,emailAddress,phoneNumber,isActive) VALUES (:name, :firstname, :emailAddress, :phoneNumber,:isActive)');
                $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
                $q->bindValue(':firstname', $contact->getFirstname(), PDO::PARAM_STR);
                $q->bindValue(':emailAddress', $contact->getEmailAddress(), PDO::PARAM_STR );
                $q->bindValue(':phoneNumber', $contact->getPhoneNumber(), PDO::PARAM_INT);
                $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);
                $q->execute();
            }
            catch(Exception $e){
                return null;
            }
            $contact = $this->getByName($contact->getName(), $contact->getFirstname());
        }
        
        $this->linkToSupplier($contact,$suppliers);
    }

    /**
     * @param Contact $contact
     * @param Customer $idCustomer
     * Ajouter le contact au client 
     */

     public function linkToSupplier(Contact $contact,$suppliers)
    {
        try
        {
            $q2 = $this->_db->prepare('INSERT INTO link_suppliers_contact (suppliers_idsupplier, contact_idcontact) VALUES (:idsupplier, :idcontact)');
            $q2->bindValue(':idsupplier', $suppliers, PDO::PARAM_INT);
            $q2->bindValue(':idcontact', $contact->getIdContact(), PDO::PARAM_INT);
            $q2->execute();
        }
        catch(Exception $e){
            return null;
        }
    }



    /**
     * Find a contact by his idContact
     * @param $idContact
     * @return Contact
     */
    public function getById($idContact)
    {
        $idContact = (integer) $idContact;
        $q = $this->_db->query('SELECT * FROM contact WHERE isActive=\'1\' AND idContact ='.$idContact);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        if($donnees != NULL )
        {
            return new Contact($donnees);
        }
        else
        {
            $array = array(
                'name' => "Supprimé",
                'firstname' => "Contact"
            );
            return new Contact($array);
        }
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
        $q = $this->_db->query('SELECT * FROM contact WHERE isActive=\'1\' AND name ="'.$contactName.'" AND firstname="'.$contactFirstName.'"');
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        if($donnees != NULL )
        {
            return new Contact($donnees);
        }
        else
        {
            $q2 = $this->_db->query('SELECT * FROM contact WHERE isActive=\'0\' AND name ="'.$contactName.'" AND firstname="'.$contactFirstName.'"');
            $donnees2 = $q2->fetch(PDO::FETCH_ASSOC);
            if($donnees2 != NULL )
            {
                $array = array(
                    'idContact' => $donnees2["idcontact"],
                    'name' => "Supprimé",
                    'firstname' => "Contact"
                );
                return new Contact($array);
            }
            else
            {
                $array = array(
                    'idContact' => 0
                );
                return new Contact($array);
            }
        }
    }
    /**
     * Get all the active contact in the BDD
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
     * Get all the contact in the BDD
     * @return array
     */
    public function getListAllToCustomer($customerId)
    {
        $contact = [];
        $q=$this->_db->query("SELECT cont.* FROM contact cont INNER JOIN  link_customers_contact lk ON cont.idContact =  lk.contact_idContact INNER JOIN customers c ON lk.customers_idcustomers = c.idcustomer WHERE c.isActive='1' and c.idcustomer =".$customerId);
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $contact[] = new Contact($donnees);
        }
        return $contact;
    }

    /**
     * Get all the active contact in the BDD
     * @return array
     */
    public function getListSupplier($supplierId)
    {
        $contact = [];
        $q=$this->_db->query("SELECT cont.* FROM contact cont INNER JOIN  link_suppliers_contact lk ON cont.idContact =  lk.contact_idcontact INNER JOIN suppliers s ON lk.suppliers_idsupplier = s.idsupplier WHERE cont.isActive='1' and s.isActive='1' and s.idsupplier =".$supplierId);
        while($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $contact[] = new Contact($donnees);
        }
        return $contact;
    }

    /**
     * Get all the contact in the BDD
     * @return array
     */
    public function getListAllToSupplier($supplierId)
    {
        $contact = [];
        $q=$this->_db->query("SELECT cont.* FROM contact cont INNER JOIN  link_suppliers_contact lk ON cont.idContact =  lk.contact_idcontact INNER JOIN suppliers s ON lk.suppliers_idsupplier = s.idsupplier WHERE s.isActive='1' and s.idsupplier =".$supplierId);
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
        try{
            $contact->setName(strtoupper($contact->getName()));
            $q = $this->_db->prepare('UPDATE contact SET name = :name, firstname = :firstname, emailAddress = :emailAddress, phoneNumber = :phoneNumber, isActive = :isActive  WHERE idContact = :idContact');
            $q->bindValue(':idContact', $contact->getIdContact(), PDO::PARAM_INT);
            $q->bindValue(':name', $contact->getName(), PDO::PARAM_STR);
            $q->bindValue(':firstname', $contact->getFirstname(), PDO::PARAM_STR);
            $q->bindValue(':emailAddress', $contact->getEmailAddress(), PDO::PARAM_STR );
            $q->bindValue(':phoneNumber', $contact->getPhoneNumber(), PDO::PARAM_INT);
            $q->bindValue(':isActive', $contact->getisActive(), PDO::PARAM_INT);
            $q->execute();

            return "ok";
        }
        catch(Exception $e){
            return null;
        }
    }

    /**
     * Reactivate the contact
     * @param Contact $contact
     */
    public function reactivate(Contact $contact)
    {
        $q = $this->_db->prepare('UPDATE contact SET isActive = \'1\' WHERE idContact = :idContact');
        $q->bindValue(':idContact', $contact->getIdContact(), PDO::PARAM_INT);
        $q->execute();
    }

    /**
     * @param Contact $contact
     * Delete contact link to the customer $customer (Idcustomer)
     * Disable the contact if there is no more link with customers
     */
    public function deleteToCustomer(Contact $contact, $customer)
    {
        $customer = (integer) $customer;

        $delete=$this->_db->prepare('DELETE FROM `link_customers_contact` WHERE contact_idcontact = :idContact AND customers_idcustomers = :idcustomer');
        $delete->bindValue(':idcustomer', $customer, PDO::PARAM_INT);
        $delete->bindValue(':idContact', $contact->getIdContact(), PDO::PARAM_INT);
        $delete->execute();

        //compter le nombre de liaison restante sur le contact.

        $count = $this->_db->query('SELECT COUNT(*) FROM link_customers_contact WHERE contact_idcontact='.$contact->getIdContact().' GROUP BY contact_idcontact')->fetchColumn();
        if($count == 0)
        {
            $q = $this->_db->prepare('UPDATE contact SET isActive = \'0\' WHERE idContact = :idContact');
            $q->bindValue(':idContact', $contact->getIdContact(), PDO::PARAM_INT);
            $q->execute();
        }
    }

    /**
     * @param Contact $contact
     * Delete contact link to the supplier $supplier (Idsupplier)
     * Disable the contact if there is no more link with suppliers
     */
    public function deleteToSupplier(Contact $contact, $supplier)
    {
        $supplier = (integer) $supplier;

        $delete=$this->_db->prepare('DELETE FROM `link_suppliers_contact` WHERE suppliers_idsupplier = :idsupplier AND contact_idcontact = :idContact');
        $delete->bindValue(':idsupplier', $supplier, PDO::PARAM_INT);
        $delete->bindValue(':idContact', $contact->getIdContact(), PDO::PARAM_INT);
        $delete->execute();

        //compter le nombre de liaison restante sur le contact.

        $count = $this->_db->query('SELECT COUNT(*) FROM link_suppliers_contact WHERE contact_idcontact='.$contact->getIdContact().' GROUP BY contact_idcontact')->fetchColumn();
        if($count == 0)
        {
            $q = $this->_db->prepare('UPDATE contact SET isActive = \'0\' WHERE idContact = :idContact');
            $q->bindValue(':idContact', $contact->getIdContact(), PDO::PARAM_INT);
            $q->execute();
        }
    }



}