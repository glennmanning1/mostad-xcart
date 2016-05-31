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
 * @copyright Copyright (c) 2015 Nova Horizons LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */


namespace XLite\Module\Mostad\OrderIntegration\Model;

use Doctrine\ORM\Mapping\Column;

class Order extends \XLite\Model\Order implements \XLite\Base\IDecorator
{
    /**
     * @Column (type="string", length=32)
     */
    protected $qopOrderId;
    
    
}