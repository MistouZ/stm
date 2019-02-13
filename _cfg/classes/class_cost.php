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
    private $quotation_id;
    private $folder_id;
    private $provider_id;

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
    public function getQuotationId()
    {
        return $this->quotation_id;
    }

    /**
     * @param mixed $quotation_id
     */
    public function setQuotationId($quotation_id)
    {
        $quotation_id = (int) $quotation_id;
        $this->quotation_id = $quotation_id;
    }

    /**
     * @return mixed
     */
    public function getFolderId()
    {
        return $this->folder_id;
    }

    /**
     * @param mixed $folder_id
     */
    public function setFolderId($folder_id)
    {
        $folder_id = (int) $folder_id;
        $this->folder_id = $folder_id;
    }

    /**
     * @return mixed
     */
    public function getProviderId()
    {
        return $this->provider_id;
    }

    /**
     * @param mixed $provider_id
     */
    public function setProviderId($provider_id)
    {
        $provider_id = (int) $provider_id;
        $this->provider_id = $provider_id;
    }


}