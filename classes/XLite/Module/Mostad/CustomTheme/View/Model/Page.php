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

namespace XLite\Module\Mostad\CustomTheme\View\Model;


class Page extends \XLite\Module\CDev\SimpleCMS\View\Model\Page implements \XLite\Base\IDecorator
{
    public function __construct(array $params = [], array $sections = [])
    {
        $this->schemaDefault = array_slice($this->schemaDefault, 0, 2, true)
                               + [
                                   'showPageName' => [
                                       self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Enabled',
                                       self::SCHEMA_LABEL    => 'Show page name on page',
                                       self::SCHEMA_REQUIRED => false,
                                   ]
                               ] + array_slice($this->schemaDefault, 2, count($this->schemaDefault)-2, true);

        parent::__construct($params, $sections);
    }
}