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

namespace XLite\Module\CDev\GoSocial\View\FormField\Select;

/**
 * Use Custom Open Graph selector
 */
class CustomOpenGraph extends \XLite\View\FormField\Input\Text
{
    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/CDev/GoSocial/product.css';

        return $list;
    }

    /**
     * Get a list of JS files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/CDev/GoSocial/product.js';

        return $list;
    }

    /**
     * Return name of the folder with templates
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/CDev/GoSocial';
    }

    /**
     * Return default template
     *
     * @return array
     */
    protected function getFieldTemplate()
    {
        return 'custom_og.tpl';
    }

    /**
     * Get entity object
     *
     * @return \XLite\Model\Product|\XLite\Model\Category
     */
    protected function getEntity()
    {
        switch ($this->getTarget()) {
            case 'product': {
                $result = $this->getProduct();
                break;
            }
            case 'category': {
                $result = $this->getCategory();
                break;
            }
            case 'front_page': {
                $result = \XLite\Core\Database::getRepo('XLite\Model\Category')->getRootCategory();
                break;
            }
            default: {
                $result = null;
            }
        }

        return $result;
    }

    /**
     * Get entity's OpenGraphMetaTags
     *
     * @param boolean $flag Flag
     *
     * @return string
     */
    protected function getOpenGraphMetaTags($flag)
    {
        return $this->getEntity() ? $this->getEntity()->getOpenGraphMetaTags($flag) : '';
    }

    /**
     * Get entity's useCustomOG flag
     *
     * @return string
     */
    protected function getUseCustomOG()
    {
        return $this->getEntity() ? $this->getEntity()->getUseCustomOG() : '';
    }
}
