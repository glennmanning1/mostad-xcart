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

namespace XLite\Module\NovaHorizons\Redirects\View\ItemList\Model;

class Redirect extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\NovaHorizons\Redirects\Model\Redirect';
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'target' => array(
                static::COLUMN_CLASS   => 'XLite\Module\NovaHorizons\Redirects\View\FormField\InLine\Input\Text\Target',
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Target'),
                static::COLUMN_ORDERBY => 100,
            ),
            'path' => array(
                static::COLUMN_CLASS   => 'XLite\Module\NovaHorizons\Redirects\View\FormField\InLine\Input\Text\Target',
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Destination'),
                static::COLUMN_ORDERBY => 200,
            )
        );
    }

    protected function isSwitchable()
    {
        return true;
    }

    protected function isRemoved()
    {
        return true;
    }

    protected function isInlineCreation()
    {
        return static::CREATE_INLINE_BOTTOM;
    }

    protected function getCreateURL()
    {
        return \XLite\Core\Converter::buildUrl('redirects');
    }

    protected function getCreateButtonLabel()
    {
        return 'Add';
    }
}
