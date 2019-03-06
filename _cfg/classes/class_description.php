<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/11/2018
 * Time: 15:03
 */

class Description
{
    private $idDescription;
    private $quotation_number;
    private $description;
    private $quantity;
    private $discount;
    private $price;
    private $tax;

    /**
     * Description constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getIdDescription()
    {
        return $this->idDescription;
    }

    /**
     * @param mixed $idDescription
     */
    public function setIdDescription($idDescription)
    {
        if(is_string($idDescription))
        {
            $this->idDescription = $idDescription;
        }
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
        if(is_string($quotation_number))
        {
            $this->quotation_number = $quotation_number;
        }
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
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param mixed $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax): void
    {
        $this->tax = $tax;
    }




}