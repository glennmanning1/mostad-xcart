<?php
// vim: set ts=2 sw=2 sts=2 et:

/**
 * Hidden Categories Module
 *
 * NOTICE OF LICENSE
 *
 * The software license agreement for this module can be found at
 * the following URL: https://www.cflsystems.com/software-license-agreement.html
 *
 * This file and its source code are property of CFL Systems, Inc. and are
 * protected by United States copyright law. The source code contained in this file
 * may not be reproduced, copied, modified or redistributed in any form without
 * written authorization by an officer of CFL Systems, Inc.
 *
 * @category  X-Cart 5 Module
 * @author    CFL Systems, Inc. <support@cflsystems.com>
 * @copyright Copyright (c) 2015-2016 CFL Systems, Inc. All rights reserved.
 * @license   CFL Systems Software License Agreement - https://www.cflsystems.com/software-license-agreement.html
 * @link      https://www.cflsystems.com/hidden-categories-for-x-cart-5.html
 */

namespace XLite\Module\CSI\HiddenCategories\View\ItemsList\Product\Customer;

/**
 * Search
 *
 */
class Search extends \XLite\View\ItemsList\Product\Customer\Search implements \XLite\Base\IDecorator
{
    /**
     * Prepare search condition before search
     *
     * @param \XLite\Core\CommonCell $cnd Search condition
     *
     * @return \XLite\Core\CommonCell
     */
    protected function prepareCnd(\XLite\Core\CommonCell $cnd)
    {
        $cnd = parent::prepareCnd($cnd);
        
        if ('Y' == \XLite\Core\Config::getInstance()->CSI->HiddenCategories->csi_hidden_cats_hide_products) {
            $cnd->{\XLite\Model\Repo\Product::P_CSI_HIDDEN_CATEGORY} = true;
        }
        
        return $cnd;
    }
}
