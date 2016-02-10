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

namespace XLite\View\Page;

/**
 * Origin address page view
 */
class OriginAddress extends \XLite\View\Model\Settings
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'origin_address';

        return $result;
    }

    /**
     * Perform some operations when creating fields list by schema
     *
     * @param string $name Node name
     * @param array  $data Field description
     *
     * @return array
     */
    protected function getFieldSchemaArgs($name, array $data)
    {
        $result = parent::getFieldSchemaArgs($name, $data);

        if ($name !== 'origin_use_company') {
            $result[static::SCHEMA_DEPENDENCY] = array(
                static::DEPENDENCY_SHOW => array(
                    'origin_use_company' => array(false),
                ),
            );
        }

        return $result;
    }

    /**
     * Get array of country/states selector fields which should be synchronized
     *
     * @return array
     */
    protected function getCountryStateSelectorFields()
    {
        return array(
            'origin_country' => array(
                'origin_state',
                'origin_custom_state',
            ),
        );
    }
}
