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

namespace XLite\Module\XC\PitneyBowes\Logic\Export\Step;

/**
 * Products
 */
class Products extends \XLite\Logic\Export\Step\Base\I18n
{
    // {{{ Data

    /**
     * Get repository
     *
     * @return \XLite\Model\Repo\ARepo
     */
    protected function getRepository()
    {
        $repo = \XLite\Core\Database::getRepo('XLite\Model\Product');
        if ($this->generator->getOptions()->differential) {
            $repo->setDifferential(true);
        }
        return $repo;
    }

    /**
     * Get filename
     *
     * @return string
     */
    protected function getFilename()
    {
        // $this->generator->getOptions() is arrayObject, so we don't need to declare it before
        if (empty($this->generator->getOptions()->products_filename)) {
            $config = \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration();;
            $parts = array(
                'Sender_ID' => $config->sender_id,
                'Data_Feed_Name' => 'catalog',
                'Operation' => 'update',
                'Recipient_ID' => '16061',
                'UTC_Date_Time' => \XLite\Core\Converter::formatTime(null, '%Y%m%d_%H%M%S'),
                'Random_6_Digits' => str_pad(rand(0, pow(10, 6)), 6, '0', STR_PAD_LEFT),
            );
            $this->generator->getOptions()->products_filename = implode('_', $parts) . '.csv';
        }

        return $this->generator->getOptions()->products_filename;
    }

    /**
     * Process model
     *
     * @param \XLite\Model\AEntity $model Model
     *
     * @return void
     */
    protected function processModel(\XLite\Model\AEntity $model)
    {
        parent::processModel($model);
        $model->setExportedPb(true);
    }

    /**
     * Get file pointer
     * This dedicates to greatest developer of all time, Maxim Shamaev. Because getFilename() is not enough for name combining.
     *
     * @return resource
     */
    protected function getFilePointer()
    {
        if (!isset($this->filePointer)) {
            $name = $this->getFilename();

            $dir = \Includes\Utils\FileManager::getRealPath(LC_DIR_VAR . $this->generator->getOptions()->dir);
            if (is_writable($dir)) {
                if (!\Includes\Utils\FileManager::isExists($dir . LC_DS . '.htaccess')) {
                    // Try to create .htaccess file to protect directory
                    $out = <<<OUT
Options -Indexes

Deny from all

OUT;
                    \Includes\Utils\FileManager::write($dir . LC_DS . '.htaccess', $out);
                }
                $this->filePath = $dir . LC_DS . $name;
                $this->filePointer = @fopen($dir . LC_DS . $name, 'ab');

            } else {
                $this->generator->addError(
                    static::t('Directory does not have permissions to write'),
                    static::t('Directory X does not have permissions to write. Please set necessary permissions to directory X.', array('path' => $dir))
                );
            }
        }

        return $this->filePointer;
    }

    // }}}

    // {{{ Columns

