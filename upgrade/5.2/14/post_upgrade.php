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
    // Update schema manually with removing duplicates in language_labels table (see BUG-3223, BUG-3251)

    $tableName = \XLite\Core\Database::getInstance()->getTablePrefix() . 'language_labels';

    $conn = \XLite\Core\Database::getEM()->getConnection();

    $stmt = $conn->query('SELECT `name` FROM `' . $tableName . '`');

    $labels = array();
    $duplicates = array();

    while($row = $stmt->fetch()) {

        $name = rtrim($row['name']);

        if (!empty($name) && !isset($labels[$name])) {
            $labels[$name] = true;

        } else {
            $duplicates[] = $row['name'];
        }
    }

    if ($duplicates) {

        $queries = array();
        $queries[] = 'SET UNIQUE_CHECKS=0, FOREIGN_KEY_CHECKS=0';

        foreach ($duplicates as $name) {
            $queries[] = 'DELETE FROM `' . $tableName . '` WHERE `name` = \'' . str_replace('\'', '\\\'', $name) . '\'';
        }

        $queries[] = 'SET UNIQUE_CHECKS=1, FOREIGN_KEY_CHECKS=1';

        \XLite\Core\Database::getInstance()->executeQueries($queries);
    }

};
