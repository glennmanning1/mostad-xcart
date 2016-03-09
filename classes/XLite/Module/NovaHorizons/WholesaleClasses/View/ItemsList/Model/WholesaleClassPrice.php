<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Nova Horizons
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  X-Cart 5
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/x-cart/license License Agreement
 * @link      http://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\WholesaleClasses\View\ItemsList\Model;


class WholesaleClassPrice  extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list   = parent::getCSSFiles();
        $list[] = 'modules/CDev/Wholesale/pricing/style.css';

        return $list;
    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return [
            'quantityRangeBegin' => [
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Quantity range'),
                static::COLUMN_CLASS   => 'XLite\Module\CDev\Wholesale\View\FormField\QuantityRangeBegin',
                static::COLUMN_ORDERBY => 100,
            ],
            'price'              => [
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Price'),
                static::COLUMN_CLASS   => 'XLite\Module\CDev\Wholesale\View\FormField\Price',
                static::COLUMN_ORDERBY => 200,
            ],
            'membership'         => [
                static::COLUMN_NAME    => \XLite\Core\Translation::lbl('Membership'),
                static::COLUMN_CLASS   => 'XLite\Module\CDev\Wholesale\View\FormField\Membership',
                static::COLUMN_ORDERBY => 300,
            ],
        ];
    }

    /**
     * getRightActions
     *
     * @return array
     */
    protected function getRightActions()
    {
        $list = parent::getRightActions();

        foreach ($list as $k => $v) {
            if ('items_list/model/table/parts/remove.tpl' == $v) {
                $list[ $k ] = 'modules/CDev/Wholesale/pricing/parts/remove.tpl';
            }
        }

        return $list;
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice';
    }

    /**
     * Return class name for the list pager
     *
     * @return string
     */
//    protected function getPagerClass()
//    {
//        return 'XLite\View\Pager\Admin\Model\Infinity';
//    }

    /**
     * Get create button label
     *
     * @return string
     */
    protected function getCreateButtonLabel()
    {
        return 'New tier';
    }

    /**
     * Mark list as switchable (enable / disable)
     *
     * @return boolean
     */
    protected function isDisplayWithEmptyList()
    {
        return true;
    }

    /**
     * Mark list as switchable (enable / disable)
     *
     * @return boolean
     */
    protected function isSwitchable()
    {
        return false;
    }

    /**
     * Mark list as removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return true;
    }

    /**
     * Inline creation mechanism position
     *
     * @return integer
     */
    protected function isInlineCreation()
    {
        return static::CREATE_INLINE_TOP;
    }

    /**
     * Get list name suffixes
     *
     * @return array
     */
    protected function getListNameSuffixes()
    {
        return ['wholesalePrices'];
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' wholesale-prices';
    }

    /**
     * createEntity
     *
     * @return \XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();

        $entity->set = $this->getSet();

        return $entity;
    }

    /**
     * Return true if entity is removable
     *
     * @param \XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice $entity Wholesale price object
     *
     * @return boolean
     */
    protected function isRemovableEntity($entity)
    {
        return !$entity->isDefaultPrice();
    }

    // {{{ Data

    /**
     * Return wholesale prices
     *
     * @param \XLite\Core\CommonCell $cnd Search condition
     * @param boolean $countOnly Return items list or only its size OPTIONAL
     *
     * @return array|integer
     */
    protected function getData(\XLite\Core\CommonCell $cnd, $countOnly = false)
    {
        // Search wholesale prices to display in the items list
        $cnd->{\XLite\Module\NovaHorizons\WholesaleClasses\Model\Repo\WholesaleClassPrice::P_SET}                 = $this->getSet();
        $cnd->{\XLite\Module\NovaHorizons\WholesaleClasses\Model\Repo\WholesaleClassPrice::P_ORDER_BY_MEMBERSHIP} = true;
        $cnd->{\XLite\Module\NovaHorizons\WholesaleClasses\Model\Repo\WholesaleClassPrice::P_ORDER_BY}
                                                                                                                  = [
            'w.quantityRangeBegin',
            'ASC'
        ];

        return \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice')
            ->search($cnd, $countOnly);
    }

    /**
     * Return default price
     *
     * @return mixed
     */
    protected function getDefaultPrice()
    {
        return 0;
    }

    /**
     * Get page data
     *
     * @return array
     */
    protected function getPageData()
    {
        $result = parent::getPageData();

        return $result;
    }

    /**
     * Check if there are any results to display in list
     *
     * @return boolean
     */
    protected function hasResults()
    {
        return true;
    }

    // }}}

    /**
     * Get URL common parameters
     *
     * @return array
     */
    protected function getCommonParams()
    {
        $this->commonParams                   = parent::getCommonParams();
        $this->commonParams['pricing_set_id'] = \XLite\Core\Request::getInstance()->pricing_set_id;

        return $this->commonParams;
    }

    /**
     * Define request data
     * Remove duplicate by quantity and membership entities
     *
     * @return array
     */
    protected function defineRequestData()
    {
        $requestData = parent::defineRequestData();

        $delete = isset($requestData['delete']) ? $requestData['delete'] : [];
        $new    = isset($requestData['new']) ? $requestData['new'] : [];
        $data   = isset($requestData['data']) ? $requestData['data'] : [];

        foreach ($new as $id => $value) {
            $tier = $this->getTierByQuantityAndMembership($value['quantityRangeBegin'], $value['membership']);

            if (
                $tier
                && !isset($delete[ $tier->getId() ])
                && 0 > $id
            ) {
                $data[ $tier->getId() ] = [
                    'quantityRangeBegin' => $value['quantityRangeBegin'],
                    'price'              => $value['price'],
                    'membership'         => $value['membership']
                ];

                unset($new[ $id ]);

            } elseif (0 == $id) {
                unset($new[ $id ]);
            }
        }

        foreach ($data as $id => $value) {
            $tier = $this->getTierByQuantityAndMembership($value['quantityRangeBegin'], $value['membership']);

            if (
                $tier
                && $tier->getId() !== $id
                && !isset($delete[ $tier->getId() ])
            ) {
                $data[ $tier->getId() ] = [
                    'quantityRangeBegin' => $value['quantityRangeBegin'],
                    'price'              => $value['price'],
                    'membership'         => $value['membership']
                ];

                $delete[ $id ] = true;
                unset($data[ $id ]);
            }
        }

        $requestData = array_merge(
            $requestData,
            [
                'new'    => $new,
                'delete' => $delete,
                'data'   => $data,
            ]
        );

        return $requestData;
    }

    /**
     * Get tier by quantity and membership
     *
     * @param integer $quantity Quantity
     * @param integer $membership Membership
     *
     * @return \XLite\Module\NovaHorizons\CategoryWholesale\Model\WholesalePrice
     */
    protected function getTierByQuantityAndMembership($quantity, $membership)
    {
        return \XLite\Core\Database::getRepo('\XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPrice')
            ->findOneBy(
                [
                    'quantityRangeBegin' => $quantity,
                    'membership'         => $membership ?: null,
                    'set'                => $this->getSet(),
                ]
            );
    }


    protected function getSet()
    {
        $this->getCommonParams();

        if (!$this->commonParams['pricing_set_id'] instanceof \XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet) {
            $pricingSet = \XLite\Core\Database::getRepo('\XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet')
                ->find($this->commonParams['pricing_set_id']);

            $this->commonParams['pricing_set_id'] = $pricingSet;
        }

        return $this->commonParams['pricing_set_id'];

    }
}