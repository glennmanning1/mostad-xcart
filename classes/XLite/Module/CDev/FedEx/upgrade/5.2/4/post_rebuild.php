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

return function() {
    $config = \XLite\Core\Config::getInstance()->CDev->FedEx;
    $fields = array(
        'key',
        'password',
        'account_number',
        'meter_number',
        'test_mode',
        'debug_enabled',
        'fdxe',
        'fdxg',
        'fxsp',
        'packaging',
        'dropoff_type',
        'ship_date',
        'currency_code',
        'currency_rate',
        'max_weight',
        'dg_accessibility',
        'signature',
        'cod_type',
        'opt_saturday_pickup',
        'opt_residential_delivery',
        'send_insured_value',
    );

    $booleanFields = array(
        'test_mode',
        'debug_enabled',
        'fdxe',
        'fdxg',
        'fxsp',
        'opt_saturday_pickup',
        'opt_residential_delivery',
        'send_insured_value',
    );

    $values = array();
    foreach ($fields as $fieldName) {
        $values[$fieldName] = isset($booleanFields[$fieldName])
            ? ('Y' === $config->{$fieldName} || 1 === (int) $config->{$fieldName})
            : $config->{$fieldName};
    }

    $values['dimensions'] = serialize(array($config->dim_length, $config->dim_width, $config->dim_height));

    $yamlFile = __DIR__ . LC_DS . 'post_rebuild.yaml';
    \XLite\Core\Database::getInstance()->loadFixturesFromYaml($yamlFile);

    /** @var \XLite\Model\Repo\Config $repo */
    $repo = \XLite\Core\Database::getRepo('XLite\Model\Config');
    $category = 'CDev\FedEx';

    foreach ($values as $name => $value) {
        $repo->createOption(
            array(
                'category' => $category,
                'name'     => $name,
                'value'    => $value,
            )
        );
    }

    foreach (array('dim_length', 'dim_width', 'dim_height') as $name) {
        $option = $repo->findOneBy(array('name' => $name, 'category' => $category));
        if ($option) {
            \XLite\Core\Database::getEM()->remove($option);
        }
    }

    \XLite\Core\Database::getEM()->flush();
    \XLite\Core\Config::updateInstance();

    /** @var \XLite\Model\Repo\Shipping\Method $repo */
    $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');
    $carrier = $repo->findOnlineCarrier('fedex');
    $processor = new \XLite\Module\CDev\FedEx\Model\Shipping\Processor\FEDEX();
    if ($processor->isConfigured()) {
        $carrier->setAdded(true);
        $carrier->setEnabled(true);
    }

    \XLite\Core\Database::getEM()->flush();
};
