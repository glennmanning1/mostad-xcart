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

namespace XLite\Module\XC\ProductVariants\View\Product\Details\Customer;

/**
 * Product image
 */
class Image extends \XLite\View\Product\Details\Customer\Image implements \XLite\Base\IDecorator
{
    /**
     * Define value for hasZoomImage() method
     *
     * @return boolean
     */
    protected function defineHasZoomImage()
    {
        $result = parent::defineHasZoomImage();
        $product = $this->getProduct();

        if (!$result && $product->hasVariants()) {
            foreach ($product->getVariants() as $variant) {
                if ($variant->getImage() && $this->isImageZoomable($variant->getImage())) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Get zoom image
     *
     * @return \XLite\Model\Image
     */
    protected function getZoomImage()
    {
        $image = null;

        if ($this->defineHasZoomImage()) {
            foreach ($this->getProduct()->getVariants() as $variant) {
                if ($variant->getImage() && $this->isImageZoomable($variant->getImage())) {
                    $image = $variant->getImage();
                    break;
                }
            }
        }

        return $image;
    }

    /**
     * Get zoom image URL
     *
     * @return string
     */
    protected function getZoomImageURL()
    {
        $image = $this->getZoomImage();

        return $image
            ? $image->getURL()
            : parent::getZoomImageURL();
    }

    /**
     * Get zoom layer width
     *
     * @return integer
     */
    protected function getZoomWidth()
    {
        $image = $this->getZoomImage();

        return $image
            ? min($image->getWidth(), $this->getParam(self::PARAM_ZOOM_MAX_WIDTH))
            : min($this->getProduct()->getImage()->getWidth(), $this->getParam(self::PARAM_ZOOM_MAX_WIDTH));
    }
}
