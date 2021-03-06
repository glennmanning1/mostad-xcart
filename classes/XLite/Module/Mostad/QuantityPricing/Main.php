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
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\Mostad\QuantityPricing;

/**
 * Main module
 */
abstract class Main extends \XLite\Module\AModule
{
    /**
     * Author name
     *
     * @return string
     */
    public static function getAuthorName()
    {
        return 'Mostad';
    }

    /**
     * Module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Quantity pricing';
    }

    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return '';
    }

    /**
     * Get module major version
     *
     * @return string
     */
    public static function getMajorVersion()
    {
        return '5.2';
    }

    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return '0';
    }

    /**
     * @inheritdoc
     */
    protected static function moveTemplatesInLists()
    {
        return [
            'product/quantity_box/parts/quantity_box.tpl' => array(
               array('product.quantity-box', 'customer'),
            ),
            'modules/CDev/Wholesale/product_price/parts/block-parts/price.tpl' => array(
                array('wholesale.price.widgetlist', 'customer'),
            ),
            'product/details/parts/common.price.tpl' => array(
                static::TO_DELETE => array(
                    array('product.details.page.info','customer'),
                    array('product.details.quicklook.info', 'customer')
                ),
            ),
            /*'modules/CDev/Wholesale/product_price/parts/price-block.tpl' => array(
                array('wholesale.price', 'customer'),
            ),
            'modules/CDev/Wholesale/product_price/parts/block-parts/save-price.tpl' => array(
                array('wholesale.price.widgetlist', 'customer'),
            ),
            'modules/CDev/Wholesale/product_price/parts/block-parts/save-price-zero.tpl' => array(
                array('wholesale.price.widgetlist', 'customer'),
            ),*/
        ];
    }

}