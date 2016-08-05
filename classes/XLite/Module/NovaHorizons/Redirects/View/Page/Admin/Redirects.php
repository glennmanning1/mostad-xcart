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
 * @author    Nova Horizons LLC <xcart@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horizons LLC <xcart@novahorizons.io>. All rights reserved
 * @license   https://novahorizons.io/x-cart/license License Agreement
 * @link      https://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\Redirects\View\Page\Admin;

/**
 * Redirects page view
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class Redirects extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(
            parent::getAllowedTargets(),
            array('redirects')
        );
    }

    /**
     * Return widget default etmplate
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/NovaHorizons/Redirects/page/redirects/body.tpl';
    }

    public function getCSSFiles()
    {
        return array_merge(
            parent::getCSSFiles(),
            array(
                'modules/NovaHorizons/Redirects/styles/style.css',
            )
        );
    }
}
