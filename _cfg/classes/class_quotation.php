<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/11/2018
 * Time: 11:30
 */

class Quotation extends Features
{
    private $idQuotation;
    private $quotationNumber;
    private $status;
    private $label;
    private $date;
    private $type;
    private $companyId;
    private $folderId;
    private $customerId;
    private $contactId;
    private $comment;
    private $validatedDate;

    /**
     * Quotation constructor.
     */
    public function __construct(array $data)
    {
        $this->generate($data);
    }

    /**
     * @return mixed
     */
    public function getIdQuotation()
    {
        return $this->idQuotation;
    }

    /**
     * @param mixed $idQuotation
     */
    public function setIdQuotation($idQuotation)
    {
        $this->idQuotation = $idQuotation;
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
    public function setQuotationNumber($quotationNumber)
    {
        $this->quotationNumber = $quotationNumber;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label): void
    {
        $this->label = $label;
    }

     /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }
    
    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param mixed $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
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
    public function setFolderId($folderId)
    {
        $this->folderId = $folderId;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return mixed
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * @param mixed $contactId
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
    }

    /**
     * @return mixed
     */
    public function getValidatedDate()
    {
        return $this->validatedDate;
    }

    /**
     * @param mixed $validatedDate
     */
    public function setValidatedDate($validatedDate): void
    {
        $this->validatedDate = $validatedDate;
    }



}