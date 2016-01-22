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

namespace XLite\Module\XC\FreeShipping\View\Shipping;

/**
 * Edit shipping method dialog widget
 */
class EditMethod extends \XLite\View\Shipping\EditMethod implements \XLite\Base\IDecorator
{
    /**
     * Shipping method
     *
     * @var \XLite\Model\Shipping\Method
     */
    protected $method;

    /**
     * Offline help template
     *
     * @return string
     */
    protected function getOfflineHelpTemplate()
    {
        $method = $this->getMethod();

        return ($method->getFree() || $this->isFixedFeeMethod($method))
            ? 'modules/XC/FreeShipping/shipping/add_method/parts/offline_help.tpl'
            : 'shipping/add_method/parts/offline_help.tpl';
    }

    /**
     * Returns help text
     *
     * @return string
     */
    protected function getHelpText()
    {
        $method = $this->getMethod();

        return $this->isFixedFeeMethod($method)
            ? static::t('Shipping freight tooltip text')
            : static::t('Free shipping tooltip text');
    }

    /**
     * Returns shipping method
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function getMethod()
    {
        if (null === $this->method) {
            $this->method = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method')->find(
                \XLite\Core\Request::getInstance()->methodId
            );
        }

        return $this->method;
    }

    /**
     * Return true if method is 'Freight fixed fee'
     *
     * @param \XLite\Model\Shipping\Method $method
     *
     * @return boolean
     */
    protected function isFixedFeeMethod(\XLite\Model\Shipping\Method $method)
    {
        return \XLite\Model\Shipping\Method::METHOD_TYPE_FIXED_FEE === $method->getCode()
            && 'offline' === $method->getProcessor();
    }
}
