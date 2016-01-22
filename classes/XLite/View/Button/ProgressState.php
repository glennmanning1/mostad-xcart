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
 * Progress state button
 */
class ProgressState extends \XLite\View\Button\AButton
{
    /**
     * Widget parameters to use
     */
    const PARAM_STATE   = 'state';
    const PARAM_JS_CODE = 'jsCode';

    const STATE_STILL       = 'still';
    const STATE_IN_PROGRESS = 'in_progress';
    const STATE_SUCCESS     = 'success';
    const STATE_FAIL        = 'fail';

    /**
     * Get a list of JavaScript files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'button/js/progress-state.js';

        return $list;
    }

    /**
     * Return CSS files list
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'button/css/progress-state.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'button/progress-state.tpl';
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
            static::PARAM_STATE   => new \XLite\Model\WidgetParam\String('Initial state', static::STATE_STILL),
            static::PARAM_JS_CODE => new \XLite\Model\WidgetParam\String('JS code', null, true),
        );
    }

    /**
     * Get class
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass()
            . ' progress-state'
            . ' ' . $this->getParam(static::PARAM_STATE);
    }

    /**
     * JavaScript: return specified (or default) JS code to execute
     *
     * @return string
     */
    protected function getJSCode()
    {
        return $this->getParam(static::PARAM_JS_CODE);
    }

    /**
     * Get attributes
     *
     * @return array
     */
    protected function getAttributes()
    {
        $list = parent::getAttributes();

        return array_merge($list, $this->getLinkAttributes());
    }

    /**
     * Onclick specific attribute is added
     *
     * @return array
     */
    protected function getLinkAttributes()
    {
        return $this->getJSCode()
            ? array('onclick' => 'javascript: ' . $this->getJSCode())
            : array();
    }
}
