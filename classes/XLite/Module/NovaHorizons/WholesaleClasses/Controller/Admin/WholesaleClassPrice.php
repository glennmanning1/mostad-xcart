<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Nova Horizons
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  X-Cart 5
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\WholesaleClasses\Controller\Admin;


class WholesaleClassPrice extends \XLite\Controller\Admin\AAdmin
{

    protected $params = array('target', 'pricing_set_id', 'page');

    /**
     * Get pages sections
     *
     * @return array
     */
    public function getPages()
    {
        $list = parent::getPages();

        $list['wholesale_pricing'] = 'Wholesale Pricing';

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

        $list['default'] = 'modules/NovaHorizons/WholesaleClasses/page/wholesale_class_price/body.tpl';
        $list['wholesale_pricing'] = 'modules/NovaHorizons/WholesaleClasses/page/wholesale_class_price/body.tpl';

        return $list;
    }

    public function doActionUpdate()
    {
        $list = new \XLite\Module\NovaHorizons\WholesaleClasses\View\ItemsList\Model\WholesaleClassPrice();
        $list->processQuick();

        \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice')
            ->correctQuantityRangeEnd($this->getPriceSet());
    }

    public function getPriceSet()
    {
        return \XLite\Core\Database::getRepo('\XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet')
                ->find(\XLite\Core\Request::getInstance()->pricing_set_id);
    }

    public function getTitle()
    {
        return $this->getPriceSet()->getName() . ' Class Pricing';
    }

}