    /**
     * Define columns
     *
     * @return array
     */
    protected function defineColumns()
    {
        $columns = array(
            'MERCHANT_COMMODITY_REF_ID'     => array(),
            'COMMODITY_NAME_TITLE'          => array(),
            'SHORT_DESCRIPTION'             => array(),
            'LONG_DESCRIPTION'              => array(),
            'RETAILER_ID'                   => array(),
            'COMMODITY_URL'                 => array(),
            'RETAILER_UNIQUE_ID'            => array(),
            'PCH_CATEGORY_ID'               => array(),
            'RH_CATEGORY_ID'                => array(),
            'STANDARD_PRICE'                => array(),
            'WEIGHT_UNIT'                   => array(),
            'DISTANCE_UNIT'                 => array(),
            'COO'                           => array(),
            'IMAGE_URL'                     => array(),
            'PARENT_SKU'                    => array(),
            'CHILD_SKU'                     => array(),
            'PARCELS_PER_SKU'               => array(),
            'UPC'                           => array(),
            'UPC_CHECK_DIGIT'               => array(),
            'GTIN'                          => array(),
            'MPN'                           => array(),
            'ISBN'                          => array(),
            'BRAND'                         => array(),
            'MANUFACTURER'                  => array(),
            'MODEL_NUMBER'                  => array(),
            'MANUFACTURER_STOCK_NUMBER'     => array(),
            'COMMODITY_CONDITION'           => array(),
            'COMMODITY_HEIGHT'              => array(),
            'COMMODITY_WIDTH'               => array(),
            'COMMODITY_LENGTH'              => array(),
            'PACKAGE_WEIGHT'                => array(),
            'PACKAGE_HEIGHT'                => array(),
            'PACKAGE_WIDTH'                 => array(),
            'PACKAGE_LENGTH'                => array(),
            'HAZMAT'                        => array(),
            'ORMD'                          => array(),
            'CHEMICAL_INDICATOR'            => array(),
            'PESTICIDE_INDICATOR'           => array(),
            'AEROSOL_INDICATOR'             => array(),
            'RPPC_INDICATOR'                => array(),
            'BATTERY_TYPE'                  => array(),
            'NON_SPILLABLE_BATTERY'         => array(),
            'FUEL_RESTRICTION'              => array(),
            'SHIP_ALONE'                    => array(),
            'RH_CATEGORY_ID_PATH'           => array(),
            'RH_CATEGORY_NAME_PATH'         => array(),
            'RH_CATEGORY_URL_PATH'          => array(),
            'GPC'                           => array(),
            'COMMODITY_WEIGHT'              => array(),
            'HS_CODE'                       => array(),
            'CURRENCY'                      => array(),
        );

        return $columns;
    }

    /**
     * Get product attributes columns
     *
     * @return array
     */
    protected function getAttributesColumns()
    {
        $columns = array();

        $cnd = new \XLite\Core\CommonCell();

        if ('global' === $this->generator->getOptions()->attrs) {
            $cnd->{\XLite\Model\Repo\Attribute::SEARCH_PRODUCT} = null;
            $cnd->{\XLite\Model\Repo\Attribute::SEARCH_PRODUCT_CLASS} = null;

        } elseif ('global_n_classes' === $this->generator->getOptions()->attrs) {
            $cnd->{\XLite\Model\Repo\Attribute::SEARCH_PRODUCT} = null;
        }

        $count = \XLite\Core\Database::getRepo('XLite\Model\Attribute')->search($cnd, true);

        if ($count) {
            $limit = 100;
            $start = 0;

            do {
                $cnd->{\XLite\Model\Repo\Attribute::SEARCH_LIMIT} = array($start, $limit);
                foreach (\XLite\Core\Database::getRepo('XLite\Model\Attribute')->search($cnd) as $attribute) {
                    $name = $this->getUniqueFieldName($attribute);
                    $column = $this->getAttributeColumn($attribute);
                    if (\XLite\Model\Attribute::TYPE_TEXT === $attribute->getType()) {
                        foreach ($this->getRepository()->getTranslationRepository()->getUsedLanguageCodes() as $code) {
                            $columns[$name . '_' . $code] = $column;
                        }

                    } else {
                        $columns[$name] = $column;
                    }
                }

                $count -= $limit;
                $start += $limit;
            } while ($count > 0);
        }

        return $columns;
    }

    /**
     * Get attribute column data
     *
     * @param \XLite\Model\Attribute $attribute Attribute object
     *
     * @return array
     */
    protected function getAttributeColumn($attribute)
    {
        return array(
            static::COLUMN_GETTER => 'getAttributeColumnValue',
            'attributeId'         => $attribute->getId(),
            'attributeName'       => $attribute->getName(),
            'attributeGroup'      => $attribute->getAttributeGroup() ? $attribute->getAttributeGroup()->getName() : '',
            'attributeIsProduct'  => (bool) $attribute->getProduct(),
            'attributeIsClass'    => (bool) $attribute->getProductClass(),
        );
    }

    /**
     * Get attribute column data
     *
     * @param \XLite\Model\Product   $product   Product object
     * @param \XLite\Model\Attribute $attribute Attribute object
     *
     * @return array
     */
    protected function getAttributeValue($product, $attributeName)
    {
        $value = null;
        $attr = \Includes\Utils\ArrayManager::searchInArraysArray($this->getAttributesColumns(), 'attributeName', $attributeName);

        if ($attr) {
            $entity = \XLite\Core\Database::getRepo('XLite\Model\Attribute')->find($attr['attributeId']);

            if ($entity) {
                $value = $entity->getAttributeValue($product, true);
            }

            if ($value && is_array($value)) {
                $value = array_shift($value);
            }
        }

        return $value ?: '';
    }

