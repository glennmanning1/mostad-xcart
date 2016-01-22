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

return function()
{
    // Loading data to the database from yaml file
    $yamlFile = __DIR__ . LC_DS . 'post_rebuild.yaml';

    if (\Includes\Utils\FileManager::isFileReadable($yamlFile)) {
        \XLite\Core\Database::getInstance()->loadFixturesFromYaml($yamlFile);
        \XLite\Core\Config::updateInstance();
    }

    // See bug #BUG-2084
    if ((integer) \XLite\Core\Config::getInstance()->General->products_per_page > 100) {
        \XLite\Core\Database::getRepo('\XLite\Model\Config')->createOption(
            array(
                'category' => 'General',
                'name'     => 'products_per_page_max',
                'value'    => \XLite\Core\Config::getInstance()->General->products_per_page
            )
        );
    }

    // Just check if state exists to fix typo, see #BUG-2150
    $stateWithWrongName = \XLite\Core\Database::getRepo('XLite\Model\State')->findOneByCountryAndCode('CA', 'NT');
    if ($stateWithWrongName) {
        $stateWithWrongName->setState('Northwest Territories');
        \XLite\Core\Database::getEM()->persist($stateWithWrongName);
    }

    /** @var \XLite\Model\Repo\Shipping\Method $repo */
    $repo = \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method');
    $methods = $repo->findBy(array('processor' => 'offline', 'carrier' => ''));
    foreach ($methods as $method) {
        $method->setAdded(true);
        $method->setTableType('WSI');
    }

    \XLite\Core\Database::getEM()->flush();
};
