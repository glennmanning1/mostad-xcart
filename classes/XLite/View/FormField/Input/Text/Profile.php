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

namespace XLite\View\FormField\Input\Text;

/**
 * Autocomplete profile field
 */
class Profile extends \XLite\View\FormField\Input\Text\Base\Autocomplete
{
    /**
     * Widget params
     */
    const PARAM_PROFILE_ID = 'profileId';

    /**
     * Define widget params
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            self::PARAM_PROFILE_ID => new \XLite\Model\WidgetParam\Int('Profile Id', 0),
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
        $list[] = 'form_field/input/autocomplete/profile.js';

        return $list;
    }

    /**
     * Get dictionary name
     *
     * @return string
     */
    protected function getDictionary()
    {
        return 'profiles';
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->getValueByProfileId() ?: parent::getValue();
    }

    /**
     * Get default profile value
     *
     * @return string
     */
    protected function getValueByProfileId()
    {
        $result = null;

        $profileId = $this->getParam(static::PARAM_PROFILE_ID);

        if (0 < $profileId) {
            $profile = \XLite\Core\Database::getRepo('XLite\Model\Profile')->find($profileId);
            if ($profile) {
                $result = $profile->getName() . ' (' . $profile->getLogin() . ')';
            }
        }

        return $result;
    }
}
