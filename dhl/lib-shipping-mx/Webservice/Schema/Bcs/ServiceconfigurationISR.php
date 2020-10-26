<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class ServiceconfigurationISR
 */
class ServiceconfigurationISR
{

    /**
     * @var anonymous136 $active
     */
    protected $active;

    /**
     * @var anonymous137 $details
     */
    protected $details;

    /**
     * @param anonymous136 $active
     * @param anonymous137 $details
     */
    public function __construct($active, $details)
    {
        $this->active = $active;
        $this->details = $details;
    }

    /**
     * @return anonymous136
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param anonymous136 $active
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ServiceconfigurationISR
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return anonymous137
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param anonymous137 $details
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ServiceconfigurationISR
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

}
