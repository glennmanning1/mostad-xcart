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

namespace XLite\Module\QSL\AdvancedQuantity\View\FormField\Inline\Select;

/**
 * Product quantity unit
 *
 * entity - \XLite\Model\OrderItem
 *          or \XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantitySet
 */
class QuantityUnit extends \XLite\View\FormField\Inline\Base\Single
{

    /**
     * @inheritdoc
     */
    protected function getViewValue(array $field)
    {
        return $this->getEntity() && $this->getEntity()->getQuantityUnit()
            ? $this->getEntity()->getQuantityUnit()->getName()
            : static::t('None');
    }

    /**
     * @inheritdoc
     */
    protected function defineFieldClass()
    {
        return 'XLite\Module\QSL\AdvancedQuantity\View\FormField\Select\QuantityUnit';
    }

    /**
     * @inheritdoc
     */
    protected function getFieldParams(array $field)
    {
        return parent::getFieldParams($field)
        + array('product' => $this->getEntity()->getProduct());
    }

    /**
     * @inheritdoc
     */
    protected function getEntityValue()
    {
        return $this->getEntity()->getQuantityUnit()
            ? $this->getEntity()->getQuantityUnit()->getId()
            : 0;
    }

    /**
     * @inheritdoc
     */
    protected function saveFieldEntityValue(array $field, $value)
    {
        if ($value) {
            $this->getEntity()->setQuantityUnit(
                \Xlite\Core\Database::getRepo('XLite\Module\QSL\AdvancedQuantity\Model\Product\QuantityUnit')->find($value)
            );

        } else {
            $this->getEntity()->setQuantityUnit(null);
        }
    }

}
