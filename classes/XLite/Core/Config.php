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

namespace XLite\Core;

/**
 * DB-based configuration registry
 */
class Config extends \XLite\Base\Singleton
{
    /**
     * Config (runtime cache)
     *
     * @var \XLite\Core\ConfigCell
     */
    protected $config;

    /**
     * Method to access a singleton
     *
     * @return \XLite\Core\ConfigCell
     */
    public static function getInstance()
    {
        return parent::getInstance()->readConfig();
    }

    /**
     * Reset state
     *
     * @return void
     */
    public static function updateInstance()
    {
        parent::getInstance()->readConfig(true);
    }

    /**
     * Read config options
     *
     * @param mixed $force Force OPTIONAL
     *
     * @return \XLite\Core\ConfigCell
     */
    public function readConfig($force = false)
    {
        if (null === $this->config || $force) {
            $config = $this->readFromDatabase($force);

            $this->config = $this->postProcessConfig($config);
        }

        return $this->config;
    }

    /**
     * Read config from database
     *
     * @param boolean $force Force OPTIONAL
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function readFromDatabase($force = false)
    {
        /** @var \XLite\Model\Repo\Config $repo */
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Config');

        return $repo->getAllOptions($force);
    }

    /**
     * Use company address as origin
     *
     * @param \XLite\Core\ConfigCell $config Config
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function mergeCompanyAddressToOrigin($config)
    {
        $config->Company->origin_address        = $config->Company->location_address;
        $config->Company->origin_country        = $config->Company->location_country;
        $config->Company->origin_state          = $config->Company->location_state;
        $config->Company->origin_custom_state   = $config->Company->location_custom_state;
        $config->Company->origin_city           = $config->Company->location_city;
        $config->Company->origin_zipcode        = $config->Company->location_zipcode;

        return $config;
    }

    /**
     * Post process config
     *
     * @param \XLite\Core\ConfigCell $config Config
     *
     * @return \XLite\Core\ConfigCell
     */
    protected function postProcessConfig($config)
    {
        if ($config && $config->General && $config->General->default_admin_language) {
            parent::setDefaultLanguage($config->General->default_admin_language);
        }

        if ($config && $config->Company && $config->Company->origin_use_company) {
            $this->mergeCompanyAddressToOrigin($config);
        }

        // Add human readable store country and state names for Company options
        if (isset($config->Company)) {
            $config->Company->locationCountry = \XLite\Core\Database::getRepo('XLite\Model\Country')
                ->find($config->Company->location_country);

            $hasStates = $config->Company->locationCountry && $config->Company->locationCountry->hasStates();

            $locationState = null;
            if ($hasStates) {
                $locationState = \XLite\Core\Database::getRepo('XLite\Model\State')->find($config->Company->location_state);
            } else {
                $locationState = \XLite\Core\Database::getRepo('XLite\Model\State')->getOtherState($config->Company->location_custom_state);
            }
            $config->Company->locationState = $locationState;

            // Add human readable store country and state names for Origin address options
            $config->Company->originCountry = \XLite\Core\Database::getRepo('XLite\Model\Country')
                ->find($config->Company->origin_country);

            $hasStates = $config->Company->originCountry && $config->Company->originCountry->hasStates();

            $originState = null;
            if ($hasStates) {
                $originState = \XLite\Core\Database::getRepo('XLite\Model\State')->find($config->Company->origin_state);
            } else {
                $originState = \XLite\Core\Database::getRepo('XLite\Model\State')->getOtherState($config->Company->origin_custom_state);
            }
            $config->Company->originState = $originState;
        }

        // Add human readable default country name for General options
        if (isset($config->General)) {
            $config->General->defaultCountry = \XLite\Core\Database::getRepo('XLite\Model\Country')
                ->find($config->Shipping->anonymous_country);
        }

        return $config;
    }

    /**
     * Update and re-read options
     *
     * @return void
     */
    public function update()
    {
        parent::update();

        $this->readConfig(true);
    }
}
