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
 * @author    Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

namespace Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\Package;

use Dhl\Shipping\Webservice\RequestType\Generic\Package\WeightInterface;
use Dhl\Shipping\Webservice\RequestType\Generic\Package\MonetaryValueInterface;

/**
 * Platform independent shipment order package
 *
 * @package  Dhl\Shipping
 * @author   Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class PackageItem implements PackageItemInterface
{
    /**
     * @var string
     */
    private $qty;

    /**
     * @var MonetaryValueInterface
     */
    private $customsValue;

    /**
     * @var MonetaryValueInterface
     */
    private $price;

    /**
     * @var string
     */
    private $name;

    /**
     * @var WeightInterface
     */
    private $weight;

    /**
     * @var string
     */
    private $productId;

    /**
     * @var string
     */
    private $orderItemId;

    /**
     * @var string
     */
    private $customsItemDescription;

    /**
     * @var string
     */
    private $tariffNumber;

    /**
     * @var string
     */
    private $itemOriginCountry;

    /**
     * @var string
     */
    private $sku;

    /**
     * PackageItem constructor.
     *
     * @param                 $qty
     * @param                 $price
     * @param                 $name
     * @param WeightInterface $weight
     * @param                 $productId
     * @param                 $orderItemId
     * @param string          $customsItemDescription
     * @param string          $tariffNumber
     * @param string          $itemOriginCountry
     * @param string          $customsValue
     */
    public function __construct(
        $qty,
        MonetaryValueInterface $price,
        $name,
        WeightInterface $weight,
        $productId,
        $orderItemId,
        MonetaryValueInterface $customsValue,
        $customsItemDescription = '',
        $tariffNumber = '',
        $itemOriginCountry = '',
        $sku = ''
    ) {
        $this->qty = $qty;
        $this->customsValue = $customsValue;
        $this->customsItemDescription = $customsItemDescription;
        $this->price = $price;
        $this->name = $name;
        $this->weight = $weight;
        $this->productId = $productId;
        $this->orderItemId = $orderItemId;
        $this->tariffNumber = $tariffNumber;
        $this->itemOriginCountry = $itemOriginCountry;
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @return MonetaryValueInterface|string
     */
    public function getCustomsValue()
    {
        return $this->customsValue;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return MonetaryValueInterface
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return WeightInterface
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getOrderItemId()
    {
        return $this->orderItemId;
    }

    /**
     * @return string
     */
    public function getCustomsItemDescription()
    {
        return $this->customsItemDescription;
    }

    /**
     * @return string
     */
    public function getItemOriginCountry()
    {
        return $this->itemOriginCountry;
    }

    /**
     * @return string
     */
    public function getTariffNumber()
    {
        return $this->tariffNumber;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }
}
