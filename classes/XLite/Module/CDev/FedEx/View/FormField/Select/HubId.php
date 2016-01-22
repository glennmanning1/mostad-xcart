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

namespace XLite\Module\CDev\FedEx\View\FormField\Select;

/**
 * HUB ID selector for settings page
 */
class HubId extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options for selector
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            '5185' => 'ALPA Allentown',
            '5303' => 'ATGA Atlanta',
            '5281' => 'CHNC Charlotte',
            '5929' => 'COCA Chino',
            '5751' => 'DLTX Dallas',
            '5802' => 'DNCO Denver',
            '5481' => 'DTMI Detroit',
            '5087' => 'EDNJ Edison',
            '5431' => 'GCOH Grove City',
            '5436' => 'GPOH Groveport Ohio',
            '5771' => 'HOTX Houston',
            '5465' => 'ININ Indianapolis',
            '5648' => 'KCKS Kansas City',
            '5902' => 'LACA Los Angeles',
            '5254' => 'MAWV Martinsburg',
            '5379' => 'METN Memphis',
            '5552' => 'MPMN Minneapolis',
            '5531' => 'NBWI New Berlin',
            '5110' => 'NENY Newburgh',
            '5015' => 'NOMA Northborough',
            '5327' => 'ORFL Orlando',
            '5194' => 'PHPA Philadelphia',
            '5854' => 'PHAZ Phoenix',
            '5150' => 'PTPA Pittsburgh',
            '5893' => 'RENV Reno',
            '5958' => 'SACA Sacramento',
            '5843' => 'SCUT Salt Lake City',
            '5983' => 'SEWA Seattle',
            '5631' => 'STMO St. Louis',
        );
    }
}