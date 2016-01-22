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
 * Range
 */
abstract class ARange extends \XLite\View\FormField\Input\AInput
{
    const PARAM_SEPARATOR = 'separator';

    /**
     * Default separator
     */
    const DEFAULT_SEPARATOR = '&minus;';

    /**
     * Returns input widget class name
     *
     * @return string
     */
    abstract protected function getInputWidgetClass();

    /**
     * Return field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return 'range';
    }

    /**
     * Get CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'form_field/input/text/range.css';

        return $list;
    }

    /**
     * Get a list of JS files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = $this->getDir() . '/js/range.js';

        return $list;
    }

    /**
     * Return field template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'range.tpl';
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
            static::PARAM_SEPARATOR => new \XLite\Model\WidgetParam\String(
                'Separator',
                $this->getDefaultSeparator()
            ),
        );
    }

    // {{{ Begin

    /**
     * Returns begin value
     *
     * @return mixed
     */
    protected function getBeginValue()
    {
        $value = $this->getValue();

        return isset($value[0])
            ? $value[0]
            : $this->getDefaultBeginValue();
    }

    /**
     * Returns default begin value
     *
     * @return mixed
     */
    protected function getDefaultBeginValue()
    {
        return '';
    }

    /**
     * Returns begin widget class
     *
     * @return string
     */
    protected function getBeginWidgetClass()
    {
        return $this->getInputWidgetClass();
    }

    /**
     * Returns begin widget params
     *
     * @return array
     */
    protected function getBeginWidgetParams()
    {
        return array(
            static::PARAM_FIELD_ONLY => true,
            static::PARAM_VALUE      => $this->getBeginValue(),
            static::PARAM_NAME       => $this->getName() . '[0]',
            \XLite\View\FormField\Input\Text\Base\Numeric::PARAM_MOUSE_WHEEL_ICON => false,
        );
    }

    /**
     * Returns begin widget class
     *
     * @return \XLite\View\FormField\AFormField
     */
    protected function getBeginWidget()
    {
        $widget = $this->getChildWidget($this->getBeginWidgetClass(), $this->getBeginWidgetParams());

        return $widget->getContent();
    }

    // }}}

    // {{{ End

    /**
     * Returns end value
     *
     * @return mixed
     */
    protected function getEndValue()
    {
        $value = $this->getValue();

        return isset($value[1])
            ? $value[1]
            : $this->getDefaultEndValue();
    }

    /**
     * Returns default end value
     *
     * @return mixed
     */
    protected function getDefaultEndValue()
    {
        return '';
    }

    /**
     * Returns end widget class
     *
     * @return string
     */
    protected function getEndWidgetClass()
    {
        return $this->getInputWidgetClass();
    }

    /**
     * Returns end widget params
     *
     * @return array
     */
    protected function getEndWidgetParams()
    {
        return array(
            static::PARAM_FIELD_ONLY => true,
            static::PARAM_VALUE => $this->getEndValue(),
            static::PARAM_NAME       => $this->getName() . '[1]',
            \XLite\View\FormField\Input\Text\Base\Numeric::PARAM_MOUSE_WHEEL_ICON => false,

        );
    }

    /**
     * Returns end widget class
     *
     * @return \XLite\View\FormField\AFormField
     */
    protected function getEndWidget()
    {
        $widget = $this->getChildWidget($this->getEndWidgetClass(), $this->getEndWidgetParams());

        return $widget->getContent();
    }

    // }}}

    // {{{ Separator

    /**
     * Returns default separator
     *
     * @return string
     */
    protected function getDefaultSeparator()
    {
        return static::DEFAULT_SEPARATOR;
    }

    /**
     * Returns separator
     *
     * @return string
     */
    protected function getSeparator()
    {
        return $this->getParam(static::PARAM_SEPARATOR);
    }

    /**
     * Check for separator
     *
     * @return boolean
     */
    protected function hasSeparator()
    {
        return (bool) strlen($this->getSeparator());
    }

    // }}}
}
