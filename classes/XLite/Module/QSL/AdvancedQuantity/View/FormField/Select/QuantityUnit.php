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

namespace XLite\Module\QSL\AdvancedQuantity\View\FormField\Select;

/**
 * Quantity unit
 */
class QuantityUnit extends \XLite\View\FormField\Select\Regular
{
    /**
     * Widget param names
     */
    const PARAM_PRODUCT = 'product';

    /**
     * @inheritdoc
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_PRODUCT => new \XLite\Model\WidgetParam\Object('Product', null, false, 'XLite\Model\Product'),
        );
    }

    /**
     * @inheritdoc
     */
    protected function getOptions()
    {
        $result = array(0 => static::t('All'));

        foreach ($this->getParam(static::PARAM_PRODUCT)->getQuantityUnits() as $unit) {
            $result[$unit->getId()] = $unit->getName();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function getDefaultOptions()
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    protected function getOptionAttributes($value, $text)
    {
        $attributes = parent::getOptionAttributes($value, $text);

        foreach ($this->getParam(static::PARAM_PRODUCT)->getQuantityUnits() as $unit) {
            if ($unit->getId() == $value) {
                $attributes['data-multiplier'] = $unit->getMultiplier();
                break;
            }
        }

        return $attributes;
    }

}
