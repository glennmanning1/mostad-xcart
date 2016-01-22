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

namespace XLite\Module\XC\PitneyBowes\Controller\Admin;

use \XLite\Module\XC\PitneyBowes\Model\Shipping;

/**
 * Order page controller
 */
class Order extends \XLite\Controller\Admin\Order implements \XLite\Base\IDecorator
{
    const PB_CREATE_ASN = 'XLite\Module\XC\PitneyBowes\View\CreateASN';

    protected function getPopupNames()
    {
        return array(
            static::PB_CREATE_ASN => static::t('Create ASN'),
        );
    }

    /**
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        $title = parent::getTitle();

        $widget = ltrim(\XLite\Core\Request::getInstance()->widget, '\\');
        if ($widget && array_key_exists($widget, $this->getPopupNames())) {
            $names = $this->getPopupNames();
            $title = $names[$widget];
        }

        return $title;
    }

    // {{{ Pages

    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();

        if (
            $this->getOrder()
            && $this->getOrder()->getShippingProcessor() instanceof \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes
        ) {
            $list['parcels'] = static::t('Parcels');
        }

        return $list;
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();

        if ($this->getOrder()->getShippingProcessor() instanceof \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes) {
            $list['parcels'] = 'modules/XC/PitneyBowes/asn/body.tpl';
        }

        return $list;
    }

    // }}}

    /**
     * Update list
     *
     * @return void
     */
    protected function doActionUpdateParcels()
    {
        $list = new \XLite\Module\XC\PitneyBowes\View\ItemsList\Model\Parcels;
        $list->processQuick();
    }

}
