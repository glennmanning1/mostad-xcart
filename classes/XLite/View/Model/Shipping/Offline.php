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

namespace XLite\View\Model\Shipping;

/**
 * Offline shipping method view model
 */
class Offline extends \XLite\View\Model\AModel
{
    /**
     * Schema default
     *
     * @var array
     */
    protected $schemaDefault = array(
        'name' => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL     => 'Shipping method name',
            self::SCHEMA_REQUIRED  => true,
        ),
        'deliveryTime' => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL     => 'Delivery time',
            self::SCHEMA_HELP      => 'deliveryTime.help',
        ),
        'tableType' => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Select\ShippingTableType',
            self::SCHEMA_LABEL     => 'Table based on',
            self::SCHEMA_HELP      => 'tableType.help',
        ),
        'shippingZone' => array(
            self::SCHEMA_CLASS     => 'XLite\View\FormField\Select\ShippingZone',
            self::SCHEMA_LABEL     => 'Address zone',
            self::SCHEMA_LINK_TEXT => 'Manage zones',
        ),
    );

    /**
     * Return current model ID
     *
     * @return integer
     */
    public function getModelId()
    {
        return \XLite\Core\Request::getInstance()->methodId;
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Shipping\Method
     */
    protected function getDefaultModelObject()
    {
        $model = $this->getModelId()
            ? \XLite\Core\Database::getRepo('XLite\Model\Shipping\Method')->find($this->getModelId())
            : null;

        $model = $model ?: new \XLite\Model\Shipping\Method();
        $model->setEnabled(true);
        $model->setAdded(true);
        $model->setProcessor('offline');

        return $model;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return 'XLite\View\Form\Shipping\Offline';
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        $label = $this->getModelObject()->isPersistent() ? 'Update' : 'Create';

        $result['submit'] = new \XLite\View\Button\Submit(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL    => $label,
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE    => 'action',
            )
        );

        return $result;
    }

    /**
     * Perform some operations when creating fields list by schema
     *
     * @param string $name Node name
     * @param array  $data Field description
     *
     * @return array
     */
    protected function getFieldSchemaArgs($name, array $data)
    {
        $data = parent::getFieldSchemaArgs($name, $data);
        if ('shippingZone' === $name) {
            $data[\XLite\View\FormField\Select\ShippingZone::PARAM_METHOD] = $this->getModelObject();
        }

        return $data;
    }

    /**
     * Returns used zones
     * @todo: add runtime cache
     *
     * @return array
     */
    protected function getUsedZones()
    {
        $list = array();

        $shippingMethod = $this->getModelObject();
        if ($shippingMethod && $shippingMethod->getShippingMarkups()) {
            foreach ($shippingMethod->getShippingMarkups() as $markup) {
                if ($markup->getZone()) {
                    if (!isset($list[$markup->getZone()->getZoneId()])) {
                        $list[$markup->getZone()->getZoneId()] = 1;

                    } else {
                        $list[$markup->getZone()->getZoneId()]++;
                    }
                }
            }
        }

        return $list;
    }

    /**
     * Populate model object properties by the passed data
     *
     * @param array $data Data to set
     *
     * @return void
     */
    protected function setModelProperties(array $data)
    {
        unset($data['shippingZone']);

        parent::setModelProperties($data);
    }

    /**
     * Preparing data for shippingZone param
     *
     * @param array $data Field description
     *
     * @return array
     */
    protected function prepareFieldParamsShippingZone($data)
    {
        $data[static::SCHEMA_LINK_HREF] = $this->buildURL('zones');

        return $data;
    }
}
