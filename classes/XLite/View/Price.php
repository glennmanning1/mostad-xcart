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

namespace XLite\View;

/**
 * Product price
 */
class Price extends \XLite\View\Product\Details\Customer\Widget
{
    /**
     * Widget parameters
     */
    const PARAM_DISPLAY_ONLY_PRICE          = 'displayOnlyPrice';

    /**
     * @var array $labels  List labels runtime cache
     */
    protected static $labels = array();

    /**
     * @var array $listPrices List prices runtime cache
     */
    protected static $listPrices = array();

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'common/price_plain_body.tpl';
    }

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        if ($this->getProduct()) {
            // Warmup cache
            $id = $this->getProduct()->getProductId();
            if (!isset(static::$labels[$id])) {
                static::$labels[$id] = $this->getLabels();
            }
        }
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_DISPLAY_ONLY_PRICE => new \XLite\Model\WidgetParam\Bool('Display only price', false)
        );
    }

    /**
     * Return list price of product
     *
     * @return float
     */
    protected function getListPrice($value = null)
    {
        $id = $this->getProduct()->getProductId();

        if (!isset(static::$listPrices[$id])) {
            $this->product->setAttrValues($this->getAttributeValues());
            static::$listPrices[$id] = $this->getNetPrice($value);
        }

        return static::$listPrices[$id];
    }

    /**
     * Return net price of product
     *
     * @return float
     */
    protected function getNetPrice($value = null)
    {
        return $this->getProduct()->getDisplayPrice();
    }

    /**
     * Return the specific widget service name to make it visible as specific CSS class
     *
     * @return null|string
     */
    public function getFingerprint()
    {
        return 'widget-fingerprint-product-price';
    }

    /**
     * Return list of product labels
     *
     * @return array
     */
    protected function getLabels()
    {
        $id = -1;

        if ($this->getProduct()) {
            $id = $this->getProduct()->getProductId();
        }

        return isset(static::$labels[$id])
            ? static::$labels[$id]
            : array();
    }

    /**
     * Return the specific label info
     *
     * @param string $labelName
     *
     * @return array
     */
    protected function getLabel($labelName)
    {
        return array();
    }
}
