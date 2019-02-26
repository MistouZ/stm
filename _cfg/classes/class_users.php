<?php

  class Users extends Features{
    private $username;
    private $name;
    private $firstname;
    private $password;
    private $emailAddress;
    private $phoneNumber;
    private $credential;
    private $isSeller;
    private $isActive;
    private $defaultCompany;
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
      public function getUsername()
      {
          return $this->username;
      }

      /**
       * @param mixed $username
       */
      public function setUsername($username): void
      {
          if(is_string($username))
          {
              $this->username = $username;
          }
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
      public function setName($name): void
      {
          if(is_string($name))
          {
              $this->name = $name;
          }

      }

      /**
       * @return mixed
       */
      public function getFirstName()
      {
          return $this->firstname;
      }

      /**
       * @param mixed $firstname
       */
      public function setFirstName($firstname): void
      {
          if(is_string($firstname))
          {
              $this->firstname = $firstname;
          }

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
      public function setPassword($password): void
      {
          if(is_string($password))
          {
              $this->password = password_hash($password, PASSWORD_DEFAULT);
          }
      }

      /**
       * @return mixed
       */
      public function getEmailAddress()
      {
          return $this->emailAddress;
      }

      /**
       * @param mixed $email_address
       */
      public function setEmailAddress($emailAddress)
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
       * @param mixed $phone_number
       */
      public function setPhoneNumber($phoneNumber)
      {
          $this->phoneNumber = $phoneNumber;
      }

      /**
       * @return mixed
       */
      public function getCredential()
      {
          return $this->credential;
      }

      /**
       * @param mixed $credential
       */
      public function setCredential($credential)
      {
          $this->credential = $credential;
      }

      /**
       * @return mixed
       */
      public function getIsSeller()
      {
          return $this->isSeller;
      }

      /**
       * @param mixed $isSeller
       */
      public function setIsSeller($isSeller)
      {
          $this->isSeller = $isSeller;
      }

      /**
       * @return mixed
       */
      public function getIsActive()
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
      public function getDefaultCompany()
      {
          return $this->defaultCompany;
      }

      /**
       * @param mixed $defaultCompany
       */
      public function setDefaultCompany($defaultCompany): void
      {
          $this->defaultCompany = $defaultCompany;
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
      public function setCompanyName($companyName): void
      {
          $this->companyName = $companyName;
      }



  }
?>
