<?php
/**
 * Created by PhpStorm.
 * User: adewynter
 * Date: 22/11/2018
 * Time: 11:30
 */

class ShatteredQuotation extends Features
{
    private $idShatteredQuotation;
    private $quotationNumberInit;
    private $quotationNumberChild;
    private $percent;

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
    public function getIdShatteredQuotation()
    {
        return $this->idShatteredQuotation;
    }

    /**
     * @param mixed $idShatteredQuotation
     */
    public function setIdShatteredQuotation($idShatteredQuotation): void
    {
        $this->idShatteredQuotation = $idShatteredQuotation;
    }

    /**
     * @return mixed
     */
    public function getQuotationNumberInit()
    {
        return $this->quotationNumberInit;
    }

    /**
     * @param mixed $quotationNumberInit
     */
    public function setQuotationNumberInit($quotationNumberInit): void
    {
        $this->quotationNumberInit = $quotationNumberInit;
    }

    /**
     * @return mixed
     */
    public function getQuotationNumberChild()
    {
        return $this->quotationNumberChild;
    }

    /**
     * @param mixed $quotationNumberChild
     */
    public function setQuotationNumberChild($quotationNumberChild): void
    {
        $this->quotationNumberChild = $quotationNumberChild;
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

}