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

namespace XLite\Module\QSL\AdvancedQuantity;

/**
 * Advanced quantity module
 */
abstract class Main extends \XLite\Module\AModule
{
    /**
     * @inheritdoc
     */
    public static function getAuthorName()
    {
        return 'Qualiteam';
    }

    /**
     * @inheritdoc
     */
    public static function getModuleName()
    {
        return 'Fractional and Fixed quantities';
    }

    /**
     * @inheritdoc
     */
    public static function getMajorVersion()
    {
        return '5.2';
    }

    /**
     * @inheritdoc
     */
    public static function getMinorVersion()
    {
        return '3';
    }

    /**
     * @inheritdoc
     */
    public static function getDescription()
    {
        return 'Sell products with quantity represented in fractional numbers, products available in packages '
            . 'containing fixed quantity of items, and set allowed quantities to be added to cart at a time.';
    }

    /**
     * Check - Wholesale module is enabled or not
     *
     * @return boolean
     */
    public static function isWholesaleModuleEnabled()
    {
        return \Includes\Utils\ModulesManager::isActiveModule('CDev\Wholesale');
    }

    /**
     * @inheritdoc
     */
    protected static function moveTemplatesInLists()
    {
        return array(
            'product/quantity_box/parts/quantity_box.tpl' => array(
               array('product.quantity-box', 'customer'),
            ),
            'mini_cart/horizontal/parts/item.price.tpl' => array(
                array('minicart.horizontal.item', 'customer'),
            ),
            'checkout/steps/review/parts/items.list.tpl' => array(
                static::TO_DELETE => array(
                    array('checkout.review.selected.items', \XLite\Model\ViewList::INTERFACE_CUSTOMER),
                    array('checkout.review.inactive.items', \XLite\Model\ViewList::INTERFACE_CUSTOMER),
                )
            ),
            'order/invoice/parts/item.qty.tpl' => array(
                static::TO_DELETE => array(
                    array('invoice.item', \XLite\Model\ViewList::INTERFACE_CUSTOMER),
                )
            ),
            'order/invoice/parts/items/item.qty.tpl' => array(
                static::TO_DELETE => array(
                    array('invoice.item', \XLite\Model\ViewList::INTERFACE_ADMIN),
                )
            ),
            'order/invoice/parts/item.price.tpl' => array(
                static::TO_DELETE => array(
                    array('invoice.item', \XLite\Model\ViewList::INTERFACE_CUSTOMER),
                )
            ),
            'order/invoice/parts/items/item.price.tpl' => array(
                static::TO_DELETE => array(
                    array('invoice.item', \XLite\Model\ViewList::INTERFACE_ADMIN),
                )
            ),
            'order/packing_slip/parts/body/items/item.qty.tpl' => array(
                static::TO_DELETE => array(
                    array('packing_slip.item', \XLite\Model\ViewList::INTERFACE_ADMIN),
                )
            ),
            'modules/CDev/Wholesale/min_quantity/parts/price-purchase-limit.tpl' => array(
                static::TO_DELETE => array(
                    array('wholesale.minquantity', \XLite\Model\ViewList::INTERFACE_CUSTOMER),
                )
            ),
            'modules/XC/Add2CartPopup/parts/item.price.tpl' => array(
                static::TO_DELETE => array(
                    array('add2cart_popup.item', \XLite\Model\ViewList::INTERFACE_CUSTOMER),
                )
            ),
        );
    }

}
