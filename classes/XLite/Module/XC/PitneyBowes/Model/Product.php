<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\XC\PitneyBowes\Model;

/**
 * The "Product" model repository
 *
 * @HasLifecycleCallbacks
 */
class Product extends \XLite\Model\Product implements \XLite\Base\IDecorator
{
    const CONDITION_NEW = 'N';
    const CONDITION_USED = 'U';
    const CONDITION_REFURBISHED = 'R';
    /**
     * True if product was exported to PB and didn't change after
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $exported_pb = false;

    /**
     * Global Product Code
     *
     * @var string
     *
     * @Column (type="string", length=100, nullable=true)
     */
    protected $gpc;

    /**
     * Global Trade Identification Number
     *
     * @var string
     *
     * @Column (type="string", length=25, nullable=true)
     */
    protected $gtin;

    /**
     * Harmony system code
     *
     * @var string
     *
     * @Column (type="string", length=6, nullable=true)
     */
    protected $hs_code;

    /**
     * Manufacturer part number
     *
     * @var string
     *
     * @Column (type="string", length=100, nullable=true)
     */
    protected $mpn;

    /**
     * Manufacturer model number
     *
     * @var string
     *
     * @Column (type="string", length=200, nullable=true)
     */
    protected $model_number;

    /**
     * Manufacturer stock number
     *
     * @var string
     *
     * @Column (type="string", length=100, nullable=true)
     */
    protected $stock_number;

    /**
     * Does contain hazardous materials?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $hazmat;

    /**
     * Does contain chemicals?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $chemicals;

    /**
     * Does contain pesticide?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $pesticide;


    /**
     * Does contain aerosol?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $aerosol;

    /**
     * Does contain plastic container?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $rppc;

    /**
     * Does contain non spillable battery?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $non_spillable;

    /**
     * Can contain fuel?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $fuel;

    /**
     * Does contain orm-d?
     *
     * @var string
     *
     * @Column (type="boolean", nullable=true)
     */
    protected $ormd;

    /**
     * Battery type
     *
     * @var string
     *
     * @Column (type="string", length=100, nullable=true)
     */
    protected $battery;

    /**
     * Condition
     *
     * @var string
     *
     * @Column (type="string", length=1, nullable=true)
     */
    protected $product_condition;

    /**
     * Country of origin
     *
     * @var \XLite\Model\Country
     *
     * @ManyToOne  (targetEntity="XLite\Model\Country")
     * @JoinColumn (name="country_code", referencedColumnName="code")
     */
    protected $country_of_origin;

    /**
     * restrictions
     *
     * @var \Doctrine\Common\Collections\Collection
     *
     * @OneToMany (targetEntity="XLite\Module\XC\PitneyBowes\Model\ProductRestriction", mappedBy="product", cascade={"all"})
     * @OrderBy   ({"id" = "ASC"})
     */
    protected $restrictions;

    /**
     * Is restricted
     * 
     * @var boolean
     */
    protected $isRestricted = null;

    /**
     * Shipping address
     * @var \XLite\Model\Address
     */
    protected static $shippingAddress;

    /**
     * Prepare update date
     *
     * @return void
     *
     * @PreUpdate
     */
    public function prepareBeforeUpdate()
    {
        if (0 < func_num_args()) {
            $event = func_get_arg(0); // PreUpdateEventArgs $event
            if ($event && !$event->hasChangedField('exported_pb')) {
                $this->setExportedPb(false);
            }
        }

        parent::prepareBeforeUpdate();
    }

    /**
     * Check product availability for public usage (customer interface)
     *
     * @return boolean
     */
    public function isPublicAvailable()
    {
        return parent::isPublicAvailable()
            && !$this->isRestrictedProduct();
    }

    /**
     * Check product visibility
     *
     * @return boolean
     */
    public function isVisible()
    {
        return parent::isVisible()
            && !( \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration()->restricted_products === 'hide' && $this->isRestrictedProduct());
    }

    public function getRestrictedNote()
    {
        return static::t('Restricted in your country');
    }

    /**
     * Returns true if product is restricted in user country
     *
     * @return boolean
     */
    public function isRestrictedProduct()
    {
        $processorObject = \XLite\Model\Shipping::getProcessorObjectByProcessorId(
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::PROCESSOR_ID
        );

        if (!$processorObject->isConfigured()
            || !\XLite::getController()->getCart()->isPitneyBowesSelected()
        ) {
            $this->isRestricted = false;;
        } elseif (null === $this->isRestricted) {
            $this->isRestricted = false;
            $address = $this->getShippingAddress();
            if ($address) {
                foreach ($this->getRestrictions() as $restriction) {
                    if ($address['country'] === $restriction->getCountry()->getCode()) {
                        $this->isRestricted = true;
                        break;
                    }
                }
            }
        }

        return $this->isRestricted;
    }

    /**
     * Get shipping address
     * 
     * @return \XLite\Model\Address
     */
    protected function getShippingAddress()
    {
        if (null === static::$shippingAddress) {
            if ($this->hasShippingAddress()) {
                static::$shippingAddress = \XLite\Model\Shipping::prepareAddressData(
                    \XLite::getController()->getCart()->getProfile()->getShippingAddress()
                );
            } else {
                static::$shippingAddress = \XLite\Model\Shipping::getDefaultAddress();
            }
        }

        return static::$shippingAddress;
    }

    /**
     * Has shipping address
     * 
     * @return boolean
     */
    protected function hasShippingAddress()
    {
        $cart = \XLite::getController()->getCart();

        return $cart && $cart->getProfile() && $cart->getProfile()->getShippingAddress();
    }
}
