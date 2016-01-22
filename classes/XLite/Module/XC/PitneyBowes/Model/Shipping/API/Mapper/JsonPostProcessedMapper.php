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

namespace XLite\Module\XC\PitneyBowes\Model\Shipping\API\Mapper;

abstract class JsonPostProcessedMapper extends AMapper
{
    /**
     * Postprocess mapped data
     * 
     * @param mixed $mapped mapped data to postprocess
     * 
     * @return mixed
     */
    protected function postProcessMapped($mapped)
    {
        return defined('JSON_UNESCAPED_UNICODE')
            ? json_encode($mapped, JSON_UNESCAPED_UNICODE)
            : $this->getUnescapedUnicode(json_encode($mapped));
    }

    /**
     * JSON_UNESCAPED_UNICODE Workaround for php 5.3
     * 
     * @param string $escapedInput escapedInput after json_encode()
     * 
     * @return string
     */
    protected function getUnescapedUnicode($escapedInput)
    {
        return preg_replace_callback(
            '/\\\\u(\w{4})/',
            function ($matches) {
                return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
            },
            $escapedInput
        );
    }
}