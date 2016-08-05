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

namespace XLite\Module\NovaHorizons\Redirects\View\FormField\InLine\Input\Text;

class Target extends \XLite\View\FormField\Inline\Input\Text
{
    const VALID_REGEX = "`^/[A-z0-9\-\.\_\~\:\/\?\#\[\]\@\!\$\&\'\(\)\*\+\,\;\=\.]+`";
    /**
     * Validate Target
     *
     * @param array $field Feild info
     *
     * @return array
     */
    protected function validateTarget(array $field)
    {
        $result = array(true, null);
        try {
            $validator = new \XLite\Core\Validator\String\RegExp(true, self::VALID_REGEX);
            $validator->validate($field['widget']->getValue());
        } catch (\Exception $e) {
            $result = array(
                false,
                'Your value must start with a forward slash(/) and may only contain letters, numbers, and URL approved punctuation.'
            );
        }

        return $result;
    }

    /**
     * Validate Path
     *
     * @param array $field Feild info
     *
     * @return array
     */
    protected function validatePath(array $field)
    {
        return $this->validateTarget($field);
    }
}
