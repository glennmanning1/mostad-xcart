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

namespace XLite\Controller\Admin;

/**
 * Shipping test page controller
 */
class ShippingTest extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Current shipping method
     *
     * @var \XLite\Model\Shipping\Method
     */
    protected $method;

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        $result = static::t('Test shipping rates');
        if ($this->getMethod()) {
            $result = $this->getMethod()->getName();
        }

        return $result;
    }

    /**
     * Returns shipping method
     *
     * @return null|\XLite\Model\Shipping\Method
     */
    public function getMethod()
    {
        if (null === $this->method) {
            /** @var \XLite\Model\Repo\Shipping\Method $repo */
            $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');
            $this->method = $repo->findOnlineCarrier($this->getProcessorId());
        }

        return $this->method;
    }

    /**
     * Returns current processor id
     *
     * @return string
     */
    public function getProcessorId()
    {
        return \XLite\Core\Request::getInstance()->processor;
    }

    /**
     * Check controller visibility
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getMethod();
    }
}
