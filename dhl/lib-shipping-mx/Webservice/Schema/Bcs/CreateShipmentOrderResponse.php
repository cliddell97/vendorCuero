<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class CreateShipmentOrderResponse
 */
class CreateShipmentOrderResponse
{

    /**
     * @var Version $Version
     */
    protected $Version;

    /**
     * @var Statusinformation $Status
     */
    protected $Status;

    /**
     * @var CreationState $CreationState
     */
    protected $CreationState;

    /**
     * @param Version           $Version
     * @param Statusinformation $Status
     * @param CreationState     $CreationState
     */
    public function __construct($Version, $Status, $CreationState)
    {
        $this->Version = $Version;
        $this->Status = $Status;
        $this->CreationState = $CreationState;
    }

    /**
     * @return Version
     */
    public function getVersion()
    {
        return $this->Version;
    }

    /**
     * @param Version $Version
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\CreateShipmentOrderResponse
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
        return $this;
    }

    /**
     * @return Statusinformation
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param Statusinformation $Status
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\CreateShipmentOrderResponse
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return CreationState
     */
    public function getCreationState()
    {
        return $this->CreationState;
    }

    /**
     * @param CreationState $CreationState
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\CreateShipmentOrderResponse
     */
    public function setCreationState($CreationState)
    {
        $this->CreationState = $CreationState;
        return $this;
    }

}
