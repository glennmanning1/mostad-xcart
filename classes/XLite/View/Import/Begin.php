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

namespace XLite\View\Import;

/**
 * Begin section
 */
class Begin extends \XLite\View\AView
{
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return 'import/begin.tpl';
    }

    /**
     * Defines the message for uploading files
     *
     * @return string
     */
    protected function getUploadFileMessage()
    {
        return static::t(
            'CSV or ZIP files, total max size: {{size}}',
            array('size' => ini_get('upload_max_filesize'))
        );
    }

    /**
     * Return samples URL
     *
     * @return string
     */
    protected function getSamplesURL()
    {
        return 'http://kb.x-cart.com/pages/viewpage.action?pageId=7503874';
    }

    /**
     * Return samples URL text
     *
     * @return string
     */
    protected function getSamplesURLText()
    {
        return static::t('Import/Export guide');
    }

    /**
     * Check - charset enabledor not
     *
     * @return boolean
     */
    protected function isCharsetEnabled()
    {
        return \XLite\Core\Iconv::getInstance()->isValid();
    }

    /**
     * Return comment text for 'updateOnly' checkbox tooltip
     *
     * @return string
     */
    protected function getImportModeComment()
    {
        $result = '';

        $importer = $this->getImporter() ?: null;

        if (!$importer) {
            $importer = new \XLite\Logic\Import\Importer(array());
        }

        $keys = $importer->getAvailableEntityKeys();

        if ($keys) {
            $rows = array();
            foreach ($keys as $key => $list) {
                $rows[] = '<li>' . $key . ': <em>' . implode(', ', $list) . '</em></li>';
            }
            $result = static::t('Import mode comment', array('keys' => implode('', $rows)));
        }

        return $result;
    }

    /**
     * Get options for selector 'Import mode'
     *
     * @return array
     */
    protected function getImportModeOptions()
    {
        return array(
            0 => static::t('Create new items and update existing items'),
            1 => static::t('Update existing items, but skip new items'),
        );
    }
}
