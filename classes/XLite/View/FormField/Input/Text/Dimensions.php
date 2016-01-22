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
 * Dimensions
 */
class Dimensions extends \XLite\View\FormField\Input\AInput
{
    const FIELD_TYPE_DIMENSIONS = 'dimensions';

    /**
     * Return field type
     *
     * @return string
     */
    public function getFieldType()
    {
        return static::FIELD_TYPE_DIMENSIONS;
    }

    /**
     * Return field value
     *
     * @return array
     */
    public function getValue()
    {
        $result = parent::getValue();

        return (is_array($result) && 3 == count($result))
            ? array_values($result)
            : array(0, 0, 0);
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = $this->getDir() . '/input/text/dimensions.css';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getFieldTemplate()
    {
        return 'input/text/dimensions.tpl';
    }

    /**
     * Get dimensions by index
     *
     * @param integer $index Index
     *
     * @return float
     */
    protected function getDimension($index)
    {
        $value = $this->getValue();

        return isset($value[$index])
            ? $value[$index]
            : 0;
    }

    /**
     * Get length
     *
     * @return float
     */
    protected function getLength()
    {
        return $this->getDimension(0);
    }

    /**
     * Get width
     *
     * @return float
     */
    protected function getWidth()
    {
        return $this->getDimension(1);
    }

    /**
     * Get height
     *
     * @return float
     */
    protected function getHeight()
    {
        return $this->getDimension(2);
    }

    /**
     * Returns sub field name
     *
     * @param string $name Name
     *
     * @return string
     */
    protected function getSubFieldName($name)
    {
        $subName = '';

        switch ($name) {
            case 'length':
                $subName = '0';
                break;

            case 'width':
                $subName = '1';
                break;

            case 'height':
                $subName = '2';
                break;
        }

        return sprintf('%s[%s]', $this->getName(), $subName);
    }
}
