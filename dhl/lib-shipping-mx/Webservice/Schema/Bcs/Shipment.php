<?php

namespace Dhl\Shipping\Webservice\Schema\Bcs;

/**
 * Class Shipment
 */
class Shipment
{

    /**
     * @var ShipmentDetailsTypeType $ShipmentDetails
     */
    protected $ShipmentDetails;

    /**
     * @var ShipperType $Shipper
     */
    protected $Shipper;

    /**
     * @var ReceiverType $Receiver
     */
    protected $Receiver;

    /**
     * @var ShipperType $ReturnReceiver
     */
    protected $ReturnReceiver;

    /**
     * @var ExportDocumentType $ExportDocument
     */
    protected $ExportDocument;

    /**
     * @param ShipmentDetailsTypeType $ShipmentDetails
     * @param ShipperType             $Shipper
     * @param ReceiverType            $Receiver
     * @param ShipperType             $ReturnReceiver
     * @param ExportDocumentType      $ExportDocument
     */
    public function __construct($ShipmentDetails, $Shipper, $Receiver, $ReturnReceiver, $ExportDocument)
    {
        $this->ShipmentDetails = $ShipmentDetails;
        $this->Shipper = $Shipper;
        $this->Receiver = $Receiver;
        $this->ReturnReceiver = $ReturnReceiver;
        $this->ExportDocument = $ExportDocument;
    }

    /**
     * @return ShipmentDetailsTypeType
     */
    public function getShipmentDetails()
    {
        return $this->ShipmentDetails;
    }

    /**
     * @param ShipmentDetailsTypeType $ShipmentDetails
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Shipment
     */
    public function setShipmentDetails($ShipmentDetails)
    {
        $this->ShipmentDetails = $ShipmentDetails;
        return $this;
    }

    /**
     * @return ShipperType
     */
    public function getShipper()
    {
        return $this->Shipper;
    }

    /**
     * @param ShipperType $Shipper
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Shipment
     */
    public function setShipper($Shipper)
    {
        $this->Shipper = $Shipper;
        return $this;
    }

    /**
     * @return ReceiverType
     */
    public function getReceiver()
    {
        return $this->Receiver;
    }

    /**
     * @param ReceiverType $Receiver
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Shipment
     */
    public function setReceiver($Receiver)
    {
        $this->Receiver = $Receiver;
        return $this;
    }

    /**
     * @return ShipperType
     */
    public function getReturnReceiver()
    {
        return $this->ReturnReceiver;
    }

    /**
     * @param ShipperType $ReturnReceiver
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Shipment
     */
    public function setReturnReceiver($ReturnReceiver)
    {
        $this->ReturnReceiver = $ReturnReceiver;
        return $this;
    }

    /**
     * @return ExportDocumentType
     */
    public function getExportDocument()
    {
        return $this->ExportDocument;
    }

    /**
     * @param ExportDocumentType $ExportDocument
     *
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Shipment
     */
    public function setExportDocument($ExportDocument)
    {
        $this->ExportDocument = $ExportDocument;
        return $this;
    }

}
