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

namespace XLite\Module\XC\PitneyBowes\View\Button;

/**
 * Edit parcel contents popup button
 */
class EditParcel extends \XLite\View\Button\APopupLink
{
    /**
     * Widget parameter names
     */
    const PARAM_PARCEL      = 'entity';

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/PitneyBowes/asn/parcel_details.tpl';
    }

    /**
     * Check if there is no parcel items in parcel
     * Using count because getParcelItmes() returns doctrine colleaction, not an array
     * 
     * @return boolean
     */
    protected function isParcelEmpty()
    {
        return count($this->getParcel()->getParcelItems()) < 1;
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_PARCEL      => new \XLite\Model\WidgetParam\Object(
                'Parcel',
                null,
                true,
                'XLite\Module\XC\PitneyBowes\Model\PBParcel'
            )
        );
    }

    /**
     * Get parcel helper
     * 
     * @return \XLite\Module\XC\PitneyBowes\Model\PBParcel
     */
    protected function getParcel()
    {
        return $this->getParam(static::PARAM_PARCEL);
    }

    /**
     * Return URL parameters to use in AJAX popup
     *
     * @return array
     */
    protected function prepareURLParams()
    {
        return array(
            'target' => 'parcel',
            'widget' => 'XLite\Module\XC\PitneyBowes\View\EditParcel',
            'id' => $this->getParcel()->getId(),
        );
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/PitneyBowes/asn/edit_parcel/button_popup.js';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/PitneyBowes/asn/edit_parcel/style.css';

        return $list;
    }

    /**
     * Return CSS classes
     *
     * @return string
     */
    protected function getClass()
    {
        $editable = $this->getParcel()->getId()
            ? 'editable'
            : '';
        return parent::getClass() . ' edit-parcel-button ' . $editable;
    }
}
