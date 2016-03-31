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

namespace XLite\Module\CSI\HiddenCategories;

/**
 * Main module
 */
abstract class Main extends \XLite\Module\AModule
{
    /**
     * Author name
     *
     * @return string
     */
    public static function getAuthorName()
    {
        return 'CFL Systems, Inc.';
    }

    /**
     * Module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Hidden Categories';
    }

    /**
     * Define the module type
     *
     * @return integer
     */
    public static function getModuleType()
    {
        return static::MODULE_TYPE_CUSTOM_MODULE;
    }
    
    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return 'This module adds \'Hidden but available for sale\' functionality for categories.';
    }

    /**
     * Get module major version
     *
     * @return string
     */
    public static function getMajorVersion()
    {
        return '5.2';
    }

    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return '1';
    }

    /**
     * Get author page URL
     *
     * @return string
     */
    public static function getAuthorPageURL()
    {
        return 'https://www.cflsystems.com/';
    }
 
    /**
     * Get module page URL
     *
     * @return string
     */
    public static function getPageURL()
    {
        return 'https://www.cflsystems.com/hidden-categories-for-x-cart-5.html';
    }
    
    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     */
    public static function showSettingsForm()
    {
        return true;
    }
}
