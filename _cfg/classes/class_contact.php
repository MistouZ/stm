<?php

  class Contact extends Features{
    private $idContact;
    private $name;
    private $firstname;
    private $email_address;
    private $phone_number;
    private $isActive;
    private $companyName;


      /**
       * Users constructor.
       * Including array from users
       */

      public function __construct(array $data)
      {
          $this->generate($data);
      }

      /**
       * @return mixed
       */
      public function getIdContact()
      {
          return $this->idContact;
      }

      /**
       * @param mixed $idContact
       */
      public function setIdContact($idContact)
      {
          $this->idContact = $idContact;
      }

      /**
       * @return mixed
       */
      public function getName()
      {
          return $this->name;
      }

      /**
       * @param mixed $name
       */
      public function setName($name)
      {
          $this->name = $name;
      }

      /**
       * @return mixed
       */
      public function getFirstname()
      {
          return $this->firstname;
      }

      /**
       * @param mixed $firstname
       */
      public function setFirstname($firstname)
      {
          $this->firstname = $firstname;
      }

      /**
       * @return mixed
       */
      public function getEmailAddress()
      {
          return $this->email_address;
      }

      /**
       * @param mixed $email_address
       */
      public function setEmailAddress($email_address)
      {
          $this->email_address = $email_address;
      }

      /**
       * @return mixed
       */
      public function getPhoneNumber()
      {
          return $this->phone_number;
      }

      /**
       * @param mixed $phone_number
       */
      public function setPhoneNumber($phone_number)
      {
          $this->phone_number = $phone_number;
      }

      /**
       * @return mixed
       */
      public function getisActive()
      {
          return $this->isActive;
      }

      /**
       * @param mixed $isActive
       */
      public function setIsActive($isActive)
      {
          $this->isActive = $isActive;
      }

      /**
       * @return mixed
       */
      public function getCompanyName()
      {
          return $this->companyName;
      }

      /**
       * @param mixed $companyName
       */
      public function setCompanyName($companyName)
      {
          $this->companyName = $companyName;
      }


  }
?>
