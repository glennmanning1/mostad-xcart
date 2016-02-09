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

namespace XLite\View\FormField\Inline\Textarea;

/**
 * Order staff note
 */
class OrderStaffNote extends \XLite\View\FormField\Inline\Textarea\Simple
{
    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'form_field/inline/textarea/order_staff_note.js';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'form_field/inline/textarea/order_staff_note.css';

        return $list;
    }

    /**
     * Get view template
     *
     * @return string
     */
    protected function getViewTemplate()
    {
        return 'form_field/inline/textarea/order_staff_note.view.tpl';
    }

    /**
     * Get field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'form_field/inline/textarea/order_staff_note.field.tpl';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        $class = parent::getContainerClass()
            . ' ' . ($this->getEntityValue() ? 'in-progress filled' : 'empty')
            . ' inline-order-staff-note';

        return trim($class);
    }

    /**
     * Get empty value
     *
     * @param array $field Field
     *
     * @return string
     */
    protected function getEmptyValue(array $field)
    {
        return $this->getCommonEmptyValue();
    }

    /**
     * Get empty value
     *
     * @return string
     */
    protected function getCommonEmptyValue()
    {
        return static::t('Add comment here');
    }

    /**
     * Check - escape value or not
     *
     * @return boolean
     */
    protected function isEscapeValue()
    {
        return false;
    }

    /**
     * Get container attributes
     *
     * @return array
     */
    protected function getContainerAttributes()
    {
        $list = parent::getContainerAttributes();
        $list['data-max-length'] = $this->getMaxLength();
        $list['data-max-row-length'] = $this->getMaxRowLength();

        return $list;
    }

    /**
     * Get additional CSS classes for the field widget
     *
     * @param array $field Field data
     *
     * @return string
     */
    protected function getAdditionalFieldStyle($field)
    {
        $style = parent::getAdditionalFieldStyle($field);

        return ($style ? $style . ' ' : '') . 'not-affect-recalculate';
    }

    /**
     * Get maximum length of truncated text (for view part)
     *
     * @return integer
     */
    protected function getMaxLength()
    {
        return 165;
    }

    /**
     * Get maximum row length of truncated text (for view part)
     *
     * @return integer
     */
    protected function getMaxRowLength()
    {
        return 45;
    }
}
