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

namespace Dhl\Shipping\Webservice;

use Dhl\Shipping\Api\ServiceCollectionInterface;
use Dhl\Shipping\Service\Bcs\BulkyGoods;
use Dhl\Shipping\Service\Bcs\Cod;
use Dhl\Shipping\Service\Bcs\Insurance;
use Dhl\Shipping\Service\Bcs\ParcelAnnouncement;
use Dhl\Shipping\Service\Bcs\PreferredDay;
use Dhl\Shipping\Service\Bcs\PreferredLocation;
use Dhl\Shipping\Service\Bcs\PreferredNeighbour;
use Dhl\Shipping\Service\Bcs\PreferredTime;
use Dhl\Shipping\Service\Bcs\ReturnShipment;
use Dhl\Shipping\Service\Bcs\VisualCheckOfAge;
use Dhl\Shipping\Webservice\RequestMapper\BcsDataMapperInterface;
use Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\Contact;
use Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\Package\PackageItemInterface;
use Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrder\PackageInterface;
use Dhl\Shipping\Webservice\RequestType\CreateShipment\ShipmentOrderInterface;
use Dhl\Shipping\Webservice\RequestType\GetVersionRequestInterface;
use Dhl\Shipping\Webservice\Schema\Bcs as BcsApi;

/**
 * BcsDataMapper
 *
 * @package  Dhl\Shipping\Webservice
 * @author   Christoph Aßmann <christoph.assmann@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 *
 * @todo(nr): move to lib if possible
 * @SuppressWarnings(MEQP2.Classes.ObjectInstantiation)
 */
class BcsDataMapper implements BcsDataMapperInterface
{
    /**
     * @param ShipmentOrderInterface $shipmentOrder
     * @return BcsApi\ShipmentDetailsTypeType
     */
    private function getShipmentDetails(ShipmentOrderInterface $shipmentOrder)
    {
        $shipmentDetails = $shipmentOrder->getShipmentDetails();
        $packages = $shipmentOrder->getPackages();
        // bcs cannot handle multiple packages
        $package = current($packages);

        $packageWeight = $package->getWeight()->getValue(\Zend_Measure_Weight::KILOGRAM);
        $shipmentItemType = new BcsApi\ShipmentItemType($packageWeight);
        $shipmentItemType->setWidthInCM($package->getDimensions()->getWidth(\Zend_Measure_Length::CENTIMETER));
        $shipmentItemType->setHeightInCM($package->getDimensions()->getHeight(\Zend_Measure_Length::CENTIMETER));
        $shipmentItemType->setLengthInCM($package->getDimensions()->getLength(\Zend_Measure_Length::CENTIMETER));

        $shipmentDetailsType = new BcsApi\ShipmentDetailsTypeType(
            $shipmentDetails->getProduct(),
            $shipmentDetails->getAccountNumber(),
            $shipmentDetails->getShipmentDate(), // TODO(nr): convert to CET
            $shipmentItemType
        );
        $shipmentDetailsType->setCustomerReference($shipmentDetails->getReference());
        $shipmentDetailsType->setReturnShipmentReference($shipmentDetails->getReturnShipmentReference());

        $bankData = new BcsApi\BankType(
            $shipmentDetails->getBankData()->getAccountOwner(),
            $shipmentDetails->getBankData()->getBankName(),
            $shipmentDetails->getBankData()->getIban()
        );
        // note1, note2, bic, accountreference
        $notes = $shipmentDetails->getBankData()->getNotes();
        $bankData->setNote1(isset($notes[0]) ? $notes[0] : null);
        $bankData->setNote2(isset($notes[1]) ? $notes[1] : null);
        $bankData->setBic($shipmentDetails->getBankData()->getBic());
        $bankData->setAccountreference($shipmentDetails->getBankData()->getAccountReference());
        $shipmentDetailsType->setBankData($bankData);

        if (array_key_exists(ReturnShipment::CODE, $shipmentOrder->getServices())) {
            $shipmentDetailsType->setReturnShipmentAccountNumber(
                $shipmentOrder->getShipmentDetails()->getReturnShipmentAccountNumber()
            );
        }

        return $shipmentDetailsType;
    }

