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

namespace XLite\Module\XC\PitneyBowes\View\Button;

/**
 * 'Print label' button widget
 *
 */
class PrintLabel extends \XLite\View\Button\Regular
{
    /**
     * Widget parameter names
     */
    const PARAM_PARCEL_ID      = 'parcelId';
    const PARAM_ORDER_NUMBER   = 'orderNumber';

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_PARCEL_ID      => new \XLite\Model\WidgetParam\String('Parcel id', ''),
            self::PARAM_ORDER_NUMBER   => new \XLite\Model\WidgetParam\String('Order number', ''),
        );
    }

    /**
     * Get a list of JavaScript files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/XC/PitneyBowes/asn/right_actions/print_label.js';

        return $list;
    }

    /**
     * Get default label 
     * 
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'Print label';
    }

    /**
     * JavaScript: default JS code to execute
     *
     * @return string
     */
    protected function getDefaultJSCode()
    {
        return 'openPrintLabel(this);';
    }

    /**
     * Return CSS classes
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass() . ' print-label';
    }

    /**
     * Get commented data
     *
     * @return array
     */
    protected function getCommentedData()
    {
        return array(
            'url_params' => array(
                'target'       => 'parcel',
                'mode'         => 'print_label',
                'id'           => $this->getParam(self::PARAM_PARCEL_ID),
                'order_number' => $this->getParam(self::PARAM_ORDER_NUMBER),
            )
        );
    }
}
