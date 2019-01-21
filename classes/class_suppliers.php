<?php
  class Suppliers extends Features{
    private $idSupplier;
    private $name;
    private $physicalAddress;
    private $invoiceAddress;
    private $isActive;
    private $companyName;

      /**
       * Supplier constructor.
       * @param array $data
       */
      public function __construct(array $data)
      {
          $this->generate($data);
      }

      /**
       * @return mixed
       */
      public function getIdSupplier()
      {
          return $this->idSupplier;
      }

      /**
       * @param mixed $idSupplier
       */
      public function setIdSupplier($idSupplier)
      {
          $this->idSupplier = $idSupplier;
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
      public function getPhysicalAddress()
      {
          return $this->physicalAddress;
      }

      /**
       * @param mixed $physicalAddress
       */
      public function setPhysicalAddress($physicalAddress)
      {
          $this->physicalAddress = $physicalAddress;
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
          $this->invoiceAddress = $invoiceAddress;
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
