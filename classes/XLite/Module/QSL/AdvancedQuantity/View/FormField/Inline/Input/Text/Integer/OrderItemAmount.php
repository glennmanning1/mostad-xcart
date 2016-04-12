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

namespace XLite\Module\QSL\AdvancedQuantity\View\FormField\Inline\Input\Text\Integer;

/**
 * Product quantity
 */
class OrderItemAmount extends \XLite\View\FormField\Inline\Input\Text\Integer\OrderItemAmount implements \XLite\Base\IDecorator
{

    /**
     * @inheritdoc
     */
    public function getJSFiles()
    {
        $list = preg_grep('/integer\.js/Ss', parent::getJSFiles(), PREG_GREP_INVERT);

        $list[] = 'form_field/inline/input/text/float.js';

        return $list;
    }

    /**
     * @inheritdoc
     */
    protected function defineFieldClass()
    {
        return 'XLite\Module\QSL\AdvancedQuantity\View\FormField\Input\Text\Quantity';
    }

    /**
     * @inheritdoc
     */
    protected function getContainerClass()
    {
        return preg_replace('/ inline-integer/Ss', '', parent::getContainerClass()) . ' inline-float';
    }

    /**
     * @inheritdoc
     */
    protected function getFieldEntityValue(array $field)
    {
        return $this->getEntity()->formatQuantity($this->getEntityValue());
    }

    /**
     * @inheritdoc
     */
    protected function getEntityValue()
    {
        return ($this->getEntity() && $this->getEntity()->getSelectedAmount())
            ? $this->getEntity()->getSelectedAmount()
            : parent::getEntityValue();
    }

    /**
     * @inheritdoc
     */
    protected function getFieldParams(array $field)
    {
        return parent::getFieldParams($field)
            + array(
                'product' => $this->getEntity()->getProduct(),
            );
    }

    /**
     * @inheritdoc
     */
    protected function saveFieldEntityValue(array $field, $value)
    {
        $this->getEntity()->setSelectedAmount($value);

        parent::saveFieldEntityValue($field, $value);
    }


}