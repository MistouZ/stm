<?php

  class Contact extends Features{
    private $idContact;
    private $name;
    private $firstname;
    private $emailAddress;
    private $phoneNumber;
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
        return $this->emailAddress;
      }

      /**
       * @param mixed $emailAddress
       */
      public function setEmailAddress($emailAddress): void
      {
        $this->emailAddress = $emailAddress;
      }

      /**
       * @return mixed
       */
      public function getPhoneNumber()
      {
        return $this->phoneNumber;
      }

      /**
       * @param mixed $phoneNumber
       */
      public function setPhoneNumber($phoneNumber): void
      {
        $this->phoneNumber = $phoneNumber;
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
