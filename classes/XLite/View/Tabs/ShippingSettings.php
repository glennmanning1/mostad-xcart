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

namespace XLite\View\Tabs;

/**
 * Tabs related to shipping settings
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class ShippingSettings extends \XLite\View\Tabs\ATabs
{
    /**
     * Description of tabs related to shipping settings and their targets
     *
     * @var array
     */
    protected $tabs = array(
        'shipping_settings' => array(
            'weight'   => 100,
            'title'    => 'Settings',
            'template' => 'shipping/settings.tpl',
        ),
        'shipping_methods' => array(
            'weight'   => 200,
            'title'    => 'Carrier services',
            'template' => 'shipping/methods.tpl',
        ),
        'shipping_test' => array(
            'weight'   => 300,
            'title'    => 'Test rates',
            'template' => 'shipping/test.tpl',
        ),
    );

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'shipping/style.css';

        return $list;
    }

    /**
     * Initialize handler
     *
     * @return void
     */
    public function init()
    {
        $controller = \XLite::getController();

        if ($controller instanceof \XLite\Controller\Admin\ShippingSettings
            && isset($this->tabs['shipping_settings'])
        ) {
            $this->tabs[\XLite\Core\Request::getInstance()->target] = $this->tabs['shipping_settings'];
            unset($this->tabs['shipping_settings']);
        }
    }

    /**
     * Sorting the tabs according their weight
     *
     * @return array
     */
    protected function prepareTabs()
    {
        $method = $this->getMethod();

        if ($method
            && !$method->getProcessorObject()->isConfigured()
        ) {
            unset($this->tabs['shipping_methods'], $this->tabs['shipping_test']);
        }

        if (isset($this->tabs['shipping_methods']) && count($method->getChildrenMethods()) === 1) {
            unset($this->tabs['shipping_methods']);
        }

        return parent::prepareTabs();
    }

    /**
     * Returns tab URL
     *
     * @param string $target Tab target
     *
     * @return string
     */
    protected function buildTabURL($target)
    {
        switch ($target) {
            case 'shipping_settings':
                $result = $this->getMethod()->getProcessorObject()->getSettingsURL();
                break;

            case 'shipping_methods':
            case 'shipping_test':
                $params = array('processor' => $this->getProcessorId());
                $result = $this->buildURL($target, '', $params);
                break;

            default:
                $result = parent::buildURL($target);
        }

        return $result;
    }

    /**
     * Returns settings template
     *
     * @return string
     */
    protected function getSettingsTemplate()
    {
        $method = $this->getMethod();

        return $method->getProcessorObject()->getSettingsTemplate();
    }

    /**
     * Returns test template
     *
     * @return string
     */
    protected function getTestTemplate()
    {
        $method = $this->getMethod();

        return $method->getProcessorObject()->getTestTemplate();
    }

    /**
     * Returns shipping method
     *
     * @return null|\XLite\Model\Shipping\Method
     */
    protected function getMethod()
    {
        return \XLite::getController()->getMethod();
    }

    /**
     * Returns shipping method
     *
     * @return null|integer
     */
    protected function getProcessorId()
    {
        return \XLite::getController()->getProcessorId();
    }

    /**
     * Checks whether the widget is visible, or not
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible() && $this->getMethod();
    }
}
