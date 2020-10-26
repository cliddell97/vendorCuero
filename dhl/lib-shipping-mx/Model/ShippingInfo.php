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
 * @package   Dhl\Shipping\Model
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Model;

use Dhl\Shipping\Api\Data\ShippingInfo\ReceiverInterface;
use Dhl\Shipping\Api\Data\ShippingInfo\ServiceInterface;
use Dhl\Shipping\Api\Data\ShippingInfoInterface;

/**
 * ShippingInfo
 *
 * @package  Dhl\Shipping\Model
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class ShippingInfo implements ShippingInfoInterface, \JsonSerializable
{
    /**
     * @var string
     */
    private $schemaVersion;

    /**
     * @var ReceiverInterface
     */
    private $receiver;

    /**
     * @var ServiceInterface[]
     */
    private $services;

    /**
     * ShippingInfo constructor.
     *
     * @param string             $schemaVersion
     * @param ReceiverInterface  $receiver
     * @param ServiceInterface[] $services
     */
    public function __construct($schemaVersion, ReceiverInterface $receiver, array $services = [])
    {
        $this->schemaVersion = $schemaVersion;
        $this->receiver = $receiver;
        $this->services = $services;
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return $this->schemaVersion;
    }

    /**
     * @return ReceiverInterface
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @return ServiceInterface[]
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @return string[]
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
