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

namespace XLite\Module\CDev\USPS\View\FormField\Select;

/**
 * Container selector for settings page
 */
class Container extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options for selector
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            'VARIABLE'                     => 'Variable',
            'FLAT RATE ENVELOPE'           => 'Flat rate envelope',
            'PADDED FLAT RATE ENVELOPE'    => 'Padded flat rate envelope',
            'LEGAL FLAT RATE ENVELOPE'     => 'Legal flat rate envelope',
            'SM FLAT RATE ENVELOPE'        => 'SM flat rate envelope',
            'WINDOW FLAT RATE ENVELOPE'    => 'Window flat rate envelope',
            'GIFT CARD FLAT RATE ENVELOPE' => 'Gift card flat rate envelope',
            'FLAT RATE BOX'                => 'Flat rate box',
            'SM FLAT RATE BOX'             => 'SM flat rate box',
            'MD FLAT RATE BOX'             => 'MD flat rate box',
            'LG FLAT RATE BOX'             => 'LG flat rate box',
            'REGIONALRATEBOXA'             => 'Regional rate boxA',
            'REGIONALRATEBOXB'             => 'Regional rate boxB',
            'RECTANGULAR'                  => 'Rectangular',
            'NONRECTANGULAR'               => 'Non-rectangular',
        );
    }
}
