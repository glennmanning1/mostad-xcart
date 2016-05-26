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

return function($status = null)
{
    // Loading data to the database from yaml file
    $yamlFile = __DIR__ . LC_DS . 'post_rebuild.yaml';

    if (\Includes\Utils\FileManager::isFileReadable($yamlFile)) {
        \XLite\Core\Database::getInstance()->loadFixturesFromYaml($yamlFile);
    }

    // Rename 'Order failed' email notification if only it was not renamed by the administator
    $orderFailedNotification = \XLite\Core\Database::getRepo('XLite\Model\Notification')->find('order_failed');
    $orderFailedNotification->setEditLanguage('en');
    if ($orderFailedNotification && $orderFailedNotification->getName() == 'Order failed') {
        $orderFailedNotification->setName('Order declined');
        \XLite\Core\Database::getEM()->persist($orderFailedNotification);
    }

    $method = \XLite\Core\Database::getRepo('XLite\Model\Payment\Method')->findOneBy(
        array(
            'service_name' => 'PhoneOrdering',
        )
    );

    if ($method) {
        $method->setClass('Model\Payment\Processor\PhoneOrdering');
    } else {
        $method = new \XLite\Model\Payment\Method();
        $method->setServiceName('PhoneOrdering');
        $method->setClass('Model\Payment\Processor\PhoneOrdering');
        $method->setAdded(true);
        $method->setEnabled(false);
        $method->setOrderby(30);
        $method->setEditLanguage('en');
        $method->setName('Phone Ordering');
        $method->setDescription('Phone: (555) 555-5555');
        $method->setEditLanguage('ru');
        $method->setName('Заказ по телефону');
        $method->setDescription('Тел. (555) 555-5555');
        \XLite\Core\Database::getEM()->persist($method);
    }

    \XLite\Core\Database::getEM()->flush();

    /** @var \XLite\Model\Repo\Module $repo */
    $repo = \XLite\Core\Database::getRepo('XLite\Model\Module');
    $modules = $repo->findBy(array('installed' => true));
    /** @var \XLite\Model\Module $module */
    foreach ($modules as $module) {
        $module->setIsSkin($module->isSkinModule());
    }
    \XLite\Core\Database::getEM()->flush();

    // Reset 'recent' property for all orders (see XCN-5848)
    $stmt = \XLite\Core\Database::getEM()->getConnection()->prepare(
        'UPDATE ' . \XLite\Core\Database::getRepo('XLite\Model\Order')->getTableName() . ' '
        . 'SET recent = :recent'
    );
    $stmt->bindValue(':recent', 0);
    $stmt->execute();
};
