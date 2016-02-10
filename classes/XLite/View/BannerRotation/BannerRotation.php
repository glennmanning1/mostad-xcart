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

namespace XLite\View\BannerRotation;

use \XLite\Logic\BannerRotation\Processor;

/**
 * BannerRotation widget
 *
 * @ListChild (list="center", zone="customer", weight="100")
 */
class BannerRotation extends \XLite\View\AView
{
    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();

        $list[] = 'main';

        return $list;
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'banner_rotation/style.css';

        return $list;
    }

    /**
     * Get JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'banner_rotation/controller.js';

        return $list;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'banner_rotation/body.tpl';
    }

    /**
     * Get images
     *
     * @return array
     */
    protected function getImages()
    {
        $slides = \XLite\Core\Database::getRepo('XLite\Model\BannerRotationSlide')->findBy(
            array('enabled' => true),
            array('position' => 'ASC')
        );

        $images = array_map(
            function($slide) {
                return $slide->getImage();
            },
            $slides
        );

        return array_filter($images);
    }

    /**
     * Is banner rotation enabled
     *
     * @return boolean
     */
    protected function isRotationEnabled()
    {
        return \XLite\Core\Config::getInstance()->BannerRotation->enabled && 1 < count($this->getImages());
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
            && \XLite\Core\Config::getInstance()->BannerRotation->enabled
            && (bool)$this->getImages();
    }

    /**
     * Get commented data
     *
     * @return array
     */
    protected function getCommentedData()
    {
        return array(
            'pause'     => false,
            'interval'  => round(\XLite\Core\Config::getInstance()->BannerRotation->interval * 1000),
        );
    }
}
