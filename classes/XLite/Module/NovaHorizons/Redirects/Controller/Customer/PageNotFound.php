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
 * @author    Nova Horizons LLC <xcart@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horizons LLC <xcart@novahorizons.io>. All rights reserved
 * @license   https://novahorizons.io/x-cart/license License Agreement
 * @link      https://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\Redirects\Controller\Customer;

/**
 * 404 controller
 */
abstract class PageNotFound extends \XLite\Controller\Customer\PageNotFound implements \XLite\Base\IDecorator
{

    public function handleRequest()
    {
        $this->checkForNovaRedirect();

        parent::handleRequest();
    }
}
