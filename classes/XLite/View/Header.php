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

namespace XLite\View;

/**
 * Page header
 */
class Header extends \XLite\View\AResourcesContainer
{
    /**
     * Get meta description
     *
     * @return string
     */
    protected function getMetaDescription()
    {
        $result = \XLite::getController()->getMetaDescription();

        return ($result && is_scalar($result))
            ? trim(strip_tags($result))
            : $this->getDefaultMetaDescription();
    }

    /**
     * Get default meta description
     *
     * @return string
     */
    protected function getDefaultMetaDescription()
    {
        return static::t('default-meta-description');
    }

    /**
     * Get title
     *
     * @return string
     */
    protected function getTitle()
    {
        return \XLite::getController()->getPageTitle() ?: $this->getDefaultTitle();
    }

    /**
     * Get default title
     *
     * @return string
     */
    protected function getDefaultTitle()
    {
        return 'X-Cart';
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'header';
    }

    /**
     * Get collected meta tags
     *
     * @return array
     */
    protected function getMetaResources()
    {
        return static::getRegisteredMetas();
    }

    /**
     * Get script
     *
     * @return string
     */
    protected function getScript()
    {
        return \XLite::getInstance()->getScript();
    }

    /**
     * Defines the base URL for the page
     * 
     * @return string
     */
    protected function getBaseShopURL()
    {
        return \XLite::getInstance()->getShopURL();
    }
    
    /**
     * Get head tag attributes
     *
     * @return array
     */
    protected function getHeadAttributes()
    {
        return array();
    }
}
