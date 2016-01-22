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

namespace XLite\Module\XC\PitneyBowes\View\ItemsList\Model;

/**
 * Parcels items list
 */
class Parcels extends \XLite\View\ItemsList\Model\Table
{

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return array(
            'number' => array(
                static::COLUMN_CLASS            => '\XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_NAME => static::t('Parcel number'),
            ),
            'parcelDetails' => array(
                static::COLUMN_NAME => static::t('Parcel details'),
                static::COLUMN_CLASS    => '\XLite\Module\XC\PitneyBowes\View\Button\EditParcel',
                static::COLUMN_MAIN => true,
            )
        );
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XC/PitneyBowes/asn/parcels_items_list.css';
        $list[] = 'modules/XC/PitneyBowes/asn/parcel_items_list.css';

        return $list;
    }

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list[] = 'modules/XC/PitneyBowes/asn/parcels_items_list.js';

        return $list;
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\XC\PitneyBowes\Model\PBParcel';
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' pb-parcels';
    }

    /**
     * Get panel class
     *
     * @return \XLite\View\Base\FormStickyPanel
     */
    protected function getPanelClass()
    {
        return 'XLite\Module\XC\PitneyBowes\View\StickyPanel\Parcels';
    }

    /**
     * Get create button label
     *
     * @return string
     */
    protected function getCreateButtonLabel()
    {
        return 'Create parcel';
    }

    /**
     * Template method to determine if creation allowed
     */
    protected function isCreateAllowed()
    {
        return $this->getOrder()->getPbOrder()->isNewParcelAllowed();
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
     * Get top actions
     *
     * @return array
     */
    protected function getTopActions()
    {
        $actions = parent::getTopActions();

        $key = array_search('items_list/model/table/parts/create_inline.tpl', $actions, true);
        if ($key !== false) {
            $actions[$key] = 'modules/XC/PitneyBowes/asn/parcels_create_inline.tpl';
        } else {
            $actions[] = 'modules/XC/PitneyBowes/asn/parcels_create_inline.tpl';
        }


        return $actions;
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
     * Get right actions tempaltes
     *
     * @return array
     */
    protected function getRightActions()
    {
        return array_merge(
            array(
                'modules/XC/PitneyBowes/asn/right_actions/print_label.tpl',
                'modules/XC/PitneyBowes/asn/right_actions/create_asn.tpl',
            ),
            parent::getRightActions()
        );
    }

    /**
     * Create entity
     *
     * @return \XLite\Model\AEntity
     */
    protected function createEntity()
    {
        $entity = parent::createEntity();

        $entity->autoGenerateNumber();
        $entity->setOrder($this->getOrder()->getPbOrder());
        $entity->fillParcelItemsByOrderItems($this->getOrder()->getItems());

        return $entity;
    }

    /**
     * Return params list to use for search
     *
     * @return \XLite\Core\CommonCell
     */
    protected function getSearchCondition()
    {
        $result = parent::getSearchCondition();

        $result->{\XLite\Module\XC\PitneyBowes\Model\Repo\PBParcel::P_ORDER} = $this->getOrder();

        return $result;
    }

    /**
     * Get order
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel ProfileTransaction
     *
     * @return \XLite\Model\Profile
     */
    protected function getParcelDetailsColumnValue(\XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel)
    {
        return $parcel->getParcelItems();
    }

   /**
     * Get order
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel ProfileTransaction
     *
     * @return string
     */
    protected function getParcelId(\XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel)
    {
        return $parcel->getId();
    }

    /**
     * Get order
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel ProfileTransaction
     *
     * @return string
     */
    protected function isDisabledASN(\XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel)
    {
        return $parcel->getCreateAsnCalled() || $parcel->isEmpty();
    }

   /**
     * Get order
     *
     * @param \XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel ProfileTransaction
     *
     * @return string
     */
    protected function getOrderNumber(\XLite\Module\XC\PitneyBowes\Model\PBParcel $parcel)
    {
        return $parcel->getOrder()->getOrder()->getOrderNumber();
    }
}