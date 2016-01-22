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

namespace Includes\Decorator\Utils;

/**
 * Cache information driver
 */
abstract class CacheInfo extends \Includes\Decorator\Utils\AUtils
{

    /**
     * Name of data file
     */
    const FILE_NAME = '.cacheInfo';

    /**
     * Data (local cache)
     * 
     * @var   array
     */
    protected static $data = array();

    /**
     * Get data cell
     * 
     * @param string $name Cell name
     * @param mixed  $key  Key OPTIONAL
     *  
     * @return mixed
     */
    public static function get($name, $key = true)
    {
        $data = static::getData($key);

        return isset($data[$name]) ? $data[$name] : null;
    }

    /**
     * Set data cell
     * 
     * @param string $name  Cell name
     * @param mixed  $value Value
     * @param mixed  $key   Key OPTIONAL
     *  
     * @return void
     */
    public static function set($name, $value, $key = true)
    {
        $data = static::getData($key);

        $data[$name] = $value;

        static::setData($data, $key);
    }

    /**
     * Set curernt data as last successfull
     * 
     * @return void
     */
    public static function setDataAsLastSuccessfull()
    {
        static::setData(static::getData(), false);
    }

    /**
     * Remove cache info file
     * 
     * @return void
     */
    public static function remove()
    {
        $path = static::getFilename();

        if (file_exists($path)) {
            unlink($path);
        }
    }

    /**
     * Get file path to data storage file
     *
     * @param mixed $key Key OPTIONAL
     *
     * @return string
     */
    public static function getFilename($key = true)
    {
        return \Includes\Decorator\Utils\CacheManager::buildCopsularFilename(LC_DIR_VAR . static::FILE_NAME, $key);
    }

    /**
     * Get data 
     * 
     * @param mixed $key Key OPTIONAL
     *
     * @return array
     */
    protected static function getData($key = true)
    {
        $dataKey = static::constructDataKey($key);

        if (!isset(static::$data[$dataKey])) {
            $path = static::getFilename($key);
            if (file_exists($path) && is_readable($path)) {
                static::$data[$dataKey] = file_get_contents($path);
                static::$data[$dataKey] = empty(static::$data[$dataKey]) ? array() : @unserialize(static::$data[$dataKey]);
            }

            if (!isset(static::$data[$dataKey]) || !is_array(static::$data[$dataKey])) {
                static::$data[$dataKey] = array();
            }
        }

        return static::$data[$dataKey];
    }

    /**
     * Set data 
     * 
     * @param array $data Data
     * @param mixed $key  Key OPTIONAL
     *  
     * @return void
     */
    protected static function setData(array $data, $key = true)
    {
        $path = static::getFilename($key);

        $key = static::constructDataKey($key);

        static::$data[$key] = $data;

        if (false === @file_put_contents($path, serialize(static::$data[$key]))) {
            \Includes\ErrorHandler::fireError(
                'Unable write to "' . $path . '" file. Please correct the permissions'
            );
        }
    }

    /**
     * Construct data key 
     * 
     * @param mixed $key Key
     *  
     * @return string
     */
    protected static function constructDataKey($key)
    {
        if (true === $key) {
            $key = \Includes\Decorator\Utils\CacheManager::isCapsular()
                ? \Includes\Decorator\Utils\CacheManager::getkey()
                : '_';

        } elseif (false === $key) {
            $key = '_';
        }

        return $key;
    }

}
