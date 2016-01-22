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

namespace XLite\Module\CDev\Coupons\Controller\Admin;

/**
 * Coupon
 */
class Coupon extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Controller parameters
     *
     * @var   array
     */
    protected $param = array('target', 'id');

    /**
     * Coupon id
     *
     * @var   integer
     */
    protected $id;

    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL()
            || \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage coupons');
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        $model = $this->getModelForm()->getModelObject();

        return ($model && $model->getId())
            ? $model->getCode()
            : static::t('Coupon');
    }

    /**
     * Update coupon
     *
     * @return void
     */
    public function doActionUpdate()
    {
        $this->getModelForm()->performAction('modify');

        if ($this->getModelForm()->isValid()) {
            $this->setReturnURL(
                \XLite\Core\Converter::buildURL(
                    'promotions',
                    '',
                    array('page' => \XLite\Controller\Admin\Promotions::PAGE_COUPONS)
                )
            );
        }
    }

    /**
     * Returns coupon
     *
     * @return \XLite\Module\CDev\Coupons\Model\Coupon
     */
    protected function getCoupon()
    {
        return $this->getModelForm()->getModelObject();
    }

    /**
     * Get model form class
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\CDev\Coupons\View\Model\Coupon';
    }
}
