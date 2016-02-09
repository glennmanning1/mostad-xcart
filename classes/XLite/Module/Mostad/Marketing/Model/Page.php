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

namespace XLite\Module\Mostad\Marketing\Model;

/**
 * Page
 *
 * @LC_Dependencies ("CDev\SimpleCMS")
 */
abstract class Page extends \XLite\Module\CDev\SimpleCMS\Model\Page implements \XLite\Base\IDecorator
{

    /**
     * Show Social share buttons or not
     *
     * @var boolean
     *
     * @Column (type="boolean")
     */
    protected $disableLayout = false;

    /**
     * @return boolean
     */
    public function isDisableLayout()
    {
        return $this->disableLayout;
    }

    /**
     * @param boolean $disableLayout
     *
     * @return Page
     */
    public function setDisableLayout($disableLayout)
    {
        $this->disableLayout = $disableLayout ? 1 : 0;

        return $this;
    }
}