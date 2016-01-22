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

namespace XLite\Module\QSL\CloudSearch\View\ItemsList\Product\Customer;

/**
 * Search
 */
abstract class Search extends \XLite\View\ItemsList\Product\Customer\Search implements \XLite\Base\IDecorator
{
    /**
     * Allowed sort criterions
     */
    const SORT_BY_MODE_RELEVANCE  = 'relevance';


    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        
        if (\XLite\Module\QSL\CloudSearch\Main::doSearch()) {
            $list[] = 'modules/QSL/CloudSearch/search_style.css';
        }
        
        return $list;
    }

    /**
     * Define and set widget attributes; initialize widget
     *
     * @param array $params Widget params OPTIONAL
     *
     * @return void
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params);

        if (\XLite\Module\QSL\CloudSearch\Main::doSearch()) {
            $this->sortByModes = array(
                static::SORT_BY_MODE_RELEVANCE => 'Relevance',
            );
        }
    }

    /**
     * Get products 'sort by' fields
     *
     * @return array
     */
    protected function getSortByFields()
    {
        $result = parent::getSortByFields();
        
        if (\XLite\Module\QSL\CloudSearch\Main::doSearch()) {
            $result = array(
                'relevance' => static::SORT_BY_MODE_RELEVANCE,
            );
        }
        
        return $result;
    }

    /**
     * Defines the CSS class for sorting order arrow
     *
     * @param string $sortBy
     *
     * @return string
     */
    protected function getSortArrowClassCSS($sortBy)
    {
        return static::SORT_BY_MODE_RELEVANCE === $this->getSortBy() ? '' : parent::getSortArrowClassCSS($sortBy);
    }

    /**
     * getSortOrder
     *
     * @return string
     */
    protected function getSortOrder()
    {
        return static::SORT_BY_MODE_RELEVANCE === $this->getSortBy() ? static::SORT_ORDER_DESC : parent::getSortOrder();
    }
    
    /**
     * Return products list
     *
     * @param \XLite\Core\CommonCell $cnd       Search condition
     * @param boolean                $countOnly Return items list or only its size OPTIONAL
     *
     * @return array|integer
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        return (\XLite\Module\QSL\CloudSearch\Main::doSearch() && $cnd->{static::PARAM_SUBSTRING})
            ? \XLite\Core\Database::getRepo('\XLite\Model\Product')->searchViaCloudSearch($cnd, $countOnly)
            : parent::getData($cnd, $countOnly);
    }
}
