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
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\QSL\WordPressIntegration\View\Tabs;

/**
 * Tabs related to category section
 */
class Category extends \XLite\View\Tabs\Category implements \XLite\Base\IDecorator
{
    /**
     * Returns the list of targets where this widget is available
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'category_wp_code';

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/QSL/WordPressIntegration/admin.js';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/QSL/WordPressIntegration/admin.css';

        return $list;
    }

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->tabs['category_wp_code'] = array(
            'title'    => 'WP code',
            'template' => 'modules/QSL/WordPressIntegration/category_code.tpl',
        ); 
    }

    /**
     * Get code of category
     *
     * @return string
     */
    public function getCategoryCode() 
    {
        $categoryId = $this->getCategoryId();

        return "[xcart widget='productgrid' category_id='{$categoryId}' grid_size='5']";
    }

}
