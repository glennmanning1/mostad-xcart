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

namespace XLite\View\Button;

/**
 * Submit button for export products
 *
 */
class ExportCSV extends \XLite\View\Button\APopupButton
{
    /**
     * Widget params
     */
    const PARAM_ENTITY = 'entity';
    const PARAM_SESSION_CELL = 'session';

    /**
     * Register JS files
     *
     * @return array
     */
    public function getJSFiles()
    {
        return array_merge(
            parent::getJSFiles(),
            array(
                'event_task_progress/controller.js',
                'export/controller_popup.js',
                'button/js/export_csv.js',
            )
        );
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += array(
            static::PARAM_ENTITY => new \XLite\Model\WidgetParam\String('Exported entity class', ''),
            static::PARAM_SESSION_CELL => new \XLite\Model\WidgetParam\String('Export condition session cell name', ''),
        );
    }

    /**
     * Register CSS files
     *
     * @return array
     */
    public function getCSSFiles()
    {
        return array_merge(
            parent::getCSSFiles(),
            array(
                'event_task_progress/style.css',
                'export/style.css'
            )
        );
    }

    /**
     * Return URL parameters to use in AJAX popup
     *
     * @return array
     */
    protected function prepareURLParams()
    {
        return array(
            'target' => 'export',
            'widget' => 'XLite\View\PopupExport',
        );
    }

    /**
     * Return array of URL params for JS
     *
     * @return array
     */
    public function getURLParams()
    {
        $params = parent::getURLParams();
        $params['export'] = array(
            'target' => 'export',
            'action' => 'itemlist_export',
            'section' => array(
                $this->getExportEntity()
            ),
            'options' => array(
                'charset' => \XLite\Core\Config::getInstance()->Units->export_import_charset,
                'attrs' => 'global',
                'files' => 'local',
                'filter' => $this->getExportSessionCell()
            )
        );

        return $params;
    }

    /**
     * getDefaultLabel
     *
     * @return string
     */
    protected function getExportEntity()
    {
        return $this->getParam(static::PARAM_ENTITY);
    }

    /**
     * getDefaultLabel
     *
     * @return string
     */
    protected function getExportSessionCell()
    {
        return $this->getParam(static::PARAM_SESSION_CELL);
    }

    /**
     * getDefaultLabel
     *
     * @return string
     */
    protected function getDefaultLabel()
    {
        return 'CSV';
    }

    /**
     * getClass
     *
     * @return string
     */
    protected function getClass()
    {
        return parent::getClass() . ' export-csv always-reload';
    }
}
