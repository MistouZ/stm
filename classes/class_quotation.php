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
    private $year;
    private $month;
    private $day;
    private $type;
    private $comment;
    private $companyId;
    private $folderId;
    private $customerName;
    private $contactId;$
    private $descriptionId;

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
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
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
    public function setType($type)
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
    public function setComment($comment)
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
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param mixed $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
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
    public function getDescriptionId()
    {
        return $this->descriptionId;
    }

    /**
     * @param mixed $descriptionId
     */
    public function setDescriptionId($descriptionId)
    {
        $this->descriptionId = $descriptionId;
    }




}