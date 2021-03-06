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

namespace XLite\View\FormField\Input\Text;

/**
 * Price
 */
class PriceWithInfinity extends \XLite\View\FormField\Input\Text\Price
{
    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'form_field/input/text/float_with_infinity.js';

        return $list;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        $value = $this->getParam(static::PARAM_VALUE);

        return html_entity_decode('&#x221E;') === $value ? $value : parent::getValue();
    }

    /**
     * Format value
     *
     * @param float $value Value
     *
     * @return string
     */
    protected function formatValue($value)
    {
        return html_entity_decode('&#x221E;') === $value ? $value : parent::formatValue($value);
    }

    /**
     * Assemble validation rules
     *
     * @return array
     */
    protected function assembleValidationRules()
    {
        $rules = array_diff(parent::assembleValidationRules(), array('custom[number]'));
        $rules[] = 'custom[numberWithInfinity]';

        return $rules;
    }

    /**
     * Assemble classes
     *
     * @param array $classes Classes
     *
     * @return array
     */
    protected function assembleClasses(array $classes)
    {
        $list = array_diff(parent::assembleClasses($classes), array('float'));
        $list[] = 'with-infinity';
        $list[] = 'float-with-infinity';

        return $list;
    }
}
