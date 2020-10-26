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
 * @package   Dhl\Shipping\Webservice
 * @author    Christoph Aßmann <christoph.assmann@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

namespace Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\Service;

/**
 * Generic service factory
 *
 * @package  Dhl\Shipping\Webservice
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
abstract class AbstractServiceFactory
{
    const SERVICE_CODE_COD                    = 'cod';
    const SERVICE_CODE_BULKY_GOODS            = 'bulkyGoods';
    const SERVICE_CODE_PARCEL_ANNOUNCEMENT    = 'parcelAnnouncement';
    const SERVICE_CODE_INSURANCE              = 'additionalInsurance';
    const SERVICE_CODE_VISUAL_CHECK_OF_AGE    = 'visualCheckOfAge';
    const SERVICE_CODE_RETURN_SHIPMENT        = 'returnShipment';
    const SERVICE_CODE_PRINT_ONLY_IF_CODEABLE = 'printOnlyIfCodeable';

    /**
     * @param string  $instanceCode
     * @param mixed[] $data
     *
     * @return ServiceInterface
     */
    abstract public function create($instanceCode, array $data = []);
}