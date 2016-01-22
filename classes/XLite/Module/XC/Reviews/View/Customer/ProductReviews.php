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

namespace XLite\Module\XC\Reviews\View\Customer;

/**
 * Reviews list widget
 *
 * @ListChild (list="center", zone="customer")
 */
class ProductReviews extends \XLite\View\Dialog
{
    /**
     * Reviews list (cache)
     *
     * @var array
     */
    protected $reviews = null;

    /**
     * Reviews total count
     *
     * @var integer
     */
    protected $totalCount = null;

    /**
     * Conditions (cache)
     *
     * @var array
     */
    protected $conditions = null;


    /**
     * Return list of targets allowed for this widget
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $result = parent::getAllowedTargets();
        $result[] = 'product_reviews';

        return $result;
    }

    /**
     * Get condition
     *
     * @param string $name Condition name
     *
     * @return mixed
     */
    public function getCondition($name)
    {
        return $this->getConditions()->$name;
    }

    /**
     * Check - used conditions is default or not
     *
     * @return boolean
     */
    public function isDefaultConditions()
    {
        return false;
    }

    /**
     * Get reviews
     *
     * @return array(\XLite\Module\XC\Reviews\Model\Review)
     */
    public function getReviews()
    {
        if (!isset($this->reviews)) {
            $this->reviews = \XLite\Core\Database::getRepo('\XLite\Module\XC\Reviews\Model\Review')
                ->search($this->getConditions());
        }

        return $this->reviews;
    }

    /**
     * Get reviews count
     *
     * @return integer
     */
    public function getCount()
    {
        return count($this->getReviews());
    }

    /**
     * Get total count
     *
     * @return integer
     */
    public function getTotalCount()
    {
        if (!isset($this->totalCount)) {
            $this->totalCount = count($this->getReviews());
        }

        return $this->totalCount;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/Reviews/form_field/input/rating/rating.js';

        return $list;
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/XC/Reviews/review/style.css';
        $list[] = 'modules/XC/Reviews/form_field/input/rating/rating.css';

        return $list;
    }

    /**
     * Return title
     *
     * @return string
     */
    protected function getHead()
    {
        return null;
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/XC/Reviews';
    }

    /**
     * Get conditions
     *
     * @return array
     */
    protected function getConditions()
    {
        if (!isset($this->conditions)) {
            $this->conditions = \XLite\Core\Session::getInstance()->reviews_search;

            if (!is_array($this->conditions)) {
                $this->conditions = array();
                \XLite\Core\Session::getInstance()->reviews_search = $this->conditions;
            }
        }

        $cnd = new \XLite\Core\CommonCell();

        if (!isset($this->conditions['sortCriterion']) || !$this->conditions['sortCriterion']) {
            $this->conditions['sortCriterion'] = 'datetime';
        }

        if (!isset($this->conditions['sortOrder']) || !$this->conditions['sortOrder']) {
            $this->conditions['sortOrder'] = 'DESC';
        }

        $cnd->orderBy = array('r.' . $this->conditions['sortCriterion'], $this->conditions['sortOrder']);

        return $cnd;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'modules/XC/Reviews/reviews_page/body.tpl';
    }
}
