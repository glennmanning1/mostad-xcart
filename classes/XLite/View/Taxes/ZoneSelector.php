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

namespace XLite\View\Taxes;

/**
 * Zone selector 
 */
class ZoneSelector extends \XLite\View\AView
{
    /**
     * Widget parameters names
     */
    const PARAM_FIELD_NAME = 'field';
    const PARAM_VALUE      = 'value';

    /**
     * Get all zones
     *
     * @return array
     */
    public function getZones()
    {
        return \XLite\Core\Database::getRepo('\XLite\Model\Zone')->findAllZones();
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'taxes/zone_selector.tpl';
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
            self::PARAM_FIELD_NAME => new \XLite\Model\WidgetParam\String('Field', 'membership', false),
            self::PARAM_VALUE      => new \XLite\Model\WidgetParam\Object('Value', null, false, '\XLite\Model\Zone'),
        );
    }

    /**
     * Check - specified zone is selected or not
     * 
     * @param \XLite\Model\Zone $current Zone
     *
     * @return boolean
     */
    protected function isSelectedZone(\XLite\Model\Zone $current)
    {
        return $this->getParam(self::PARAM_VALUE)
            && $current->getZoneId() == $this->getParam(self::PARAM_VALUE)->getZoneId();
    }
}

