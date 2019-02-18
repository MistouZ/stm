<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/11/2018
 * Time: 13:49
 */

class Asset
{
    private $idAsset;
    private $quotation_number;
    private $status;
    private $percent;
    private $year;
    private $month;
    private $day;
    private $type;
    private $comment;
    private $company_id;
    private $folder_id;
    private $customer_name;
    private $contact_id;$
    private $description_id;

    /**
     * class_asset constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdAsset()
    {
        return $this->idAsset;
    }

    /**
     * @param mixed $idAsset
     */
    public function setIdAsset($idAsset)
    {
        $idAsset = (int) $idAsset;
        $this->idAsset = $idAsset;
    }

    /**
     * @return mixed
     */
    public function getQuotationNumber()
    {
        return $this->quotation_number;
    }

    /**
     * @param mixed $quotation_number
     */
    public function setQuotationNumber($quotation_number)
    {
        $quotation_number = (int) $quotation_number;
        $this->quotation_number = $quotation_number;
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
        if(is_string($status))
        {
            $this->status = $status;
        }
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
    public function setPercent($percent)
    {
        $percent = (int) $percent;
        $this->percent = $percent;
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
        $year = (int) $year;
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
        $month = (int)$month;
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
        $day = (int) $day;
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
        if(is_string($type)){
            $this->type = $type;
        }
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
        if(is_string($comment))
        {
            $this->comment = $comment;
        }
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id)
    {
        $company_id = (int) $company_id;
        $this->company_id = $company_id;
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
    public function getCustomerName()
    {
        return $this->customer_name;
    }

    /**
     * @param mixed $customer_name
     */
    public function setCustomerName($customer_name)
    {
        if(is_string($customer_name))
        {
            $this->customer_name = $customer_name;
        }

    }

    /**
     * @return mixed
     */
    public function getContactId()
    {
        return $this->contact_id;
    }

    /**
     * @param mixed $contact_id
     */
    public function setContactId($contact_id)
    {   $contact_id = (int) $contact_id;
        $this->contact_id = $contact_id;
    }

    /**
     * @return mixed
     */
    public function getDescriptionId()
    {
        return $this->description_id;
    }

    /**
     * @param mixed $description_id
     */
    public function setDescriptionId($description_id)
    {
        $description_id = (int) $description_id;
        $this->description_id = $description_id;
    }


}