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

namespace XLite\Module\CSI\HiddenCategories\View\Model;

/**
 * Category view model
 */
class Category extends \XLite\View\Model\Category implements \XLite\Base\IDecorator
{
    public function __construct(array $params = array(), array $sections = array())
    {
        parent::__construct($params, $sections);

        $insert_field = array (
            'csiHiddenCategory' => array(
                self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
                self::SCHEMA_LABEL    => 'Hidden',
                self::SCHEMA_HELP     => 'Hide category and its subcategories from search results and list pages.',
                self::SCHEMA_REQUIRED => false,
            ),
        );
        
        $this->arrayInsert(
            $this->schemaDefault,
            'enabled',
            $insert_field
        );
    }
    
    /**
     * Insert new item in array
     *
     * @param array       $array
     * @param int|string  $position
     * @param mixed       $insert
     */
    protected function arrayInsert(&$array, $position, $insert)
    {
        if (is_int($position)) {
            array_splice($array, $position, 0, $insert);
        } else {
            $pos   = array_search($position, array_keys($array));
            $array = array_merge(
                array_slice($array, 0, $pos),
                $insert,
                array_slice($array, $pos)
            );
        }
    }
}
