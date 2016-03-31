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

namespace XLite\Module\CSI\HiddenCategories\Model;

/**
 * Category model class
 */
class Category extends \XLite\Model\Category implements \XLite\Base\IDecorator
{
    /**
     * Is category hidden or not
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $csiHiddenCategory = false;

    /**
     * Return subcategories list
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSubcategories()
    {
        $subcats = parent::getSubcategories();
        
        foreach ($subcats as $k => $v) {
            if ($v->csiHiddenCategory) {
                unset($subcats[$k]);
            }
        }
        
        return $subcats;
    }
}
