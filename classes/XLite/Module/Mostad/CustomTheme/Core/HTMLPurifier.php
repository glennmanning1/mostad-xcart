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

namespace XLite\Module\Mostad\CustomTheme\Core;


class HTMLPurifier extends \XLite\Core\HTMLPurifier implements \XLite\Base\IDecorator
{
    public static function getPurifier($force = false)
    {
        if ($force || !isset(static::$purifier)) {
            require_once LC_DIR_LIB . 'htmlpurifier/library/HTMLPurifier.auto.php';
            $config = \HTMLPurifier_Config::createDefault();
            $config->set('Cache.SerializerPath', LC_DIR_DATACACHE);
            // Set some HTML5 properties
            $config->set('HTML.DefinitionID', 'html5-definitions'); // unqiue id
            $config->set('HTML.DefinitionRev', 1);

            // Get additional options from etc/config.php
            $options = \XLite::getInstance()->getOptions('html_purifier');

            if (empty($options)) {
                $options = static::getDefaultOptions();
            }

            $config = static::addConfigOptions($config, $options);

            $def = $config->getHTMLDefinition(true);
            $def->addAttribute('a', 'data-target', 'Text');


            static::$purifier = new \HTMLPurifier($config);
        }

        return static::$purifier;
    }

}