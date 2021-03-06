<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class ReceiverNativeAddressType
 */
class ReceiverNativeAddressType
{

    /**
     * @var name2 $name2
     */
    protected $name2;

    /**
     * @var name3 $name3
     */
    protected $name3;

    /**
     * @var streetName $streetName
     */
    protected $streetName;

    /**
     * @var streetNumber $streetNumber
     */
    protected $streetNumber;

    /**
     * @var addressAddition[] $addressAddition
     */
    protected $addressAddition;

    /**
     * @var dispatchingInformation $dispatchingInformation
     */
    protected $dispatchingInformation;

    /**
     * @var ZipType $zip
     */
    protected $zip;

    /**
     * @var city $city
     */
    protected $city;

    /**
     * @var CountryType $Origin
     */
    protected $Origin;

    /**
     * @param name2        $name2
     * @param name3        $name3
     * @param streetName   $streetName
     * @param streetNumber $streetNumber
     * @param ZipType      $zip
     * @param city         $city
     * @param CountryType  $Origin
     */
    public function __construct($name2, $name3, $streetName, $streetNumber, $zip, $city, $Origin)
    {
        $this->name2 = $name2;
        $this->name3 = $name3;
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->zip = $zip;
        $this->city = $city;
        $this->Origin = $Origin;
    }

    /**
     * @return name2
     */
    public function getName2()
    {
        return $this->name2;
    }

    /**
     * @param name2 $name2
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setName2($name2)
    {
        $this->name2 = $name2;
        return $this;
    }

    /**
     * @return name3
     */
    public function getName3()
    {
        return $this->name3;
    }

    /**
     * @param name3 $name3
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setName3($name3)
    {
        $this->name3 = $name3;
        return $this;
    }

    /**
     * @return streetName
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param streetName $streetName
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @return streetNumber
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param streetNumber $streetNumber
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * @return addressAddition[]
     */
    public function getAddressAddition()
    {
        return $this->addressAddition;
    }

    /**
     * @param addressAddition[] $addressAddition
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setAddressAddition(array $addressAddition = null)
    {
        $this->addressAddition = $addressAddition;
        return $this;
    }

    /**
     * @return dispatchingInformation
     */
    public function getDispatchingInformation()
    {
        return $this->dispatchingInformation;
    }

    /**
     * @param dispatchingInformation $dispatchingInformation
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setDispatchingInformation($dispatchingInformation)
    {
        $this->dispatchingInformation = $dispatchingInformation;
        return $this;
    }

    /**
     * @return ZipType
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param ZipType $zip
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param city $city
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return CountryType
     */
    public function getOrigin()
    {
        return $this->Origin;
    }

    /**
     * @param CountryType $Origin
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ReceiverNativeAddressType
     */
    public function setOrigin($Origin)
    {
        $this->Origin = $Origin;
        return $this;
    }

}
