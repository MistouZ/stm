<?php

  class Counter extends Features{
    private $company;
    private $folder;
    private $quotation;
    private $invoice;
    private $asset;
    


      /**
       * Users constructor.
       * Including array from users
       */

      public function __construct(array $data)
      {
          $this->generate($data);
      }

      
      /**
     * Get the value of company
     */ 
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of company
     *
     * @return  self
     */ 
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    
    

    /**
     * Get the value of folder
     */ 
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Set the value of folder
     *
     * @return  self
     */ 
    public function setFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get the value of quotation
     */ 
    public function getQuotation()
    {
        return $this->quotation;
    }

    /**
     * Set the value of quotation
     *
     * @return  self
     */ 
    public function setQuotation($quotation)
    {
        $this->quotation = $quotation;

        return $this;
    }

    /**
     * Get the value of invoice
     */ 
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set the value of invoice
     *
     * @return  self
     */ 
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get the value of assets
     */ 
    public function getAsset()
    {
        return $this->asset;
    }

    /**
     * Set the value of assets
     *
     * @return  self
     */ 
    public function setAsset($asset)
    {
        $this->asset = $asset;

        return $this;
    }
  }
?>
