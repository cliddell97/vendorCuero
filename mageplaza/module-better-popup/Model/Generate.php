<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_BetterPopup
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\BetterPopup\Model;

use DateTimeInterface;
use Exception;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Math\Random;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Model\CouponFactory;
use Magento\SalesRule\Model\Data\Rule;
use Magento\SalesRule\Model\ResourceModel\Coupon;
use Magento\SalesRule\Model\RuleRepository;
use Psr\Log\LoggerInterface;

/**
 * Class Generate
 * @package Mageplaza\BetterPopup\Model
 */
class Generate
{
    /**
     * @var Coupon
     */
    protected $_couponResource;

    /**
     * @var CouponFactory
     */
    protected $_couponFactory;

    /**
     * @var RuleRepository
     */
    protected $ruleRepository;

    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $dateTime;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var Random
     */
    protected $_mathRandom;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Generate constructor.
     *
     * @param Coupon $couponResource
     * @param CouponFactory $couponFactory
     * @param RuleRepository $ruleRepository
     * @param DateTime $date
     * @param \Magento\Framework\Stdlib\DateTime $dateTime
     * @param Random $mathRandom
     * @param ManagerInterface $messageManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        Coupon $couponResource,
        CouponFactory $couponFactory,
        RuleRepository $ruleRepository,
        DateTime $date,
        \Magento\Framework\Stdlib\DateTime $dateTime,
        Random $mathRandom,
        ManagerInterface $messageManager,
        LoggerInterface $logger
    ) {
        $this->_couponResource = $couponResource;
        $this->_couponFactory  = $couponFactory;
        $this->ruleRepository  = $ruleRepository;
        $this->date            = $date;
        $this->dateTime        = $dateTime;
        $this->_mathRandom     = $mathRandom;
        $this->messageManager  = $messageManager;
        $this->logger          = $logger;
    }

    /**
     * @param array $data
     *
     * @return string|string[]|null
     * @throws LocalizedException
     */
    public function generateCoupon($data)
    {
        if (!isset($data['rule_id'])) {
            throw new LocalizedException(__('Rule is not valid'));
        }

        try {
            $rule    = $this->getRule($data['rule_id']);
            $pattern = !empty($data['coupon_pattern']) ? $data['coupon_pattern'] : '[12AN]';
            $pattern = strtoupper(str_replace(' ', '', $pattern));
            $code    = $pattern;

            /** @var $coupon \Magento\SalesRule\Model\Coupon */
            $coupon        = $this->_couponFactory->create();
            $nowTimestamp  = $this->dateTime->formatDate($this->date->gmtTimestamp());
            $patternString = '#\[(\d+)([AN]{1,2})\]#';
            if (preg_match($patternString, $pattern)) {
                $code = preg_replace_callback($patternString, function ($param) {
                    $pool = strpos($param[2], 'A') === false ? '' : Random::CHARS_UPPERS;
                    $pool .= strpos($param[2], 'N') === false ? '' : Random::CHARS_DIGITS;

                    return $this->_mathRandom->getRandomString($param[1], $pool);
                }, $pattern);
            }

            $expirationDate = $rule->getToDate();
            if ($expirationDate instanceof DateTimeInterface) {
                $expirationDate = $expirationDate->format('Y-m-d H:i:s');
            }

            $coupon->setId(null)
                ->setRuleId($rule->getRuleId())
                ->setUsageLimit($rule->getUsesPerCoupon())
                ->setUsagePerCustomer($rule->getUsesPerCustomer())
                ->setExpirationDate($expirationDate)
                ->setCreatedAt($nowTimestamp)
                ->setType(\Magento\SalesRule\Helper\Coupon::COUPON_TYPE_SPECIFIC_AUTOGENERATED)
                ->setCode($code)
                ->save();

            return $code;
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error occurred when generating coupons: %1', $e->getMessage()));
        }
    }

    /**
     * @param $ruleId
     *
     * @return RuleInterface|Rule
     */
    public function getRule($ruleId)
    {
        try {
            return $this->ruleRepository->getById($ruleId);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Error occurred when generating coupons: %1', $e->getMessage()));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage(__('Rule is not valid'));
        }
    }
}