<?php
/**
 * Dhl Shipping
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * PHP version 7
 *
 * @package   Dhl\Shipping
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Webservice\ResponseParser;

use Dhl\Shipping\Webservice\Schema\Bcs\CreationState;
use Dhl\Shipping\Webservice\Schema\Bcs\DeletionState;
use Dhl\Shipping\Webservice\Exception\CreateShipmentStatusException;
use Dhl\Shipping\Webservice\Exception\DeleteShipmentStatusException;
use Dhl\Shipping\Webservice\ResponseType\CreateShipment\LabelInterface;
use Dhl\Shipping\Webservice\ResponseType\Generic\ItemStatusInterface;
use Dhl\Shipping\Webservice\ResponseType\Generic\ResponseStatusInterface;
use Dhl\Shipping\Webservice\ResponseType\DeleteShipmentResponseCollection;

/**
 * Geschäftskunden API response parser
 *
 * @package  Dhl\Shipping
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 *
 * @SuppressWarnings(MEQP2.Classes.ObjectInstantiation)
 */
class BcsResponseParser implements BcsResponseParserInterface
{
    /**
     * @var LabelFactory
     */
    private $labelFactory;

    /**
     * @var ItemStatusFactory
     */
    private $itemStatusFactory;

    /**
     * BcsResponseParser constructor.
     *
     * @param LabelFactory      $labelFactory
     * @param ItemStatusFactory $itemStatusFactory
     */
    public function __construct(
        LabelFactory $labelFactory,
        ItemStatusFactory $itemStatusFactory
    ) {
        $this->labelFactory = $labelFactory;
        $this->itemStatusFactory = $itemStatusFactory;
    }

    /**
     * @param string $bcsCode
     *
     * @return int
     */
    private function getStatusCode($bcsCode)
    {
        if ($bcsCode == '0') {
            return ResponseStatusInterface::STATUS_SUCCESS;
        }

        return ResponseStatusInterface::STATUS_FAILURE;
    }

    /**
     * Convert BCS SOAP response to list of generic LabelInterface
     *
     * @param \Dhl\Shipping\Webservice\Schema\Bcs\CreateShipmentOrderResponse $response
     *
     * @return LabelInterface[]
     * @throws CreateShipmentStatusException
     */
    public function parseCreateShipmentResponse($response)
    {
        $labels = [];
        $responseStatus = $this->getStatusCode($response->getStatus()->getStatusCode());

        if ($responseStatus !== ResponseStatusInterface::STATUS_SUCCESS) {
            //TODO(nr): check API behaviour with partially created items
            throw CreateShipmentStatusException::create($response);
        }

        /** @var CreationState $creationState */
        foreach ($response->getCreationState() as $creationState) {
            $label = $this->labelFactory->create(
                $creationState->getSequenceNumber(),
                $this->getStatusCode($creationState->getLabelData()->getStatus()->getStatusCode()),
                $creationState->getLabelData()->getStatus()->getStatusText(),
                $creationState->getLabelData()->getStatus()->getStatusMessage(),
                $creationState->getLabelData()->getShipmentNumber(),
                $creationState->getLabelData()->getLabelData(),
                $creationState->getLabelData()->getReturnLabelData(),
                $creationState->getLabelData()->getExportLabelData(),
                $creationState->getLabelData()->getCodLabelData()
            );

            $labels[(string) $creationState->getSequenceNumber()] = $label;
        }

        return $labels;
    }

    /**
     * Convert BCS SOAP response to generic GetVersionResponse
     *
     * @param \Dhl\Shipping\Webservice\Schema\Bcs\GetVersionResponse $response
     *
     * @return GetVersionResponseInterface
     */
    public function parseGetVersionResponse($response)
    {
        // TODO(nr): Implement parseGetVersionResponse() method.
    }

    /**
     * Convert BCS SOAP response to list of generic ItemStatus objects
     *
     * @param \Dhl\Shipping\Webservice\Schema\Bcs\DeleteShipmentOrderResponse $response
     *
     * @return ItemStatusInterface[]
     * @throws DeleteShipmentStatusException
     */
    public function parseDeleteShipmentResponse($response)
    {
        $items = [];
        $responseStatus = $this->getStatusCode($response->getStatus()->getStatusCode());

        if ($responseStatus !== ResponseStatusInterface::STATUS_SUCCESS) {
            throw DeleteShipmentStatusException::create($response);
        }

        /** @var DeletionState $deletionState */
        foreach ($response->getDeletionState() as $deletionState) {
            /** @var DeleteShipmentResponseCollection $item */
            $item = $this->itemStatusFactory->create(
                $deletionState->getShipmentNumber(),
                $deletionState->getStatus()->getStatusCode(),
                $deletionState->getStatus()->getStatusText(),
                $deletionState->getStatus()->getStatusMessage()
            );
            $items[$deletionState->getShipmentNumber()] = $item;
        }
        return $items;
    }
}
