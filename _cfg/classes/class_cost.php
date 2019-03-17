<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/11/2018
 * Time: 14:07
 */

class Cost
{
    private $idCost;
    private $description;
    private $value;
    private $quotationNumber;
    private $folderId;
    private $providerId;

    /**
     * Cost constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdCost()
    {
        return $this->idCost;
    }

    /**
     * @param mixed $idCost
     */
    public function setIdCost($idCost)
    {
        $idCost = (int) $idCost;
        $this->idCost = $idCost;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        if(is_string($description))
        {
            $this->description = $description;
        }

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
    public function setValue($value)
    {
        $value = (int) $value;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getQuotationNumber()
    {
        return $this->quotationNumber;
    }

    /**
     * @param mixed $quotationNumber
     */
    public function setQuotationNumber($quotationNumber): void
    {
        $this->quotationNumber = $quotationNumber;
    }


    /**
     * @return mixed
     */
    public function getFolderId()
    {
        return $this->folderId;
    }

    /**
     * @param mixed $folderId
     */
    public function setFolderId($folderId): void
    {
        $this->folderId = $folderId;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @param mixed $providerId
     */
    public function setProviderId($providerId): void
    {
        $this->providerId = $providerId;
    }




}