    /**
     * Return unique field name
     *
     * @param \XLite\Model\Attribute $attribute Attribute
     *
     * @return string
     */
    protected function getUniqueFieldName(\XLite\Model\Attribute $attribute)
    {
        $result = $attribute->getName() . ' (field:';

        $cnd = new \XLite\Core\CommonCell;
        $cnd->name = $attribute->getName();

        if ($attribute->getProduct()) {
            $result .= 'product';

        } elseif ($attribute->getProductClass()) {
            $result .= 'class';

        } else {
            $result .= 'global';
        }

        if ($attribute->getAttributeGroup()) {
            $result .= ' >>> ' . $attribute->getAttributeGroup()->getName();
        }

        $result .= ')';

        return $result;
    }

    // }}}

    // {{{ Getters and formatters

    /**
     * Get column value for 'sku' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getMERCHANT_COMMODITY_REF_IDColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'sku');
    }

    /**
     * Get column value for 'price' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOMMODITY_NAME_TITLEColumnValue(array $dataset, $name, $i)
    {
        return $dataset['model']->getSoftTranslation()->getName();
    }

    /**
     * Get column value for 'productClass' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getSHORT_DESCRIPTIONColumnValue(array $dataset, $name, $i)
    {
        return strip_tags($dataset['model']->getSoftTranslation()->getBriefDescription());
    }

    /**
     * Get column value for 'memberships' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getLONG_DESCRIPTIONColumnValue(array $dataset, $name, $i)
    {
        return strip_tags($dataset['model']->getSoftTranslation()->getDescription());
    }

    /**
     * Get column value for 'taxClass' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getRETAILER_IDColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'enabled' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOMMODITY_URLColumnValue(array $dataset, $name, $i)
    {
        return \XLite\Core\Converter::buildFullURL('product', '', array('product_id' => $dataset['model']->getId()));
    }

    /**
     * Get column value for 'weight' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getRETAILER_UNIQUE_IDColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'weight' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPCH_CATEGORY_IDColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'freeShipping' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getRH_CATEGORY_IDColumnValue(array $dataset, $name, $i)
    {
        return $dataset['model']->getCategoryId();
    }

    /**
     * Get column value for 'images' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getIMAGE_URLColumnValue(array $dataset, $name, $i)
    {
        $image = $dataset['model']->getImage();
        $result = $this->formatImageModel($image);

        return $result;
    }

    /**
     * Get column value for 'imagesAlt' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return array
     */
    protected function getSTANDARD_PRICEColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'price');
    }

    /**
     * Get column value for 'arrivalDate' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getWEIGHT_UNITColumnValue(array $dataset, $name, $i)
    {
        return substr(\XLite\Core\Config::getInstance()->Units->weight_unit, 0, 2);
    }

    /**
     * Get column value for 'arrivalDate' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getDISTANCE_UNITColumnValue(array $dataset, $name, $i)
    {
        $unit = \XLite\Core\Config::getInstance()->Units->dim_unit;
        switch ($unit) {
            case 'mm':
                $value = 'cm';
                break;
            case 'cm':
                $value = 'cm';
                break;
            case 'm':
                $value = 'm';
                break;
            case 'dm':
                $value = 'cm';
                break;
            case 'in':
                $value = 'in';
                break;

            default:
                $value = '';
                break;
        }
        return $value;
    }

    /**
     * Get column value for 'date' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOOColumnValue(array $dataset, $name, $i)
    {
        return $dataset['model']->getCountryOfOrigin() ? $dataset['model']->getCountryOfOrigin()->getCode3() : '';
    }

    /**
     * Get column value for 'updateDate' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPARENT_SKUColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'categories' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return array
     */
    protected function getCategoriesColumnValue(array $dataset, $name, $i)
    {
        $result = array();
        foreach ($dataset['model']->getCategories() as $category) {
            $path = array();
            foreach ($category->getRepository()->getCategoryPath($category->getCategoryId()) as $c) {
                $path[] = $c->getName();
            }
            $result[] = implode(' >>> ', $path);
        }

        return $result;
    }

    /**
     * Get column value for 'inventoryTrackingEnabled' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCHILD_SKUColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'stockLevel' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPARCELS_PER_SKUColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'lowLimitEnabled' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getUPCColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'lowLimitLevel' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getUPC_CHECK_DIGITColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'cleanUrl' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getGTINColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'gtin');
    }

    /**
     * Get column value for 'useSeparateBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getSHIP_ALONEColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'useSeparateBox');
    }

    /**
     * Get column value for 'boxWidth' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getMPNColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'mpn');
    }

    /**
     * Get column value for 'boxWidth' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getISBNColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'boxWidth' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getBRANDColumnValue(array $dataset, $name, $i)
    {
        return '';
    }

    /**
     * Get column value for 'boxWidth' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getMANUFACTURERColumnValue(array $dataset, $name, $i)
    {
        return $this->getAttributeValue($dataset['model'], 'Manufacturer');
    }

    /**
     * Get column value for 'boxWidth' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getMODEL_NUMBERColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'model_number');
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getMANUFACTURER_STOCK_NUMBERColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'stock_number');
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOMMODITY_CONDITIONColumnValue(array $dataset, $name, $i)
    {
       $condition = $this->getColumnValueByName($dataset['model'], 'product_condition');
       switch ($condition) {
            case \XLite\Model\Product::CONDITION_NEW:
                $result = 'New';
                break;

            case \XLite\Model\Product::CONDITION_USED:
                $result = 'Used';
                break;

            case \XLite\Model\Product::CONDITION_REFURBISHED:
                $result = 'Refurbished';
                break;

            default:
                $result = '';
                break;
       }

       return $result;
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOMMODITY_HEIGHTColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOMMODITY_WIDTHColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOMMODITY_LENGTHColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPACKAGE_WEIGHTColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'weight') ?: '';
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPACKAGE_HEIGHTColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'boxHeight') ?: '';
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPACKAGE_WIDTHColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'boxWidth') ?: '';
    }

    /**
     * Get column value for 'boxLength' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPACKAGE_LENGTHColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'boxLength') ?: '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getHAZMATColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'hazmat') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getORMDColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'ormd') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCHEMICAL_INDICATORColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'chemicals') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPESTICIDE_INDICATORColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'pesticide') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getAEROSOL_INDICATORColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'aerosol') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getRPPC_INDICATORColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'rppc') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getBATTERY_TYPEColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'battery');
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getNON_SPILLABLE_BATTERYColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'non_spillable') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getFUEL_RESTRICTIONColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'fuel') ? 'Y' : '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getRH_CATEGORY_ID_PATHColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }
    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getRH_CATEGORY_NAME_PATHColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getRH_CATEGORY_URL_PATHColumnValue(array $dataset, $name, $i)
    {
        //TODO: to implement
        return '';
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getGPCColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'GPC');
    }

    /**
     * Get column value for 'boxHeight' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCOMMODITY_WEIGHTColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'weight');
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getHS_CODEColumnValue(array $dataset, $name, $i)
    {
        return $this->getColumnValueByName($dataset['model'], 'hs_code');
    }

    /**
     * Get column value for 'itemsPerBox' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getCURRENCYColumnValue(array $dataset, $name, $i)
    {
        return \XLite::getInstance()->getCurrency()->getCode();
    }

    /**
     * Copy resource
     *
     * @param \XLite\Model\Base\Storage $storage      Storage
     * @param string                    $subdirectory Subdirectory
     *
     * @return boolean
     */
    protected function copyResource(\XLite\Model\Base\Storage $storage, $subdirectory)
    {
        if ($storage instanceof \XLite\Model\Base\Image) {
            $subdirectory .= LC_DS . 'products';
        }

        return parent::copyResource($storage, $subdirectory);
    }

    // }}}
}