    /**
     * @param ServiceCollectionInterface $services
     * @return BcsApi\ShipmentService
     */
    private function getServices(ServiceCollectionInterface $services)
    {
        //@TODO(PSI): find a more elegant way
        $serviceType = new BcsApi\ShipmentService();

        if (array_key_exists(Cod::CODE, $services)) {
            /** @var Cod $codService */
            $codService = $services[Cod::CODE];
            $codConfig = new BcsApi\ServiceconfigurationCashOnDelivery(
                true,
                $codService->isAddFee(),
                round($codService->getAmount(), 2)
            );
            $serviceType->setCashOnDelivery($codConfig);
        };
        if (array_key_exists(BulkyGoods::CODE, $services)) {
            $bulkyGoodsConfig = new BcsApi\Serviceconfiguration(
                true
            );
            $serviceType->setBulkyGoods($bulkyGoodsConfig);
        }
        if (array_key_exists(Insurance::CODE, $services)) {
            /** @var Insurance $insuranceService */
            $insuranceService = $services[Insurance::CODE];
            $insuranceConfig = new BcsApi\ServiceconfigurationAdditionalInsurance(
                true,
                round($insuranceService->getAmount(), 2)
            );
            $serviceType->setAdditionalInsurance($insuranceConfig);
        }

        if (array_key_exists(VisualCheckOfAge::CODE, $services)) {
            /** @var VisualCheckOfAge $ageCheckService */
            $ageCheckService = $services[VisualCheckOfAge::CODE];
            $visualCheckOfAgeConfig = new BcsApi\ServiceconfigurationVisualAgeCheck(
                true,
                $ageCheckService->getAge()
            );
            $serviceType->setVisualCheckOfAge($visualCheckOfAgeConfig);
        }
        if (array_key_exists(PreferredTime::CODE, $services)) {
            /** @var PreferredTime $preferredTimeService */
            $preferredTimeService = $services[PreferredTime::CODE];
            $preferredTimeConfig = new BcsApi\ServiceconfigurationDeliveryTimeframe(
                true,
                $preferredTimeService->getTime()
            );
            $serviceType->setPreferredTime($preferredTimeConfig);
        }
        if (array_key_exists(PreferredDay::CODE, $services)) {
            /** @var PreferredDay $preferredDayService */
            $preferredDayService = $services[PreferredDay::CODE];
            $preferredDayConfig = new BcsApi\ServiceconfigurationDateOfDelivery(
                true,
                $preferredDayService->getDate()
            );
            $serviceType->setPreferredDay($preferredDayConfig);
        }
        if (array_key_exists(PreferredNeighbour::CODE, $services)) {
            /** @var PreferredNeighbour $preferredNeighbour */
            $preferredNeighbour = $services[PreferredNeighbour::CODE];
            $preferredNeighbourConfig = new BcsApi\ServiceconfigurationDetails(
                true,
                $preferredNeighbour->getDetails()
            );
            $serviceType->setPreferredNeighbour($preferredNeighbourConfig);
        }
        if (array_key_exists(PreferredLocation::CODE, $services)) {
            /** @var PreferredLocation $preferredLocation */
            $preferredLocation = $services[PreferredLocation::CODE];
            $preferredLocationConfig = new BcsApi\ServiceconfigurationDetails(
                true,
                $preferredLocation->getDetails()
            );
            $serviceType->setPreferredLocation($preferredLocationConfig);
        }

        return $serviceType;
    }

    /**
     * @param Contact\ShipperInterface $shipper
     * @return BcsApi\ShipperType
     */
    private function getShipper(Contact\ShipperInterface $shipper)
    {
        // shipper name
        $nameType = new BcsApi\NameType(
            $shipper->getCompanyName(),
            $shipper->getNameAddition(),
            null
        );

        // shipper address
        $countryType = new BcsApi\CountryType($shipper->getAddress()->getCountryCode());
        $countryType->setCountry($shipper->getAddress()->getCountryCode());
        $countryType->setState($shipper->getAddress()->getState());
        $addressType = new BcsApi\NativeAddressType(
            $shipper->getAddress()->getStreetName(),
            $shipper->getAddress()->getStreetNumber(),
            $shipper->getAddress()->getPostalCode(),
            $shipper->getAddress()->getCity(),
            $countryType
        );

        // shipper communication
        $communicationType = new BcsApi\CommunicationType();
        $communicationType->setContactPerson($shipper->getContactPerson());
        $communicationType->setEmail($shipper->getEmail());
        $communicationType->setPhone($shipper->getPhone());

        $shipperType = new BcsApi\ShipperType($nameType, $addressType, $communicationType);

        return $shipperType;
    }

