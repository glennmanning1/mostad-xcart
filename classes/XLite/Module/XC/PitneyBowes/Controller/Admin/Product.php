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

/**
 * Product modify controller
 */
class Product extends \XLite\Controller\Admin\Product implements \XLite\Base\IDecorator
{
    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();

        if (!$this->isNew()) {
            $list['additional_info'] = static::t('Additional details');
            $list['shipping_restrictions'] = static::t('Shipping restrictions');
        }

        return $list;
    }

    /**
     * Handles the request
     *
     * @return void
     */
    public function handleRequest()
    {
        $cellName = \XLite\Module\XC\PitneyBowes\View\ItemsList\Model\ProductRestriction::getSessionCellName();
        \XLite\Core\Session::getInstance()->$cellName = array(
            \XLite\Module\XC\PitneyBowes\Model\Repo\ProductRestriction::SEARCH_PRODUCT => $this->getProductId(),
        );

        parent::handleRequest();
    }

    /**
     * update additional details
     *
     * @return void
     */
    protected function doActionUpdateDetails()
    {
        $this->getDetailsModelForm()->performAction('modify');

        $this->setReturnURL(
            $this->buildURL(
                'product',
                '',
                array(
                    'product_id' => $this->getProductId(),
                    'page' => 'additional_info',
                )
            )
        );
    }

    /**
     * Return model form object
     *
     * @param array $params Form constructor params OPTIONAL
     *
     * @return \XLite\View\Model\AModel|void
     */
    public function getDetailsModelForm(array $params = array())
    {
        $class = '\XLite\Module\XC\PitneyBowes\View\Model\AdditionalDetails';

        return \XLite\Model\CachingFactory::getObject(
            __METHOD__ . $class . (empty($params) ? '' : md5(serialize($params))),
            $class,
            $params
        );
    }

    /**
     * Get pages templates
     *
     * @return array
     */
    protected function getPageTemplates()
    {
        $list = parent::getPageTemplates();

        if (!$this->isNew()) {
            $list['additional_info'] = 'modules/XC/PitneyBowes/product/additional.tpl';
            $list['shipping_restrictions'] = 'modules/XC/PitneyBowes/product/restrictions.tpl';
        }

        return $list;
    }
}
