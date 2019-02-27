<?php

  class Tax extends Features{
    private $idTax;
    private $percent;
    private $name;
    private $value;
    private $isActive;
    private $isDefault;


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
    public function getIdTax()
    {
      return $this->idTax;
    }

    /**
     * @param mixed $idtax
     */
    public function setIdTax($idTax): void
    {
      $this->idTax = $idTax;
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
      $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPercent()
    {
      return $this->percent;
    }

    /**
     * @param mixed $percent
     */
    public function setPercent($percent): void
    {
      $this->percent = $percent;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
      return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
      $this->value = $value;
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
    public function setIsActive($isActive): void
    {
      $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getIsDefault()
    {
      return $this->isDefault;
    }

    /**
     * @param mixed $isDefault
     */
    public function setIsDefault($isDefault): void
    {
      $this->isDefault = $isDefault;
    }

  }
?>
