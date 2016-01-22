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

namespace XLite\Module\XC\PitneyBowes\Logic\Export;

/**
 * Generator
 */
class Generator extends \XLite\Logic\Export\Generator implements \XLite\Base\IDecorator
{
    /**
     * Define steps
     *
     * @return array
     */
    protected function defineSteps()
    {
        return array_merge(
            parent::defineSteps(),
            array(
                'XLite\Module\XC\PitneyBowes\Logic\Export\Step\Categories',
                'XLite\Module\XC\PitneyBowes\Logic\Export\Step\Products',
            )
        );
    }

    /**
     * Returns default pb catalog export options
     * @param array $additional Additional options
     *
     * @return array
     */
    public static function getPBExportOptions($additional = array())
    {
        return array(
            'include'       => array(
                'XLite\Module\XC\PitneyBowes\Logic\Export\Step\Categories',
                'XLite\Module\XC\PitneyBowes\Logic\Export\Step\Products',
            ),
            'copyResources' => false,
            'attrs'         => 'global',
            'delimiter'     => ',',
            'charset'       => 'UTF-8'
        ) + $additional;
    }

    /**
     * Get download files
     *
     * @return array
     */
    public function getCatalogFiles()
    {
        $result = array();

        foreach ($this->getDownloadableFiles() as $path) {
            if (preg_match('/\.csv$/Ss', $path)) {
                $key = basename($path);
                $result[$key] = new \SplFileInfo($path);
            }
        }

        return $result;
    }

    public static function runHeadless()
    {
        static::lockExport();
        $event = static::getEventName();
        $result = false;
        $errors = array();

        do {
            call_user_func('\XLite\Core\EventListener\Export::resetInstance');
            if (\XLite\Core\EventListener::getInstance()->handle($event, array())) {
                $result = true;
            }

            $state = \XLite\Core\Database::getRepo('XLite\Model\TmpVar')->getEventState($event);

            if ($state['state'] == \XLite\Core\EventTask::STATE_FINISHED
                || $state['state'] == \XLite\Core\EventTask::STATE_ABORTED) {
                $result = false;
            }

        } while ($result);

        $errors = \XLite\Core\EventListener::getInstance()->getErrors();

        if ($errors) {
            $result = false;
        }

        \XLite\Core\Database::getEM()->flush();
        static::unlockExport();

        return $result;
    }
}
