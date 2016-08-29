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

namespace XLite\Module\Mostad\ImprintingInformation\View;


abstract class AView extends \XLite\View\AView implements \XLite\Base\IDecorator
{

    public function getImprintingAddressSectionData($imprintModel)
    {

        if (!$imprintModel) {
            return array();
        }

        $result = [];

        foreach (\XLite\Module\Mostad\ImprintingInformation\Model\Imprinting::$addressFields as $addressField => $addressFieldTitle) {
            $method = 'get'
                      . \Includes\Utils\Converter::convertToCamelCase($addressField);

            $addressFieldValue = $imprintModel->{$method}();
            $cssFieldName      = 'address-' . $addressField;

            switch ($addressField) {
                case 'state':
                    if ($addressFieldValue) {
                        $addressFieldValue = $addressFieldValue->getCode();
                    }
                    break;
                case 'phone':
                    $addressFieldValue = '(' . $imprintModel->getPhoneCode() . ')' . $addressFieldValue;
                    break;
                case 'fax':
                    $addressFieldValue = '(' . $imprintModel->getFaxCode() . ')' . $addressFieldValue;
                    break;
                default:
            }

            if ($addressFieldValue) {
                $result[ $addressField ] = [
                    'css_class' => $cssFieldName,
                    'title'     => $addressFieldTitle,
                    'value'     => $addressFieldValue,
                ];
            }
        }

        return $result;

    }

}