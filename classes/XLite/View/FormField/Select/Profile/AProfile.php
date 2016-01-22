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

namespace XLite\View\FormField\Select\Profile;

/**
 * Profile
 */
class AProfile extends \XLite\View\FormField\Select\Regular
{
    /**
     * Widget parameters
     */
    const PARAM_SHOW_ANY_OPTION = 'showAnyOption';

    /**
     * getOptions
     *
     * @return array
     */
    protected function getOptions()
    {
        $list = parent::getOptions();
        if ($this->getParam(static::PARAM_SHOW_ANY_OPTION)) {
            $list = array('' => static::t('Any profile')) + $list;
        }
        return $list;
    }

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_SHOW_ANY_OPTION => new \XLite\Model\WidgetParam\Bool('Display \'Any profile\' option', false),
        );
    }

    /**
     * Return default options list
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $list = array();

        foreach (\XLite\Core\Database::getRepo('XLite\Model\Profile')->findAll() as $profile) {
            $list[$profile->getProfileId()] = $profile->getLogin();
        }

        return $list;
    }

    /**
     * Set common attributes
     *
     * @param array $attrs Field attributes to prepare
     *
     * @return array
     */
    protected function setCommonAttributes(array $attrs)
    {
        return parent::setCommonAttributes($attrs)
            + array(
                'size' => 1,
            );
    }
}
