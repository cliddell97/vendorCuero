<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class BankType
 */
class BankType
{

    /**
     * @var accountOwner $accountOwner
     */
    protected $accountOwner;

    /**
     * @var bankName $bankName
     */
    protected $bankName;

    /**
     * @var iban $iban
     */
    protected $iban;

    /**
     * @var note1 $note1
     */
    protected $note1;

    /**
     * @var note2 $note2
     */
    protected $note2;

    /**
     * @var bic $bic
     */
    protected $bic;

    /**
     * @var accountreference $accountreference
     */
    protected $accountreference;

    /**
     * @param accountOwner $accountOwner
     * @param bankName     $bankName
     * @param iban         $iban
     */
    public function __construct($accountOwner, $bankName, $iban)
    {
        $this->accountOwner = $accountOwner;
        $this->bankName = $bankName;
        $this->iban = $iban;
    }

    /**
     * @return accountOwner
     */
    public function getAccountOwner()
    {
        return $this->accountOwner;
    }

    /**
     * @param accountOwner $accountOwner
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\BankType
     */
    public function setAccountOwner($accountOwner)
    {
        $this->accountOwner = $accountOwner;
        return $this;
    }

    /**
     * @return bankName
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @param bankName $bankName
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\BankType
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
        return $this;
    }

    /**
     * @return iban
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param iban $iban
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\BankType
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return note1
     */
    public function getNote1()
    {
        return $this->note1;
    }

    /**
     * @param note1 $note1
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\BankType
     */
    public function setNote1($note1)
    {
        $this->note1 = $note1;
        return $this;
    }

    /**
     * @return note2
     */
    public function getNote2()
    {
        return $this->note2;
    }

    /**
     * @param note2 $note2
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\BankType
     */
    public function setNote2($note2)
    {
        $this->note2 = $note2;
        return $this;
    }

    /**
     * @return bic
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param bic $bic
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\BankType
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
        return $this;
    }

    /**
     * @return accountreference
     */
    public function getAccountreference()
    {
        return $this->accountreference;
    }

    /**
     * @param accountreference $accountreference
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\BankType
     */
    public function setAccountreference($accountreference)
    {
        $this->accountreference = $accountreference;
        return $this;
    }

}
