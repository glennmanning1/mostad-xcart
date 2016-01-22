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

namespace XLite\View\Tabs;

/**
 * Tabs related to shipping settings
 *
 * @ListChild (list="add_shipping", zone="admin", weight="10")
 */
class ShippingType extends \XLite\View\Tabs\AJsTabs
{
    /**
     * Description of tabs related to shipping settings and their targets
     *
     * @var array
     */
    protected $tabs = array(
        'carrier_calculated' => array(
            'weight'   => 100,
            'title'    => 'Carrier-calculated rates',
            'template' => 'shipping/add_method/parts/online_carrier_list.tpl',
        ),
        'custom_table' => array(
            'weight'   => 200,
            'title'    => 'Custom table rates',
            'template' => 'shipping/add_method/parts/offline_create.tpl',
        ),
    );

    /**
     * Offline help template
     *
     * @return string
     */
    protected function getOfflineHelpTemplate()
    {
        return 'shipping/add_method/parts/offline_help.tpl';
    }

    /**
     * Online help template
     *
     * @return string
     */
    protected function getOnlineHelpTemplate()
    {
        return 'shipping/add_method/parts/online_help.tpl';
    }
}
