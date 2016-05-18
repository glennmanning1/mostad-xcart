<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Nova Horizons
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  X-Cart 5
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\Redirects\Controller\Customer;

/**
 * 404 controller
 */
abstract class PageNotFound extends \XLite\Controller\Customer\PageNotFound implements \XLite\Base\IDecorator
{

    public function handleRequest()
    {
        $source = $_SERVER['REQUEST_URI'];

        $result = \XLite\Core\Database::getRepo('\XLite\Module\NovaHorizons\Redirects\Model\Redirect')->findBy(
            array('target' => $source, 'enabled' => 1),
            null,
            1
        );

        if (!empty($result)) {
            $path = $result[0]->getPath();

            $this->redirect($path);
        }

        parent::handleRequest();
    }
}
