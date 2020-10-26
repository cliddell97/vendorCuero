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
 * @category  Dhl
 * @package   Dhl\Shipping
 * @author    Max Melzer <max.melzer@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

namespace Dhl\Shipping\Api\Data;

/**
 * Service data comprises metadata about each service and about relationships between them.
 *
 * @package Dhl\Shipping\Api
 */
interface ServiceInformationInterface
{
    /**
     * Service metadata like rendering information and validation rules.
     *
     * @return \Dhl\Shipping\Api\Data\ServiceInterface[]
     */
    public function getServices();

    /**
     * Compatibility information between services.
     *
     * @return \Dhl\Shipping\Api\Data\ServiceCompatibilityInterface[]
     */
    public function getCompatibility();

    /**
     * Shipping methods to be processed with DHL.
     *
     * @return string[]
     */
    public function getMethods();
}
