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
 * DHL Business Customer Shipping Preferred Time Service
 *
 * @package  Dhl\Shipping\Service
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class PreferredTime extends AbstractService
{
    const CODE = 'preferredTime';

    const PROPERTY_TIME = 'time';

    /**
     * @var bool
     */
    protected $postalFacilitySupport = false;

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
    ];

    /**
     * @return ServiceInputInterface[]
     */
    protected function createInputs()
    {
        $this->serviceInputBuilder->setCode(self::PROPERTY_TIME);
        $this->serviceInputBuilder->setInputType(ServiceInputInterface::INPUT_TYPE_TIME);
        $this->serviceInputBuilder->setOptions($this->serviceConfig->getOptions());
        $this->serviceInputBuilder->setInfoText($this->serviceConfig->getInfoText());
        $this->serviceInputBuilder->setHasAsterisk($this->serviceConfig->hasAsterisk());
        $this->serviceInputBuilder->setLabel('Preferred Time: Delivery during your preferred time slot');
        $this->serviceInputBuilder->setTooltip(
            'Indicate a preferred time for your parcel delivery by choosing one of the displayed time windows.'
        );
        if (isset($this->serviceConfig->getProperties()[self::PROPERTY_TIME])) {
            $this->serviceInputBuilder->setValue($this->serviceConfig->getProperties()[self::PROPERTY_TIME]);
        }

        return [$this->serviceInputBuilder->create()];
    }

    /**
     * @return string
     */
    public function getTime()
    {
        $properties = $this->serviceConfig->getProperties();
        if (isset($properties[self::PROPERTY_TIME])) {
            return $properties[self::PROPERTY_TIME];
        }

        return '';
    }
}
