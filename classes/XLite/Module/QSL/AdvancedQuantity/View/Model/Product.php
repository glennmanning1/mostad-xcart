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

namespace XLite\Module\QSL\AdvancedQuantity\View\Model;

/**
 * Product view model
 */
class Product extends \XLite\View\Model\Product implements \XLite\Base\IDecorator
{

    /**
     * @inheritdoc
     */
    public function __construct(array $params = array(), array $sections = array())
    {
        $this->schemaDefault['fraction_length'] = array(
            static::SCHEMA_CLASS    => 'XLite\Module\QSL\AdvancedQuantity\View\FormField\Input\Text\FractionLength',
            static::SCHEMA_LABEL    => 'Length of fractional part of quantity',
            static::SCHEMA_REQUIRED => false,
        );
        $this->schemaDefault['quantity_units'] = array(
            static::SCHEMA_CLASS                              => 'XLite\View\FormField\ItemsList',
            static::SCHEMA_LABEL                              => 'Quantity units',
            \XLite\View\FormField\ItemsList::PARAM_LIST_CLASS => 'XLite\Module\QSL\AdvancedQuantity\View\ItemsList\Model\QuantityUnit',
            static::SCHEMA_REQUIRED                           => false,
        );
        $this->schemaDefault['quantity_sets'] = array(
            static::SCHEMA_CLASS                              => 'XLite\View\FormField\ItemsList',
            static::SCHEMA_LABEL                              => 'Allowed quantities',
            \XLite\View\FormField\ItemsList::PARAM_LIST_CLASS => 'XLite\Module\QSL\AdvancedQuantity\View\ItemsList\Model\QuantitySet',
            static::SCHEMA_REQUIRED                           => false,
        );

        $this->schemaDefault['qty'][static::SCHEMA_CLASS] = 'XLite\Module\QSL\AdvancedQuantity\View\FormField\Input\Text\Quantity';
        $this->schemaDefault['qty']['product'] = $this->getModelObject();

        parent::__construct($params, $sections);
    }

    /**
     * @inheritdoc
     */
    protected function setModelProperties(array $data)
    {
        parent::setModelProperties($data);

        $list = new \XLite\Module\QSL\AdvancedQuantity\View\ItemsList\Model\QuantitySet();
        $list->processQuick();

        $list = new \XLite\Module\QSL\AdvancedQuantity\View\ItemsList\Model\QuantityUnit();
        $list->processQuick();

    }

}