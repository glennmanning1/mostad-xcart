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
 * News messages page view
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class Accounting extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), array('accounting'));
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'accounting/body.tpl';
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'accounting/style.css';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'accounting/controller.js';

        return $list;
    }

    // {{{ Template methods

    /**
     * Get marketplace module page link
     * 
     * @param string $moduleName    Module name
     * @param string $tag           Tag name    OPTIONAL
     * 
     * @return string
     */
    protected function getModuleLink($moduleName, $tag = 'Accounting')
    {
        return $this->buildURL(
            'addons_list_marketplace',
            '',
            array(
                'tag'           => $tag,
                'substring'     => $moduleName,
            )
        );
    }

    /**
     * Get available modules
     * 
     * @return array
     */
    protected function getAvailableModules()
    {
        return array(
            array(
                'img' => array(
                    'alt' => 'QuickBooks',
                    'src' => 'accounting/images/qb_logo.jpg',
                ),
                'link' => array(
                    'name' => 'QuickBooks',
                    'href' => $this->getModuleLink('QuickBooks'),
                ),
            ),
            array(
                'img' => array(
                    'alt' => 'Xero integration',
                    'src' => 'accounting/images/xero_logo.jpg',
                ),
                'link' => array(
                    'name' => 'Xero integration',
                    'href' => $this->getModuleLink('Xero'),
                ),
            ),
            array(
                'img' => array(
                    'alt' => '1C integration',
                    'src' => 'accounting/images/1c_logo.jpg',
                ),
                'link' => array(
                    'name' => '1C integration',
                    'href' => $this->getModuleLink('1C'),
                ),
            ),
        );
    }

    protected function getExportNode()
    {
        return array(
            'img' => array(
                'alt' => static::t('Export orders'),
                'src' => 'accounting/images/export.jpg',
            ),
            'link' => array(
                'name' => static::t('Export orders'),
                'href' => $this->buildURL('export', '', array(\XLite\View\Export\Begin::PARAM_PRESELECT => 'XLite\Logic\Export\Step\Orders')),
            ),
        );
    }

    /**
     * Get available modules
     * 
     * @return array
     */
    protected function getInstalledModules()
    {
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Module');

        $cnd = new \XLite\Core\CommonCell;
        $cnd->{\XLite\Model\Repo\Module::P_TAG} = 'accounting';
        $cnd->{\XLite\Model\Repo\Module::P_FROM_MARKETPLACE} = true;

        $modules = $repo->search($cnd);

        $installedModules = array_filter(
            $modules,
            function($module) {
                return $module->isInstalled();
            }
        );

        return array_map(
            function($module) use ($repo) {
                return $repo->getModuleInstalled($module);
            },
            $installedModules
        );
    }

    /**
     * Is configured
     * 
     * @return boolean
     */
    protected function isConfigured()
    {
        return (bool) $this->getInstalledModules();
    }

    // }}}
}
