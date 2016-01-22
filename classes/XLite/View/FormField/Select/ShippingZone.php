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

namespace XLite\View\FormField\Select;

/**
 * Sipping zone selector
 */
class ShippingZone extends \XLite\View\FormField\Select\Regular
{
    const PARAM_USED_ZONES = 'usedZones';
    const SEPARATOR_ID = 'SEPARATOR';
    const SEPARATOR_SIGN = '&#x2500;';

    /**
     * Get zones list
     *
     * @return array
     */
    protected function getZonesList()
    {
        $list = array();
        foreach (\XLite\Core\Database::getRepo('XLite\Model\Zone')->findAllZones() as $e) {
            $list[$e->getZoneId()] = $e->getZoneName();
        }

        return $list;
    }

    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return $this->getZonesList();
    }

    /**
     * getOptions
     *
     * @return array
     */
    protected function getOptions()
    {
        $list = parent::getOptions();
        $usedZones = $this->getParam(static::PARAM_USED_ZONES);

        if ($usedZones) {
            $usedList = array();
            $unUsedList = array();

            foreach ($list as $zoneId => $zoneName) {
                if (isset($usedZones[$zoneId])) {
                    $usedList[$zoneId] = sprintf('%s (%d)', $zoneName, $usedZones[$zoneId]);

                } else {
                    $unUsedList[$zoneId] = sprintf('%s (%d)', $zoneName, 0);
                }
            }

            if ($usedList) {
                asort($usedList);
                $list = $usedList;

                $list += array(static::SEPARATOR_ID => str_repeat(static::SEPARATOR_SIGN, 10));

                asort($usedList);
                $list += $unUsedList;
            }
        }

        return $list;
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_USED_ZONES => new \XLite\Model\WidgetParam\Collection(
                'Used zones',
                array(),
                false
            ),
        );
    }

    /**
     * Check - specified option is disabled or not
     *
     * @param mixed $value Option value
     *
     * @return boolean
     */
    protected function isOptionDisabled($value)
    {
        return static::SEPARATOR_ID === $value
            ? true
            : parent::isOptionDisabled($value);
    }

    /**
     * Assemble classes
     *
     * @param array $classes Classes
     *
     * @return array
     */
    public function assembleClasses(array $classes)
    {
        $classes = parent::assembleClasses($classes);
        $classes[] = 'not-significant';

        return $classes;
    }
}
