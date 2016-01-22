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
 * Categories
 */
class Categories extends \XLite\Logic\Export\Step\Base\I18n
{
    // {{{ Data

    /**
     * Get repository
     *
     * @return \XLite\Model\Repo\ARepo
     */
    protected function getRepository()
    {
        return \XLite\Core\Database::getRepo('XLite\Model\Category');
    }

    /**
     * Get filename
     *
     * @return string
     */
    protected function getFilename()
    {
        if (empty($this->generator->getOptions()->categories_filename)) {
            $config = \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration();
            $parts = array(
                'Sender_ID' => $config->sender_id,
                'Data_Feed_Name' => 'category-tree',
                'Operation' => 'update',
                'Recipient_ID' => '16061',
                'UTC_Date_Time' => \XLite\Core\Converter::formatTime(null, '%Y%m%d_%H%M%S'),
                'Random_6_Digits' => str_pad(rand(0, pow(10, 6)), 6, '0', STR_PAD_LEFT),
            );
            $this->generator->getOptions()->categories_filename = implode('_', $parts) . '.csv';
        }

        return $this->generator->getOptions()->categories_filename;
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
            'CATEGORY_ID'        => array(),
            'PARENT_CATEGORY_ID'     => array(),
            'NAME'   => array(),
            'ID_PATH'    => array(),
            'URL' => array(),
        );

        // $columns += $this->assignI18nColumns(
        //     array(
        //         'name'        => array(),
        //         'description' => array(),
        //         'metaTags'    => array(),
        //         'metaDesc'    => array(),
        //         'metaTitle'   => array(),
        //     )
        // );

        return $columns;
    }

    // }}}

    // {{{ Getters and formatters

    /**
     * Get column value for 'path' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getID_PATHColumnValue(array $dataset, $name, $i)
    {
        $result = array();
        foreach ($this->getRepository()->getCategoryPath($dataset['model']->getCategoryId()) as $category) {
            $result[] = $category->getId();
        }

        return implode(':', $result);
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
    protected function getURLColumnValue(array $dataset, $name, $i)
    {
        return \XLite\Core\Converter::buildFullURL('category', '', array('category_id' => $dataset['model']->getId()));
    }

    /**
     * Get column value for 'showTitle' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getNAMEColumnValue(array $dataset, $name, $i)
    {
        return $dataset['model']->getSoftTranslation()->getName();
    }

    /**
     * Get column value for 'position' column
     *
     * @param array   $dataset Dataset
     * @param string  $name    Column name
     * @param integer $i       Subcolumn index
     *
     * @return string
     */
    protected function getPARENT_CATEGORY_IDColumnValue(array $dataset, $name, $i)
    {
        return $dataset['model']->getParentId() ?: '';
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
    protected function getCATEGORY_IDColumnValue(array $dataset, $name, $i)
    {
        return $dataset['model']->getId();
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
        if ($storage instanceOf \XLite\Model\Base\Image) {
            $subdirectory .= LC_DS . 'categories';
        }

        return parent::copyResource($storage, $subdirectory);
    }

    // }}}

}
