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

namespace XLite\Controller\Admin;

use \XLite\Logic\BannerRotation\Processor;

/**
 * Banner rotation controller
 */
class BannerRotation extends \XLite\Controller\Admin\Settings
{
    /**
     * Recommended module URL (run-time cache)
     *
     * @var string
     */
    protected $recommendedModuleURL = null;

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Front page');
    }

    /**
     * Update model
     *
     * @return void
     */
    public function doActionUpdate()
    {
        $list = new \XLite\View\ItemsList\BannerRotationImages();
        $list->processQuick();

        $this->getModelForm()->performAction('update');
    }

    /**
     * getModelFormClass
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return 'XLite\View\Model\Settings';
    }

    /**
     * Get options for current tab (category)
     *
     * @return \XLite\Model\Config[]
     */
    public function getOptions()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Config')->findByCategoryAndVisible('BannerRotation');
    }

    /**
     * Get recommended module URL
     *
     * @return string
     */
    public function getRecommendedModuleURL()
    {
        if (!isset($this->recommendedModuleURL)) {
            $module = \XLite\Core\Database::getRepo('XLite\Model\Module')->findOneBy(
                array(
                    'author' => 'QSL',
                    'name'   => 'Banner',
                ),
                array(
                    'fromMarketplace' => 'ASC',
                )
            );

            if ($module && !$module->getEnabled()) {
                // Module disabled or not installed
                $this->recommendedModuleURL = $module->getFromMarketplace()
                    ? $module->getMarketplaceURL()
                    : $module->getInstalledURL();
            }

            if (empty($this->recommendedModuleURL)) {
                $this->recommendedModuleURL = '';
            }
        }

        return $this->recommendedModuleURL;
    }

    /**
     * Return text of recommended module URL
     *
     * @return string
     */
    public function getRecommendedModuleText()
    {
        return $this->getRecommendedModuleURL()
            ? static::t('Get a more powerful banner system for your store', array('url' => $this->getRecommendedModuleURL()))
            : '';
    }
}
