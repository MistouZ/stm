<?php

  class Company extends Features{
    private $idcompany;
    private $name;
    private $nameData;
    private $address;
    private $isActive;


      /**
       * Company constructor.
       * @param array $data
       */

      public function __construct(array $data)
      {
          $this->generate($data);
      }


      /**
       * @return mixed
       */
      public function getIdcompany()
      {
          return $this->idcompany;
      }

      /**
       * @param mixed $idcompany
       */
      public function setIdcompany($idcompany): void
      {
          $idcompany = (int) $idcompany;
          $this->idcompany = $idcompany;
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
      public function getNameData()
      {
          return $this->nameData;
      }
      
      /**
       * @param mixed $name
       */
      public function setNameData($nameData): void
      {
          if(is_string($nameData))
          {
              $this->nameData = $nameData;
          }
      }

      /**
       * @return mixed
       */
      public function getAddress()
      {
          return $this->address;
      }

      /**
       * @param mixed $address
       */
      public function setAddress($address): void
      {
          if(is_string($address))
          {
              $this->address = $address;
          }
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




  }
?>
