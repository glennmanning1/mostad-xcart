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

namespace XLite\View\FormField\Inline\Input\Text\Product;

/**
 * Product SKU
 */
class SKU extends \XLite\View\FormField\Inline\Input\Text
{
    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'form_field/inline/input/text/product/sku.css';

        return $list;
    }

    /**
     * Get initial field parameters
     *
     * @param array $field Field data
     *
     * @return array
     */
    protected function getFieldParams(array $field)
    {
        return parent::getFieldParams($field) + array('maxlength' => 32);
    }

    /**
     * Validate SKU 
     *
     * @param array $field Feild info
     *
     * @return array
     */
    protected function validateSku(array $field)
    {
        $result = array(true, null);
        try {
            $product = $this->getEntity();
            $validator = new \XLite\Core\Validator\SKU($product ? $product->getProductId() : null);
            $validator->validate($field['widget']->getValue());
        } catch (\Exception $e) {
            $result = array(
                false,
                $e->getMessage()
            );
        }

        return $result;
    }
}
