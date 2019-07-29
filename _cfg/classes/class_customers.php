<?php
  class Customers extends Features{
    private $idcustomer;
    private $name;
    private $physicalAddress;
    private $invoiceAddress;
    private $isActive;
    private $companyName;
    private $account;
    private $subaccount;

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
          return $this->idcustomer;
      }

      /**
       * @param mixed $idcustomer
       */
      public function setIdcustomer($idcustomer): void
      {
          $idcustomer = (int) $idcustomer;
          $this->idcustomer = $idcustomer;
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
              $this->name = ucwords($name);
          }
      }

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
      public function setPhysicalAddress($physicalAddress): void
      {
          if(is_string($physicalAddress))
          {
              $this->physicalAddress = ucwords($physicalAddress);
          }
      }

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
      public function setInvoiceAddress($invoiceAddress): void
      {
          if(is_string($invoiceAddress))
          {
              $this->invoiceAddress = ucwords($invoiceAddress);
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

      /**
       * @return mixed
       */
      public function getAccount()
      {
          return $this->account;
      }

      /**
       * @param mixed $account
       */
      public function setAccount($account): void
      {
          $this->account = $account;
      }

      /**
       * @return mixed
       */
      public function getSubaccount()
      {
          return $this->subaccount;
      }

      /**
       * @param mixed $subaccount
       */
      public function setSubaccount($subaccount): void
      {
          $this->subaccount = $subaccount;
      }
  }
?>
