<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class Statusinformation
 */
class Statusinformation
{

    /**
     * @var int $statusCode
     */
    protected $statusCode;

    /**
     * @var string $statusText
     */
    protected $statusText;

    /**
     * @var string[] $statusMessage
     */
    protected $statusMessage;

    /**
     * @param int      $statusCode
     * @param string   $statusText
     * @param string[] $statusMessage
     */
    public function __construct($statusCode, $statusText, array $statusMessage)
    {
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
        $this->statusMessage = $statusMessage;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Statusinformation
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * @param string $statusText
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Statusinformation
     */
    public function setStatusText($statusText)
    {
        $this->statusText = $statusText;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @param string[] $statusMessage
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Statusinformation
     */
    public function setStatusMessage(array $statusMessage)
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

}
