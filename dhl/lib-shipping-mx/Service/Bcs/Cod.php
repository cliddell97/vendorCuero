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

namespace Dhl\Shipping\Service\Bcs;

use Dhl\Shipping\Api\Data\ServiceInputInterface;
use Dhl\Shipping\Service\AbstractService;
use Dhl\Shipping\Util\ShippingRoutes\RoutesInterface;

/**
 * DHL Business Customer Shipping Cash On Delivery Service
 *
 * @package  Dhl\Shipping\Service
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class Cod extends AbstractService
{
    const CODE = 'bcs_cod';

    const PROPERTY_AMOUNT        = 'amount';
    const PROPERTY_CURRENCY_CODE = 'currency_code';
    const PROPERTY_ADD_FEE       = 'add_fee';

    /**
     * @var bool
     */
    protected $postalFacilitySupport = true;

    /**
     * Service can be booked on these routes.
     *
     * @var string[][]
     */
    protected $routes = [
        'DE' => [
            'included' => [RoutesInterface::COUNTRY_CODE_GERMANY],
            'excluded' => [],
        ],
        'AT' => [
            'included' => [RoutesInterface::COUNTRY_CODE_AUSTRIA],
            'excluded' => [],
        ],
    ];

    /**
     * @return ServiceInputInterface[]
     */
    protected function createInputs()
    {
        $this->serviceInputBuilder->setCode(self::PROPERTY_AMOUNT);
        $this->serviceInputBuilder->setInputType(ServiceInputInterface::INPUT_TYPE_NUMBER);
        if (isset($this->serviceConfig->getProperties()[self::PROPERTY_AMOUNT])) {
            $this->serviceInputBuilder->setValue($this->serviceConfig->getProperties()[self::PROPERTY_AMOUNT]);
        }
        $amountInput = $this->serviceInputBuilder->create();

        $this->serviceInputBuilder->setCode(self::PROPERTY_CURRENCY_CODE);
        $this->serviceInputBuilder->setInputType(ServiceInputInterface::INPUT_TYPE_TEXT);
        if (isset($this->serviceConfig->getProperties()[self::PROPERTY_CURRENCY_CODE])) {
            $this->serviceInputBuilder->setValue($this->serviceConfig->getProperties()[self::PROPERTY_CURRENCY_CODE]);
        }
        $currencyCodeInput = $this->serviceInputBuilder->create();

        $this->serviceInputBuilder->setCode(self::PROPERTY_ADD_FEE);
        $this->serviceInputBuilder->setInputType(ServiceInputInterface::INPUT_TYPE_CHECKBOX);
        if (isset($this->serviceConfig->getProperties()[self::PROPERTY_ADD_FEE])) {
            $this->serviceInputBuilder->setValue($this->serviceConfig->getProperties()[self::PROPERTY_ADD_FEE]);
        }
        $addFeeInput = $this->serviceInputBuilder->create();
        return [$amountInput, $currencyCodeInput, $addFeeInput];
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        $properties = $this->serviceConfig->getProperties();
        if (isset($properties[self::PROPERTY_AMOUNT])) {
            return (float) $properties[self::PROPERTY_AMOUNT];
        }

        return 0;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        $properties = $this->serviceConfig->getProperties();
        if (isset($properties[self::PROPERTY_CURRENCY_CODE])) {
            return $properties[self::PROPERTY_CURRENCY_CODE];
        }

        return 'EUR';
    }

    /**
     * @return bool
     */
    public function isAddFee()
    {
        $properties = $this->serviceConfig->getProperties();
        if (isset($properties[self::PROPERTY_ADD_FEE])) {
            return (bool) $properties[self::PROPERTY_ADD_FEE];
        }

        return false;
    }
}
