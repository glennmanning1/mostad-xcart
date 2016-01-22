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

namespace XLite\Module\XC\PitneyBowes\View\Model;

/**
 * Category view model
 */
class AdditionalDetails extends \XLite\View\Model\AModel
{
    /**
     * Schema default
     *
     * @var array
     */
    protected $schemaDefault = array(
        'country_of_origin' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Select\Country',
            self::SCHEMA_LABEL    => 'Country',
            self::SCHEMA_REQUIRED => false,
        ),
        'product_condition' => array(
            self::SCHEMA_CLASS    => 'XLite\Module\XC\PitneyBowes\View\FormField\Select\ProductCondition',
            self::SCHEMA_LABEL    => 'Condition',
            self::SCHEMA_REQUIRED => false,
        ),
        'code_separator' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Separator\Regular',
            self::SCHEMA_LABEL    => 'Product codes',
        ),
        'gtin' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'GTIN',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_HELP  => 'Global Trade Identification Number',
            \XLite\View\FormField\Input\Text::PARAM_MAX_LENGTH => 25,
        ),
        'gpc' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'GPC',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_HELP  => 'Global Product Code. The GPC Brick code is a unique identifier that ties each GTIN (unique commodity identifier) to the leaf level (brick) of the generic category tree designed, maintained and published by GS1.',
        ),
        'hs_code' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'HS-6 code',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_HELP  => 'The partial (HS-6) or fully qualified Harmonized Tariff System Code (HS-10 generally). Note some countries (Singapore) require an alpha numeric check digit.',
            \XLite\View\FormField\Input\Text::PARAM_MAX_LENGTH => 6,
        ),
        'mpn' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Part Number',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_HELP  => 'Uniquely identifies the product to its Original Equipment Manufacturer',
        ),
        'model_number' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Model Number',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_HELP  => 'Generally same as the Vendor Stock number, except for Electronics, Appliances, Outdoor Sports, Fitness and Sports categories',
        ),
        'stock_number' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Text',
            self::SCHEMA_LABEL    => 'Manufacturer Stock Number',
            self::SCHEMA_REQUIRED => false,
            self::SCHEMA_HELP  => 'For Electronics and Video Game products, Manufacturer Stock Number is usually different from Vendor Stock Number and Model Number',
        ),
        'details_separator' => array(
            self::SCHEMA_CLASS    => 'XLite\View\FormField\Separator\Regular',
            self::SCHEMA_LABEL    => 'Product details',
        ),
        'battery' => array(
            self::SCHEMA_CLASS    => 'XLite\Module\XC\PitneyBowes\View\FormField\Select\BatteryType',
            self::SCHEMA_LABEL    => 'Battery type',
            self::SCHEMA_REQUIRED => false,
        ),
        // 'non_spillable' => array(
        //     self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Simple',
        //     self::SCHEMA_LABEL    => 'Non-spillable battery',
        //     self::SCHEMA_REQUIRED => false,
        //     XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => false,
        // ),
        // 'hazmat' => array(
        //     self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Simple',
        //     self::SCHEMA_LABEL    => 'Hazardous materials',
        //     self::SCHEMA_REQUIRED => false,
        //     XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => false,
        // ),
        // 'chemicals' => array(
        //     self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Simple',
        //     self::SCHEMA_LABEL    => 'Chemicals',
        //     self::SCHEMA_REQUIRED => false,
        //     XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => false,
        // ),
        // 'pesticide' => array(
        //     self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Simple',
        //     self::SCHEMA_LABEL    => 'Pesticide',
        //     self::SCHEMA_REQUIRED => false,
        //     XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => false,
        // ),
        // 'rppc' => array(
        //     self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Simple',
        //     self::SCHEMA_LABEL    => 'Rigid plastic packaging container',
        //     self::SCHEMA_REQUIRED => false,
        //     XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => false,
        // ),
        // 'fuel' => array(
        //     self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Simple',
        //     self::SCHEMA_LABEL    => 'Can contain fuel',
        //     self::SCHEMA_REQUIRED => false,
        //     XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => false,
        // ),
        // 'ormd' => array(
        //     self::SCHEMA_CLASS    => 'XLite\View\FormField\Input\Checkbox\Simple',
        //     self::SCHEMA_LABEL    => 'Is ORM-D',
        //     self::SCHEMA_REQUIRED => false,
        //     XLite\View\FormField\Input\Checkbox::PARAM_IS_CHECKED => false,
        //     self::SCHEMA_HELP     => 'ORM-D is a marking for mail or shipping in the United States that identifies other regulated materials for domestic transport only. Packages bearing this mark contain hazardous material in a limited quantity that presents a limited hazard during transportation, due to its form, quantity, and packaging.',
        // ),
    );

    /**
     * Return current model ID
     *
     * @return integer
     */
    public function getModelId()
    {
        return \XLite\Core\Request::getInstance()->product_id;
    }

    /**
     * Return list of form fields objects by schema
     *
     * @param array $schema Field descriptions
     *
     * @return array
     */
    protected function getFieldsBySchema(array $schema)
    {
        if (isset($schema['parent'])) {
            $schema['parent'][\XLite\View\FormField\Select\Category::PARAM_EXCLUDE_CATEGORY] = $this->getModelId();
            $schema['parent'][\XLite\View\FormField\Select\Category::PARAM_DISPLAY_ROOT_CATEGORY] = true;
            $schema['parent'][\XLite\View\FormField\Select\Category::PARAM_VALUE]
                = $this->getModelObject()->getParent()->getCategoryId();
        }

        return parent::getFieldsBySchema($schema);
    }

    /**
     * getFieldBySchema
     *
     * @param string $name Field name
     * @param array  $data Field description
     *
     * @return \XLite\View\FormField\AFormField
     */
    protected function getFieldBySchema($name, array $data)
    {
        if ('meta_title' === $name) {
            $data[static::SCHEMA_PLACEHOLDER] = static::t('Default');
        }

        return parent::getFieldBySchema($name, $data);
    }

    /**
     * This object will be used if another one is not passed
     *
     * @return \XLite\Model\Category
     */
    protected function getDefaultModelObject()
    {
        $model = $this->getModelId()
            ? \XLite\Core\Database::getRepo('XLite\Model\Product')->find($this->getModelId())
            : null;

        return $model ?: new \XLite\Model\Product;
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
        if (isset($data['country_of_origin'])) {
            $data['country_of_origin'] = \XLite\Core\Database::getRepo('XLite\Model\Country')
                ->find($data['country_of_origin']);
        }

        parent::setModelProperties($data);

        /** @var \XLite\Model\Product $model */
        $model = $this->getModelObject();

        $model->update();

        $this->setProduct($model);
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\Module\XC\PitneyBowes\View\Form\AdditionalDetails';
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        $label = $this->getModelObject()->getId() ? 'Update product' : 'Add product';
        $result['submit'] = new \XLite\View\Button\Submit(
            array(
                \XLite\View\Button\AButton::PARAM_LABEL => $label,
                \XLite\View\Button\AButton::PARAM_BTN_TYPE => 'regular-main-button',
                \XLite\View\Button\AButton::PARAM_STYLE => 'action',
            )
        );

        if ($this->getModelObject()->isPersistent()) {
            $url = $this->buildURL(
                'product',
                'clone',
                array(
                    'product_id' => $this->getModelObject()->getId(),
                )
            );
            $result['clone-product'] = new \XLite\View\Button\Link(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Clone this product',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'model-button always-enabled',
                    \XLite\View\Button\Link::PARAM_LOCATION => $url,
                )
            );

            $url = $this->buildProductPreviewURL($this->getModelObject()->getId());
            $result['preview-product'] = new \XLite\View\Button\SimpleLink(
                array(
                    \XLite\View\Button\AButton::PARAM_LABEL => 'Preview product page',
                    \XLite\View\Button\AButton::PARAM_STYLE => 'model-button link action',
                    \XLite\View\Button\Link::PARAM_BLANK    => true,
                    \XLite\View\Button\Link::PARAM_LOCATION => $url,
                )
            );
        }
    }

    /**
     * Add top message
     *
     * @return void
     */
    protected function addDataSavedTopMessage()
    {
        if ('create' !== $this->currentAction) {
            \XLite\Core\TopMessage::addInfo('The product has been updated');

        } else {
            \XLite\Core\TopMessage::addInfo('The product has been added');
        }
    }
}
