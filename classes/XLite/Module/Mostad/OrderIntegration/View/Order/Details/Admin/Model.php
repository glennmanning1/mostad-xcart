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
namespace XLite\Module\Mostad\OrderIntegration\View\Order\Details\Admin;

class Model extends \XLite\View\Order\Details\Admin\Model implements \XLite\Base\IDecorator
{
    public function __construct(array $params, array $sections)
    {
        parent::__construct($params, $sections);
        $this->schemaDefault += [
            'qopOrderId' => [
                self::SCHEMA_CLASS => '\XLite\View\FormField\Label',
                self::SCHEMA_LABEL => 'QOP Order ID',
            ]
        ];
    }


}