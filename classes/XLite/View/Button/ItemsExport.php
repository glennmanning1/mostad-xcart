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

namespace XLite\View\Button;

/**
 * ItemsExport button
 */
abstract class ItemsExport extends \XLite\View\Button\AButton
{
    /**
     * getJSFiles
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/items_export.js';

        return $list;
    }

    /**
     * Register CSS files for delete address button
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/items_export.css';

        return $list;
    }

    /**
     * Get attributes
     *
     * @return array
     */
    protected function getAttributes()
    {
        $list = parent::getAttributes();

        return $list;
    }

    abstract protected function getAdditionalButtons();

    /**
     * Get attributes
     *
     * @return boolean
     */
    protected function isMultipleOptions()
    {
        return 1 < count($this->getAdditionalButtons());
    }

    /**
     * Get attributes
     *
     * @return boolean
     */
    protected function getFirstProviderLabel()
    {
        $buttons = $this->getAdditionalButtons();
        return key($buttons);
    }

    /**
     * getDefaultLabel
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return static::t('Export all');
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/items_export.tpl';
    }

    /**
     * Defines CSS class for widget to use in templates
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass() . ' items-export';
    }
}
