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
 * 'Save search filter' button widget
 */
class SaveSearchFilter extends \XLite\View\Button\SimpleLink
{
    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/save_search_filter.css';

        return $list;
    }

    /**
     * Get a list of JavaScript files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/save_search_filter.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/save_search_filter.tpl';
    }

    /**
     * Get default button label
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return static::t('Save filter');
    }

    /**
     * Get default button action
     *
     * @return string
     */
    protected function getDefaultAction()
    {
        return 'save_search_filter';
    }

    /**
     * Get style
     *
     * @return string
     */
    protected function  getClass()
    {
        return trim(parent::getClass() . ' save-search-filter');
    }

    /**
     * Get button placeholder
     *
     * @return string
     */
    protected function getPlaceholder()
    {
        return static::t('Enter filter name');
    }

    /**
     * Filter ID
     *
     * @return integer
     */
    protected function getFilterId()
    {
        return $this->getCurrentSearchFilter() ? $this->getCurrentSearchFilter()->getId() : null;
    }

    /**
     * Get filter name
     *
     * @return string
     */
    protected function getFilterName()
    {
        return $this->getCurrentSearchFilter() ? $this->getCurrentSearchFilter()->getName() : '';
    }

    /**
     * Get label for the submit button
     *
     * @return string
     */
    protected function getActionButtonLabel()
    {
        return static::t('Save');
    }

    /**
     * Get name attribute for input field 'Filter name'
     *
     * @return string
     */
    protected function getFilterFieldName()
    {
        return 'filterName';
    }

    /**
     * Get filter name
     *
     * @return string
     */
    protected function getFilterIdFieldName()
    {
        return 'search_filter_id';
    }
}
