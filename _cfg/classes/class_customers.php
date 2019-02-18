<?php
  class Customers extends Features{
    private $idCustomer;
    private $name;
    private $physicalAddress;
    private $invoiceAddress;
    private $isActive;
    private $companyName;

      /**
       * Customer constructor.
       * @param array $data
       */
      public function __construct(array $data)
      {
          $this->generate($data);
      }

      /**
       * @return mixed
       */
      public function getIdCustomer()
      {
          return $this->idCustomer;
      }

      /**
       * @param mixed $idCustomer
       */
    /*  public function setIdCustomer($idCustomer): void
      {
          $idCustomer = (int) $idCustomer;
          $this->idCustomer = $idCustomer;
      }*/

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
    /*  public function setName($name): void
      {
          if(is_string($name))
          {
              $this->name = $name;
          }
      }*/

      /**
       * @return mixed
       */
      public function getPhysicalAddress()
      {
          return $this->physicalAddress;
      }

      /**
       * @param mixed $physicalAddress
       */
    /*  public function setPhysicalAddress($physicalAddress): void
      {
          if(is_string($physicalAddress))
          {
              $this->physicalAddress = $physicalAddress;
          }
      }*/

      /**
       * @return mixed
       */
      public function getInvoiceAddress()
      {
          return $this->invoiceAddress;
      }

      /**
       * @param mixed $invoiceAddress
       */
     /* public function setInvoiceAddress($invoiceAddress): void
      {
          if(is_string($invoiceAddress))
          {
              $this->invoiceAddress = $invoiceAddress;
          }
      }*/

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
