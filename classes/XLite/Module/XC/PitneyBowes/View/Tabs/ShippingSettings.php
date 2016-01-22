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

namespace XLite\Module\XC\PitneyBowes\View\Tabs;

/**
 * Tabs related to shipping settings
 */
class ShippingSettings extends \XLite\View\Tabs\ShippingSettings implements \XLite\Base\IDecorator
{
    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/PitneyBowes/settings/style.css';

        return $list;
    }

    /**
     * Initialize handler
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->tabs['catalog_extraction'] = array(
            'weight'   => 400,
            'title'    => 'Catalog extraction',
            'template' => 'modules/XC/PitneyBowes/settings/catalog.tpl',
        );
    }

    /**
     * Sorting the tabs according their weight
     *
     * @return array
     */
    protected function prepareTabs()
    {
        if ($this->getMethod()
            && $this->getMethod()->getProcessorObject()
            && (!$this->getMethod()->getProcessorObject()->isConfigured()
            || $this->getMethod()->getProcessorObject()->getProcessorId() != \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::PROCESSOR_ID)
        ) {
            unset($this->tabs['catalog_extraction']);
        }

        if ($this->getMethod()
            && $this->getMethod()->getProcessorObject()
            && $this->getMethod()->getProcessorObject()->getProcessorId() === \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::PROCESSOR_ID
        ) {
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
        return $target === 'catalog_extraction'
            ? $this->buildURL($target)
            : parent::buildTabURL($target);
    }
}
