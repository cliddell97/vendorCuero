<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class ServiceconfigurationDeliveryTimeframe
 */
class ServiceconfigurationDeliveryTimeframe
{

    /**
     * @var anonymous145 $active
     */
    protected $active;

    /**
     * @var anonymous146 $type
     */
    protected $type;

    /**
     * @param anonymous145 $active
     * @param anonymous146 $type
     */
    public function __construct($active, $type)
    {
        $this->active = $active;
        $this->type = $type;
    }

    /**
     * @return anonymous145
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param anonymous145 $active
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ServiceconfigurationDeliveryTimeframe
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return anonymous146
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param anonymous146 $type
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\ServiceconfigurationDeliveryTimeframe
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}
