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
 * Automate shipping routine page view
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class AutomateShippingRoutine extends \XLite\View\AView
{
    const PROPERTY_VALUE_YES    = 'Y';
    const PROPERTY_VALUE_NO     = 'N';
    const PROPERTY_VALUE_APP_TYPE_CLOUD         = 'C';
    const PROPERTY_VALUE_APP_TYPE_WINDOWS       = 'W';

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), array('automate_shipping_routine'));
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'automate_shipping_routine/body.tpl';
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'automate_shipping_routine/style.css';

        return $list;
    }

    /**
     * Get shipping modules
     * 
     * @return string
     */
    protected function getShippingModulesLink()
    {
        return $this->buildURL(
            'addons_list_marketplace',
            '',
            array(
                'tag'       => 'Shipping',
                'vendor'    => '',
                'price'     => '',
                'substring' => '',
            )
        );
    }

    // {{{ Template methods

    protected function getMarketplaceURL($module)
    {
        list(, $limit) = $this->getWidget(array(), 'XLite\View\Pager\Admin\Module\Install')
            ->getLimitCondition()->limit;
        $pageId = $module->getRepository()->getMarketplacePageId(
            $module->getAuthor(),
            $module->getName(),
            $limit
        );

        $params = array(
            'clearCnd'                                      => 1,
            'clearSearch'                                   => 1,
            \XLite\View\Pager\APager::PARAM_PAGE_ID         => $pageId,
            \XLite\View\ItemsList\AItemsList::PARAM_SORT_BY => \XLite\View\ItemsList\Module\AModule::SORT_OPT_ALPHA,
        );

        return \XLite::getInstance()->getShopURL(
            sprintf('%s#%s', \XLite\Core\Converter::buildURL('addons_list_marketplace', '', $params), $module->getName())
        );
    }

    /**
     * Get shipping modules list
     * 
     * @return array
     */
    protected function getShippingModules()
    {
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Module');

        $modules = array(
            $repo->findOneByModuleName('Qualiteam\\ShippingEasy', true),
            $repo->findOneByModuleName('ShipStation\\Api', true),
            $repo->findOneByModuleName('Webgility\\Shiplark', true),
            $repo->findOneByModuleName('AutomatedShippingRefunds71LBS\\SeventyOnePounds', true),
        );

        return array_filter($modules);
    }

    /**
     * Get shipping module properties list
     * 
     * @return array
     */
    protected function getShippingModuleProperties()
    {
        return array(
            'common' => array(
                'labels'    => static::t('Print Shipping labels'),
                'trial'     => static::t('FREE trial'),
                'refunds'   => static::t('Refunds'),
            ),
            'integrations' => array(
                'ebay'      => static::t('eBay'),
                'amazon'    => static::t('Amazon'),
                'etsy'      => static::t('ETSY'),
                'stamps'    => static::t('Stamps.com'),
                'fedex'     => static::t('FedEx'),
                'ups'       => static::t('UPS'),
                'usps'      => static::t('USPS'),
                'dhl'       => static::t('DHL'),
            ),
            'app' => array(
                'type' => static::t('App type')
            ),
        );
    }

    /**
     * Get shipping module property value
     *
     * @return array
     */
    protected function getShippingModulePropertyDictionary()
    {
        return array(
            'ShippingEasy'  => array(
                'common' => array(
                    'labels'    => static::PROPERTY_VALUE_YES,
                    'trial'     => static::PROPERTY_VALUE_YES,
                    'refunds'   => static::PROPERTY_VALUE_NO,
                ),
                'integrations' => array(
                    'ebay'      => static::PROPERTY_VALUE_YES,
                    'amazon'    => static::PROPERTY_VALUE_YES,
                    'etsy'      => static::PROPERTY_VALUE_YES,
                    'stamps'    => static::PROPERTY_VALUE_NO,
                    'fedex'     => static::PROPERTY_VALUE_YES,
                    'ups'       => static::PROPERTY_VALUE_YES,
                    'usps'      => static::PROPERTY_VALUE_YES,
                    'dhl'       => static::PROPERTY_VALUE_YES,
                ),
                'app' => array(
                    'type' => static::PROPERTY_VALUE_APP_TYPE_CLOUD,
                ),
            ),
            'Api'  => array(
                'common' => array(
                    'labels'    => static::PROPERTY_VALUE_YES,
                    'trial'     => static::PROPERTY_VALUE_YES,
                    'refunds'   => static::PROPERTY_VALUE_NO,
                ),
                'integrations' => array(
                    'ebay'      => static::PROPERTY_VALUE_YES,
                    'amazon'    => static::PROPERTY_VALUE_YES,
                    'etsy'      => static::PROPERTY_VALUE_YES,
                    'stamps'    => static::PROPERTY_VALUE_YES,
                    'fedex'     => static::PROPERTY_VALUE_YES,
                    'ups'       => static::PROPERTY_VALUE_YES,
                    'usps'      => static::PROPERTY_VALUE_YES,
                    'dhl'       => static::PROPERTY_VALUE_YES,
                ),
                'app' => array(
                    'type' => static::PROPERTY_VALUE_APP_TYPE_CLOUD,
                ),
            ),
            'Shiplark'  => array(
                'common' => array(
                    'labels'    => static::PROPERTY_VALUE_YES,
                    'trial'     => static::PROPERTY_VALUE_YES,
                    'refunds'   => static::PROPERTY_VALUE_NO,
                ),
                'integrations' => array(
                    'ebay'      => static::PROPERTY_VALUE_YES,
                    'amazon'    => static::PROPERTY_VALUE_YES,
                    'etsy'      => static::PROPERTY_VALUE_YES,
                    'stamps'    => static::PROPERTY_VALUE_YES,
                    'fedex'     => static::PROPERTY_VALUE_YES,
                    'ups'       => static::PROPERTY_VALUE_YES,
                    'usps'      => static::PROPERTY_VALUE_YES,
                    'dhl'       => static::PROPERTY_VALUE_NO,
                ),
                'app' => array(
                    'type' => static::PROPERTY_VALUE_APP_TYPE_WINDOWS,
                ),
            ),
            'SeventyOnePounds'  => array(
                'common' => array(
                    'labels'    => static::PROPERTY_VALUE_NO,
                    'trial'     => static::PROPERTY_VALUE_YES,
                    'refunds'   => static::PROPERTY_VALUE_YES,
                ),
                'integrations' => array(
                    'ebay'      => static::PROPERTY_VALUE_NO,
                    'amazon'    => static::PROPERTY_VALUE_NO,
                    'etsy'      => static::PROPERTY_VALUE_NO,
                    'stamps'    => static::PROPERTY_VALUE_NO,
                    'fedex'     => static::PROPERTY_VALUE_YES,
                    'ups'       => static::PROPERTY_VALUE_YES,
                    'usps'      => static::PROPERTY_VALUE_NO,
                    'dhl'       => static::PROPERTY_VALUE_NO,
                ),
                'app' => array(
                    'type' => static::PROPERTY_VALUE_APP_TYPE_CLOUD,
                ),
            ),
        );
    }

    /**
     * Get properties group label
     * 
     * @return string
     */
    protected function getGroupLabel($groupKey)
    {
        return 'integrations' === $groupKey
            ? strtoupper(static::t('Integration with'))
            : '';
    }

    /**
     * Check if module has settings form
     * 
     * @param \XLite\Model\Module $module Module
     * 
     * @return boolean
     */
    protected function hasSetting($module)
    {
        return $module->callModuleMethod('showSettingsForm');
    }

    /**
     * Get module logo
     * 
     * @param \XLite\Model\Module $module Module
     * 
     * @return boolean
     */
    protected function getImageURL($module)
    {
        $name = $module->getName();
        $path = sprintf('automate_shipping_routine/images/%s_logo.png', strtolower($name));

        return \XLite\Core\Layout::getInstance()->getResourceWebPath($path) ?: $module->getPublicIconURL();
    }

    /**
     * Check if module has settings form
     * 
     * @param \XLite\Model\Module $module Module
     * 
     * @return boolean
     */
    protected function getSettingsForm($module)
    {
        return $module->getModuleInstalled()->getSettingsForm();
    }

    /**
     * Get shipping module property template by value
     *
     * @param string $value Value of property
     * 
     * @return array
     */
    protected function getPropertyTemplate($value)
    {
        $template = '';

        switch ($value) {
            case static::PROPERTY_VALUE_YES:
                $template = 'automate_shipping_routine/parts/property_yes.tpl';
                break;
            case static::PROPERTY_VALUE_NO:
                $template = 'automate_shipping_routine/parts/property_no.tpl';
                break;
            case static::PROPERTY_VALUE_APP_TYPE_CLOUD:
            case static::PROPERTY_VALUE_APP_TYPE_WINDOWS:
                $template = 'automate_shipping_routine/parts/property_app_type.tpl';
                break;
        }

        return $template;
    }

    /**
     * Get shipping module property icon by value
     *
     * @param string $value Value of property
     * 
     * @return array
     */
    protected function getAppTypeIcon($value)
    {
        return $value == static::PROPERTY_VALUE_APP_TYPE_CLOUD
            ? 'fa-cloud'
            : 'fa-windows';
    }

    /**
     * Get shipping module property icon by value
     *
     * @param string $value Value of property
     * 
     * @return array
     */
    protected function getAppTypeText($value)
    {
        return $value == static::PROPERTY_VALUE_APP_TYPE_CLOUD
            ? static::t('Cloud Service')
            : static::t('Win app');
    }

    /**
     * Get shipping module property value
     * 
     * @param \XLite\Model\Module $module Module
     * @param string $property Property key
     * 
     * @return string
     */
    protected function getShippingModulePropertyValue($module, $type, $property)
    {
        $dict = $this->getShippingModulePropertyDictionary();
        $moduleTypeDict = $dict[$module->getName()][$type];

        return $moduleTypeDict[$property];
    }

    // }}}
}
