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

namespace XLite\Module\CDev\XMLSitemap\Core\Task;

/**
 * Scheduled task that sends automatic cart reminders.
 */
class GenerateSitemap extends \XLite\Core\Task\Base\Periodic
{
    const INT_1_DAY     = 86400;

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Generate sitemap');
    }

    /**
     * Run step
     *
     * @return void
     */
    protected function runStep()
    {
        $generator = \XLite\Module\CDev\XMLSitemap\Logic\SitemapGenerator::getInstance();
        $generator->generate();
    }

    /**
     * Get period (seconds)
     *
     * @return integer
     */
    protected function getPeriod()
    {
        return static::INT_1_DAY;
    }
}