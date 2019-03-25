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
    private $quotationNumber;
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