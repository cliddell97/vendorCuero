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
 * @package   Dhl\Shipping\Api\Data
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Api\Data\ShippingInfo;

use Dhl\Shipping\Api\Data\ShippingInfo\Receiver\ContactInterface;
use Dhl\Shipping\Api\Data\ShippingInfo\Receiver\AddressInterface;
use Dhl\Shipping\Api\Data\ShippingInfo\Receiver\PackstationInterface;
use Dhl\Shipping\Api\Data\ShippingInfo\Receiver\PostfilialeInterface;
use Dhl\Shipping\Api\Data\ShippingInfo\Receiver\ParcelShopInterface;

/**
 * ReceiverInterface
 *
 * @package  Dhl\Shipping\Api\Data
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
interface ReceiverInterface
{
    const CONTACT     = 'contact';
    const ADDRESS     = 'address';
    const PACKSTATION = 'packstation';
    const POSTFILIALE = 'postfiliale';
    const PARCEL_SHOP = 'parcelShop';

    /**
     * @return ContactInterface
     */
    public function getContact();

    /**
     * @return AddressInterface
     */
    public function getAddress();

    /**
     * @return PackstationInterface
     */
    public function getPackstation();

    /**
     * @return PostfilialeInterface
     */
    public function getPostfiliale();

    /**
     * @return ParcelShopInterface
     */
    public function getParcelShop();
}
