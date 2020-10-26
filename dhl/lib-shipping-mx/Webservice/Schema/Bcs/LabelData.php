<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class LabelData
 */
class LabelData
{

    /**
     * @var Statusinformation $Status
     */
    protected $Status;

    /**
     * @var shipmentNumber $shipmentNumber
     */
    protected $shipmentNumber;

    /**
     * @var string $labelUrl
     */
    protected $labelUrl;

    /**
     * @var base64Binary $labelData
     */
    protected $labelData;

    /**
     * @var string $returnLabelUrl
     */
    protected $returnLabelUrl;

    /**
     * @var base64Binary $returnLabelData
     */
    protected $returnLabelData;

    /**
     * @var string $exportLabelUrl
     */
    protected $exportLabelUrl;

    /**
     * @var base64Binary $exportLabelData
     */
    protected $exportLabelData;

    /**
     * @var string $codLabelUrl
     */
    protected $codLabelUrl;

    /**
     * @var base64Binary $codLabelData
     */
    protected $codLabelData;

    /**
     * @param Statusinformation $Status
     * @param shipmentNumber    $shipmentNumber
     */
    public function __construct($Status, $shipmentNumber)
    {
        $this->Status = $Status;
        $this->shipmentNumber = $shipmentNumber;
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
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return shipmentNumber
     */
    public function getShipmentNumber()
    {
        return $this->shipmentNumber;
    }

    /**
     * @param shipmentNumber $shipmentNumber
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelUrl()
    {
        return $this->labelUrl;
    }

    /**
     * @param string $labelUrl
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setLabelUrl($labelUrl)
    {
        $this->labelUrl = $labelUrl;
        return $this;
    }

    /**
     * @return base64Binary
     */
    public function getLabelData()
    {
        return $this->labelData;
    }

    /**
     * @param base64Binary $labelData
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setLabelData($labelData)
    {
        $this->labelData = $labelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnLabelUrl()
    {
        return $this->returnLabelUrl;
    }

    /**
     * @param string $returnLabelUrl
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setReturnLabelUrl($returnLabelUrl)
    {
        $this->returnLabelUrl = $returnLabelUrl;
        return $this;
    }

    /**
     * @return base64Binary
     */
    public function getReturnLabelData()
    {
        return $this->returnLabelData;
    }

    /**
     * @param base64Binary $returnLabelData
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setReturnLabelData($returnLabelData)
    {
        $this->returnLabelData = $returnLabelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportLabelUrl()
    {
        return $this->exportLabelUrl;
    }

    /**
     * @param string $exportLabelUrl
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setExportLabelUrl($exportLabelUrl)
    {
        $this->exportLabelUrl = $exportLabelUrl;
        return $this;
    }

    /**
     * @return base64Binary
     */
    public function getExportLabelData()
    {
        return $this->exportLabelData;
    }

    /**
     * @param base64Binary $exportLabelData
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setExportLabelData($exportLabelData)
    {
        $this->exportLabelData = $exportLabelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodLabelUrl()
    {
        return $this->codLabelUrl;
    }

    /**
     * @param string $codLabelUrl
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setCodLabelUrl($codLabelUrl)
    {
        $this->codLabelUrl = $codLabelUrl;
        return $this;
    }

    /**
     * @return base64Binary
     */
    public function getCodLabelData()
    {
        return $this->codLabelData;
    }

    /**
     * @param base64Binary $codLabelData
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\LabelData
     */
    public function setCodLabelData($codLabelData)
    {
        $this->codLabelData = $codLabelData;
        return $this;
    }

}
