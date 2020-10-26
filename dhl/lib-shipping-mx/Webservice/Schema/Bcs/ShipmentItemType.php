<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class ShipmentItemType
 */
class ShipmentItemType
{

    /**
     * @var weightInKG $weightInKG
     */
    protected $weightInKG;

    /**
     * @var lengthInCM $lengthInCM
     */
    protected $lengthInCM;

    /**
     * @var widthInCM $widthInCM
     */
    protected $widthInCM;

    /**
     * @var heightInCM $heightInCM
     */
    protected $heightInCM;

    /**
     * @param weightInKG $weightInKG
     */
    public function __construct($weightInKG)
    {
        $this->weightInKG = $weightInKG;
    }

    /**
     * @return weightInKG
     */
    public function getWeightInKG()
    {
        return $this->weightInKG;
    }

    /**
     * @param weightInKG $weightInKG
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ShipmentItemType
     */
    public function setWeightInKG($weightInKG)
    {
        $this->weightInKG = $weightInKG;
        return $this;
    }

    /**
     * @return lengthInCM
     */
    public function getLengthInCM()
    {
        return $this->lengthInCM;
    }

    /**
     * @param lengthInCM $lengthInCM
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ShipmentItemType
     */
    public function setLengthInCM($lengthInCM)
    {
        $this->lengthInCM = $lengthInCM;
        return $this;
    }

    /**
     * @return widthInCM
     */
    public function getWidthInCM()
    {
        return $this->widthInCM;
    }

    /**
     * @param widthInCM $widthInCM
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ShipmentItemType
     */
    public function setWidthInCM($widthInCM)
    {
        $this->widthInCM = $widthInCM;
        return $this;
    }

    /**
     * @return heightInCM
     */
    public function getHeightInCM()
    {
        return $this->heightInCM;
    }

    /**
     * @param heightInCM $heightInCM
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ShipmentItemType
     */
    public function setHeightInCM($heightInCM)
    {
        $this->heightInCM = $heightInCM;
        return $this;
    }

}