    /**
     * @param ShipmentOrderInterface $shipmentOrder
     * @return BcsApi\ReceiverType
     */
    private function getReceiver(ShipmentOrderInterface $shipmentOrder)
    {
        $receiver = $shipmentOrder->getReceiver();
        if ($receiver->getPackstation()) {
            $countryType = new BcsApi\CountryType($receiver->getPackstation()->getCountryCode());
            $countryType->setCountry($receiver->getPackstation()->getCountry());
            $countryType->setState($receiver->getPackstation()->getState());

            $packstationType = new BcsApi\PackStationType(
                $receiver->getPackstation()->getPackstationNumber(),
                $receiver->getPackstation()->getZip(),
                $receiver->getPackstation()->getCity(),
                $countryType
            );
            $packstationType->setPostNumber($receiver->getPackstation()->getPostNumber());

            // void other address types
            $addressType = null;
            $postfilialeType = null;
            $parcelShopType = null;
        } elseif ($receiver->getPostfiliale()) {
            $countryType = new BcsApi\CountryType($receiver->getPostfiliale()->getCountryCode());
            $countryType->setCountry($receiver->getPostfiliale()->getCountry());
            $countryType->setState($receiver->getPostfiliale()->getState());

            $postfilialeType = new BcsApi\PostfilialeType(
                $receiver->getPostfiliale()->getPostfilialNumber(),
                $receiver->getPostfiliale()->getPostNumber(),
                $receiver->getPostfiliale()->getZip(),
                $receiver->getPostfiliale()->getCity(),
                $countryType
            );

            // void other address types
            $addressType = null;
            $packstationType = null;
            $parcelShopType = null;
        } elseif ($receiver->getParcelShop()) {
            $countryType = new BcsApi\CountryType($receiver->getParcelShop()->getCountryCode());
            $countryType->setCountry($receiver->getParcelShop()->getCountry());
            $countryType->setState($receiver->getParcelShop()->getState());

            $parcelShopType = new BcsApi\ParcelShopType(
                $receiver->getParcelShop()->getParcelShopNumber(),
                $receiver->getParcelShop()->getZip(),
                $receiver->getParcelShop()->getCity(),
                $countryType
            );
            $parcelShopType->setStreetName($receiver->getParcelShop()->getStreetName());
            $parcelShopType->setStreetNumber($receiver->getParcelShop()->getStreetNumber());

            // void other address types
            $addressType = null;
            $packstationType = null;
            $postfilialeType = null;
        } else {
            // receiver address
            $countryType = new BcsApi\CountryType($receiver->getAddress()->getCountryCode());
            $countryType->setCountry($receiver->getAddress()->getCountryCode());
            $countryType->setState($receiver->getAddress()->getState());

            $addressType = new BcsApi\ReceiverNativeAddressType(
                $receiver->getCompanyName(),
                $receiver->getNameAddition(),
                $receiver->getAddress()->getStreetName(),
                $receiver->getAddress()->getStreetNumber(),
                $receiver->getAddress()->getPostalCode(),
                $receiver->getAddress()->getCity(),
                $countryType
            );
            $addressType->setAddressAddition([$receiver->getAddress()->getAddressAddition()]);

            // void other address types
            $packstationType = null;
            $postfilialeType = null;
            $parcelShopType = null;
        }

        // receiver communication
        $communicationType = new BcsApi\CommunicationType();
        $communicationType->setContactPerson($receiver->getContactPerson());
        if (array_key_exists(ParcelAnnouncement::CODE, $shipmentOrder->getServices())) {
            $communicationType->setEmail($receiver->getEmail());
        }

        $receiverType = new BcsApi\ReceiverType(
            $receiver->getName(),
            $addressType,
            $packstationType,
            $postfilialeType,
            $parcelShopType,
            $communicationType
        );

        return $receiverType;
    }

    /**
     * @param Contact\ReturnReceiverInterface $returnReceiver
     * @return BcsApi\ShipperType
     */
    private function getReturnReceiver(Contact\ReturnReceiverInterface $returnReceiver)
    {
        // return receiver name
        $nameType = new BcsApi\NameType(
            $returnReceiver->getCompanyName(),
            $returnReceiver->getNameAddition(),
            null
        );

        // return receiver address
        $countryType = new BcsApi\CountryType($returnReceiver->getAddress()->getCountryCode());
        $countryType->setCountry($returnReceiver->getAddress()->getCountryCode());
        $countryType->setState($returnReceiver->getAddress()->getState());

        $addressType = new BcsApi\NativeAddressType(
            $returnReceiver->getAddress()->getStreetName(),
            $returnReceiver->getAddress()->getStreetNumber(),
            $returnReceiver->getAddress()->getPostalCode(),
            $returnReceiver->getAddress()->getCity(),
            $countryType
        );

        // shipper communication
        $communicationType = new BcsApi\CommunicationType();
        $communicationType->setContactPerson($returnReceiver->getContactPerson());
        $communicationType->setEmail($returnReceiver->getEmail());
        $communicationType->setPhone($returnReceiver->getPhone());

        $shipperType = new BcsApi\ShipperType($nameType, $addressType, $communicationType);

        return $shipperType;
    }

