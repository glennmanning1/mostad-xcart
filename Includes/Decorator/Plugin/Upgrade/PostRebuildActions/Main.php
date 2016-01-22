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

namespace Includes\Decorator\Plugin\Upgrade\PostRebuildActions;

/**
 * Main
 */
class Main extends \Includes\Decorator\Plugin\APlugin
{
    const STEP_TTL = 10;

    /**
     * Execute certain hook handle
     *
     * @return void
     */
    public function executeHookHandler()
    {
        if (\XLite\Upgrade\Cell::getInstance()->isUpgraded()) {
            $entries = \XLite\Upgrade\Cell::getInstance()->getEntries();
            if ($entries) {
                \Includes\Utils\Operator::showMessage('', true, false);

                /** @var \XLite\Upgrade\Entry\AEntry $entry */
                foreach ($entries as $entry) {
                    if (!$entry->isPostUpgradeActionsCalled()) {
                        $message = '...Invoke actions for ' . $entry->getActualName();
                        \Includes\Decorator\Utils\CacheManager::logMessage(PHP_EOL);
                        \Includes\Decorator\Utils\CacheManager::logMessage($message);

                        $isInvoked = \XLite\Upgrade\Cell::getInstance()->runHelper($entry, 'post_rebuild');

                        if ($isInvoked && \XLite\Upgrade\Cell::getInstance()->getHookRedirect()) {
                            break;
                        }

                        if (!\XLite\Upgrade\Cell::getInstance()->hasUnfinishedUpgradeHooks('post_rebuild', $entry)) {
                            // All post-rebuild hooks completed, run the rest actions...
                            \XLite\Upgrade\Cell::getInstance()->runCommonHelper($entry, 'add_labels');
                            \XLite\Upgrade\Cell::getInstance()->callInstallEvent($entry);
                            $entry->setPostUpgradeActionsCalled();
                        }

                        if (\Includes\Decorator\Utils\CacheManager::isTimeExceeds(static::STEP_TTL)) {
                            break;
                        }
                    }
                }
            }
        }

        \Includes\Decorator\Utils\CacheManager::logMessage(PHP_EOL);

        \XLite\Core\Database::getEM()->flush();
        \XLite\Core\Database::getEM()->clear();
    }
}
