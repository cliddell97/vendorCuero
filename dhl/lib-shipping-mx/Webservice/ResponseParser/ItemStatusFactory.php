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
 * @author    Max Melzer <max.melzer@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Webservice\ResponseParser;

use Dhl\Shipping\Webservice\ResponseType\Generic\ItemStatus;

/**
 * Geschäftskunden API response parser
 *
 * @package  Dhl\Shipping
 * @author   Max Melzer <max.melzer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 *
 * @SuppressWarnings(MEQP2.Classes.ObjectInstantiation)
 */
class ItemStatusFactory
{
    /**
     * @param string $identifier
     * @param int    $statusCode
     * @param string $statusText
     * @param string $statusMessage
     *
     * @return ItemStatus
     */
    public function create(
        $identifier,
        $statusCode,
        $statusText,
        $statusMessage
    ) {
        $item = new ItemStatus(
            $identifier,
            $statusCode,
            $statusText,
            $statusMessage
        );

        return $item;
    }
}