    /**
     * @param PackageInterface[] $packages
     * @return BcsApi\ExportDocumentType|null
     */
    private function getExportDocument(
        array $packages
    ) {
        $package = current($packages);
        $exportDocumentType = null;
        if ($package->getExportType()) {
            $exportDocumentType = new BcsApi\ExportDocumentType(
                $package->getExportType(),
                $package->getPlaceOfCommittal(),
                $package->getAdditionalFee()
                        ->getValue('EUR')
            );

            //        $exportDocumentType->setInvoiceNumber($package->getInvoiceNumber());
            $exportDocumentType->setExportTypeDescription($package->getExportTypeDescription());
            $exportDocumentType->setTermsOfTrade($package->getTermsOfTrade());
            $exportDocumentType->setPermitNumber($package->getPermitNumber());
            $exportDocumentType->setAttestationNumber($package->getAttestationNumber());
            $exportDocumentType->setWithElectronicExportNtfctn(
                new BcsApi\Serviceconfiguration($package->isWithExportNotification())
            );

            $exportDocPositions = [];
            /** @var PackageItemInterface $position */
            foreach ($package->getItems() as $position) {
                $exportDocPosition = new BcsApi\ExportDocPosition(
                    $position->getCustomsItemDescription(),
                    $position->getItemOriginCountry(),
                    $position->getTariffNumber(),
                    $position->getQty(),
                    $position->getWeight()
                             ->getValue(\Zend_Measure_Weight::KILOGRAM),
                    $position->getCustomsValue()
                             ->getValue('EUR')
                );
                $exportDocPositions[] = $exportDocPosition;
            }

            $exportDocumentType->setExportDocPosition($exportDocPositions);
        }

        return $exportDocumentType;
    }

    /**
     * Create api specific request object from framework standardized object.
     *
     * @param ShipmentOrderInterface $shipmentOrder
     * @return BcsApi\ShipmentOrderType
     */
    public function mapShipmentOrder(ShipmentOrderInterface $shipmentOrder)
    {
        // account data, package definition, carrier product, additional services
        $shipmentDetailsType = $this->getShipmentDetails(
            $shipmentOrder
        );
        $serviceType = $this->getServices($shipmentOrder->getServices());
        $shipmentDetailsType->setService($serviceType);

        // shipper, receiver, return receiver
        $shipperType = $this->getShipper($shipmentOrder->getShipper());
        $receiverType = $this->getReceiver($shipmentOrder);
        if (array_key_exists(ReturnShipment::CODE, $shipmentOrder->getServices())) {
            $returnReceiverType = $this->getReturnReceiver($shipmentOrder->getReturnReceiver());
        } else {
            $returnReceiverType = null;
        }

        // customs declaration
        $exportDocumentType = $this->getExportDocument($shipmentOrder->getPackages());

        // shipment definition, label format, print only if codeable
        $shipmentType = new BcsApi\Shipment(
            $shipmentDetailsType,
            $shipperType,
            $receiverType,
            $returnReceiverType,
            $exportDocumentType
        );

        $shipmentOrderType = new BcsApi\ShipmentOrderType(
            $shipmentOrder->getSequenceNumber(),
            $shipmentType
        );

        $printOnlyIfCodeable = new BcsApi\Serviceconfiguration(
            $shipmentOrder->getShipmentDetails()->isPrintOnlyIfCodeable()
        );
        $shipmentOrderType->setLabelResponseType('B64');
        $shipmentOrderType->setPrintOnlyIfCodeable($printOnlyIfCodeable);

        return $shipmentOrderType;
    }

    /**
     * Create api specific request object from framework standardized object.
     *
     * @param GetVersionRequestInterface $request
     * @return \Dhl\Shipping\Webservice\Schema\Bcs\Version
     */
    public function mapVersion(GetVersionRequestInterface $request)
    {
        // TODO: Implement mapVersion() method.
    }

    /**
     * Create api specific request object from framework standardized object.
     * TODO(nr): shipment numbers are a simple type, no need to convert something?
     *
     * @param \Dhl\Shipping\Webservice\RequestType\DeleteShipmentRequestInterface[] $numbers
     * @return string[]
     */
    public function mapShipmentNumbers(array $numbers)
    {
        // TODO: Implement mapShipmentNumbers() method.
    }
}
