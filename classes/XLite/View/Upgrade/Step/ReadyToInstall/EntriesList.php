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

namespace XLite\View\Upgrade\Step\ReadyToInstall;

/**
 * EntriesList
 */
class EntriesList extends \XLite\View\Upgrade\Step\ReadyToInstall\AReadyToInstall
{
    /**
     * List of files and dirs with wrong permissions
     *
     * @var array
     */
    protected $wrongPermissions;

    /**
     * Get directory where template is located (body.tpl)
     *
     * @return string
     */
    protected function getDir()
    {
        return parent::getDir() . '/entries_list';
    }

    /**
     * Return internal list name
     *
     * @return string
     */
    protected function getListName()
    {
        return parent::getListName() . '.entries_list';
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return 'Downloaded components';
    }

    /**
     * Return wrong permissions
     *
     * @return array
     */
    protected function getWrongPermissions()
    {
        if (!isset($this->wrongPermissions)) {
            $wrongEntries = array(
                'files' => array(),
                'dirs' => array(),
            );

            $common = $this->getCommonFolders();

            foreach ($this->getUpgradeEntries() as $entry) {
                foreach ($entry->getWrongPermissions() as $path) {
                    foreach ($common as $folder => $processed) {
                        if (false !== strpos($path, $folder)) {
                            if (\Includes\Utils\FileManager::isDir($path) && !$processed['dirs']) {
                                $this->wrongPermissions[] = 'find ' . $folder . ' -type d -execdir chmod 777 "{}" \\;;';
                                $common[$folder]['dirs'] = true;
                            } elseif (\Includes\Utils\FileManager::isFile($path) && !$processed['files']) {
                                $this->wrongPermissions[] = 'find ' . $folder . ' -type f -execdir chmod 666 "{}" \\;;';
                                $common[$folder]['files'] = true;
                            }
                            continue 2;
                        }
                    }
                    if (\Includes\Utils\FileManager::isDir($path)) {
                        $wrongEntries['dirs'][] = $path;

                    } else {
                        $wrongEntries['files'][] = $path;
                    }
                }
            }

            foreach ($wrongEntries as $type => $paths) {
                if ($paths) {
                    $permission = ($type == 'dirs') ? '777' : '666';
                    $this->wrongPermissions[] = 'chmod ' . $permission . ' ' . implode(' ', array_unique($paths)) . ';';
                }
            }
        }

        return $this->wrongPermissions;
    }

    /**
     * Return wrong permissions
     *
     * @return array
     */
    protected function getCommonFolders()
    {
        return array(
            rtrim(LC_DIR_CLASSES, '/') => false,
            rtrim(LC_DIR_SKINS, '/') => false,
            rtrim(LC_DIR_INCLUDES, '/') => false,
            LC_DIR_ROOT . 'sql' => false,
        );
    }

    /**
     * Return wrong permissions as string
     *
     * @return string
     */
    protected function getWrongPermissionsAsString()
    {
        $list = $this->getWrongPermissions();

        return $list ? implode('\\' . PHP_EOL, $list) : '';
    }
}
