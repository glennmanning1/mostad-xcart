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

namespace XLite\Module\XC\CanadaPost\Controller\Admin;

/**
 * CanadaPost settings page controller
 */
class Capost extends \XLite\Controller\Admin\ShippingSettings
{
    /**
     * getOptionsCategory
     *
     * @return string
     */
    protected function getOptionsCategory()
    {
        return 'XC\CanadaPost';
    }

    /**
     * Class name for the \XLite\View\Model\ form (optional)
     *
     * @return string|null
     */
    protected function getModelFormClass()
    {
        return 'XLite\Module\XC\CanadaPost\View\Model\Settings';
    }

    /**
     * Get shipping processor
     *
     * @return \XLite\Model\Shipping\Processor\AProcessor
     */
    protected function getProcessor()
    {
        return new \XLite\Module\XC\CanadaPost\Model\Shipping\Processor\CanadaPost();
    }

    /**
     * Do action "Enable merchant registration wizard"
     *
     * @return void
     */
    protected function doActionEnableWizard()
    {
        $options = array(
            'customer_number' => '',
            'contract_id'     => '',
            'user'            => '',
            'password'        => '',
            'quote_type'      => \XLite\Module\XC\CanadaPost\Core\API::QUOTE_TYPE_CONTRACTED,
            'wizard_hash'     => '',
            'wizard_enabled'  => true,
            'developer_mode'  => false,
        );

        /** @var \XLite\Model\Repo\Config $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Config');

        foreach ($options as $name => $value) {
            $repo->createOption(
                array(
                    'category' => $this->getOptionsCategory(),
                    'name'     => $name,
                    'value'    => $value,
                )
            );
        }

        $this->setReturnURL($this->buildURL('capost'));
    }

    /**
     * Get schema of an array for test rates routine
     *
     * @return array
     */
    protected function getTestRatesSchema()
    {
        $schema = parent::getTestRatesSchema();
        foreach (array('srcAddress', 'dstAddress') as $k) {
            unset(
                $schema[$k]['city'],
                $schema[$k]['state']
            );
        }

        unset($schema['dstAddress']['type']);

        return $schema;
    }

    /**
     * Get input data to calculate test rates
     *
     * @param array $schema  Input data schema
     * @param array &$errors Array of fields which are not set
     *
     * @return array
     */
    protected function getTestRatesData(array $schema, &$errors)
    {
        $package = parent::getTestRatesData($schema, $errors);
        $package['srcAddress']['country'] = 'CA';

        $data = array(
            'packages' => array($package),
        );

        return $data;
    }
}
