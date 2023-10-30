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
    private $modalite;

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
      public function setIdcustomer($idcustomer)
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
      public function setName($name)
      {
          if(is_string($name))
          {
              $this->name = mb_strtoupper($name);
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
      public function setPhysicalAddress($physicalAddress)
      {
          if(is_string($physicalAddress))
          {
              $this->physicalAddress = $physicalAddress;
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
      public function setInvoiceAddress($invoiceAddress)
      {
          if(is_string($invoiceAddress))
          {
              $this->invoiceAddress = $invoiceAddress;
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
       * @param mixed $modalite
       */
      public function setModalite($modalite)
      {
          $this->modalite = $modalite;
      }

      /**
       * @return mixed
       */
      public function getModalite()
      {
          return $this->modalite;
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
      public function setAccount($account)
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
      public function setSubaccount($subaccount)
      {
          $this->subaccount = $subaccount;
      }
  }
?>
