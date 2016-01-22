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

function createRegionsForUK()
{
    $gbRegionsFile = __DIR__ . LC_DS . 'gb_regions.yaml';

    if (!\Includes\Utils\FileManager::isFileReadable($gbRegionsFile)) {
        return false;
    }

    \XLite\Core\Database::getInstance()->loadFixturesFromYaml($gbRegionsFile);
    \XLite\Core\Database::getEM()->flush();

    return true;
}

function bindRegionsToUK()
{
    $statesFile = __DIR__ . LC_DS . 'regionForUkStates.yaml';

    if (!\Includes\Utils\FileManager::isFileReadable($statesFile)) {
        return false;
    }

    $data = \Symfony\Component\Yaml\Yaml::parse($statesFile);
    foreach ($data['states'] as $state) {
        $foundByCode = \XLite\Core\Database::getRepo('XLite\Model\State')->findOneBy(array('code' => $state['code']));
        // If we found state with code we should bind region
        if ($foundByCode) {
            $region = \XLite\Core\Database::getRepo('XLite\Model\Region')->findOneBy(array('code' => $state['region']['code']));
            if ($region) {
                $foundByCode->setRegion($region);
            }
        }
    }
    \XLite\Core\Database::getEM()->flush();

    return true;
}

return function()
{
    // Loading data to the database from yaml file
    $yamlFile = __DIR__ . LC_DS . 'post_rebuild.yaml';

    if (\Includes\Utils\FileManager::isFileReadable($yamlFile)) {
        \XLite\Core\Database::getInstance()->loadFixturesFromYaml($yamlFile);
    }

    $repo = \XLite\Core\Database::getRepo('XLite\Model\Country');
    if (
        $repo && $repo->findOneBy(array('code' => 'GB'))
    ) {
        $regionsCreated = createRegionsForUK();

        if ($regionsCreated) {
            bindRegionsToUK();
        }
    }
};
