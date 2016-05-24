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

namespace XLite\Module\Mostad\ImprintingInformation\Controller\Customer;


class ModelAddressSelector extends \XLite\Controller\Customer\ACustomer
{
    protected function getData()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Address')->findAllByProfile($this->getProfile());
    }

    protected function formatItem($item)
    {
        return $item;
    }

    protected function getItemValue($item)
    {
        return $item;
    }

    protected function defineDataItem($item)
    {
        return array(
            'presentation' => $this->formatItem($item),
        );
    }

    public function processRequest()
    {
        header('Content-Type: text/html; charset=utf-8');

        \Includes\Utils\Operator::flush($this->getJSONData());
    }

    protected function getJSONData()
    {
        $data = $this->getData();
        array_walk($data, array($this, 'prepareItem'));

        return json_encode(
            array(
                $this->getKey() => (false === $data ? array() : $data),
            )
        );
    }

    public function prepareItem(&$item, $index)
    {
        $item = array(
            'text_presentation'  => $this->formatItem($item),
            'value'              => $this->getItemValue($item),
            'data'               => $this->defineDataItem($item)
        );
    }

    protected function getKey()
    {
        return \XLite\Core\Request::getInstance()->search;
    }

}