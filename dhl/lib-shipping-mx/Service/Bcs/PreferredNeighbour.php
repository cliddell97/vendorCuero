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
 * DHL Business Customer Shipping Preferred Neighbour Service
 *
 * @package  Dhl\Shipping\Service
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class PreferredNeighbour extends AbstractService
{
    const CODE = 'preferredNeighbour';

    const PROPERTY_DETAILS = 'details';

    const PROPERTY_NAME = 'name';

    const PROPERTY_ADDRESS = 'address';

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
        $result = [];

        $this->serviceInputBuilder->setCode(self::PROPERTY_NAME);
        $this->serviceInputBuilder->setInputType(ServiceInputInterface::INPUT_TYPE_TEXT);
        $this->serviceInputBuilder->setInfoText($this->serviceConfig->getInfoText());
        $this->serviceInputBuilder->setPlaceholder('First name, last name of neighbour');
        $this->serviceInputBuilder->setValidationRules([
            'minLength'                => 1,
            'maxLength'                => 40,
            'validate-no-html-tags'    => true,
            'dhl_filter_special_chars' => true,
        ]);
        $this->serviceInputBuilder->setLabel('Preferred neighbour: Delivery to a neighbour of your choice');
        $this->serviceInputBuilder->setTooltip(
            'Determine a person in your immediate neighborhood to whom we can hand out your parcel in your absence. This person should live in the same building, directly opposite, or next door.'
        );
        if (isset($this->serviceConfig->getProperties()[self::PROPERTY_NAME])) {
            $this->serviceInputBuilder->setValue($this->serviceConfig->getProperties()[self::PROPERTY_NAME]);
        }
        $result[] = $this->serviceInputBuilder->create();

        $this->serviceInputBuilder->setCode(self::PROPERTY_ADDRESS);
        $this->serviceInputBuilder->setInputType(ServiceInputInterface::INPUT_TYPE_TEXT);
        $this->serviceInputBuilder->setPlaceholder('Street, number, postal code, city');
        $this->serviceInputBuilder->setValidationRules([
            'minLength'                => 1,
            'maxLength'                => 40,
            'validate-no-html-tags'    => true,
            'dhl_filter_special_chars' => true,
        ]);
        if (isset($this->serviceConfig->getProperties()[self::PROPERTY_ADDRESS])) {
            $this->serviceInputBuilder->setValue($this->serviceConfig->getProperties()[self::PROPERTY_ADDRESS]);
        }
        $result[] = $this->serviceInputBuilder->create();

        return $result;
    }

    /**
     * The details property is a virtual property made up of the name and address properties.
     *
     * @return string
     */
    public function getDetails()
    {
        $details = [];
        $properties = $this->serviceConfig->getProperties();
        if (isset($properties[self::PROPERTY_NAME])) {
            $details[] = $properties[self::PROPERTY_NAME];
        }
        if (isset($properties[self::PROPERTY_ADDRESS])) {
            $details[] = $properties[self::PROPERTY_ADDRESS];
        }

        return implode(' ', $details);
    }
}
