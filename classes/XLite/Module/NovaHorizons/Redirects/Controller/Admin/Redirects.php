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
 * @author    Nova Horizons LLC <xcart@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horizons LLC <xcart@novahorizons.io>. All rights reserved
 * @license   https://novahorizons.io/x-cart/license License Agreement
 * @link      https://novahorizons.io/
 */

namespace XLite\Module\NovaHorizons\Redirects\Controller\Admin;

use XLite\Module\NovaHorizons\Redirects\View\FormField\InLine\Input\Text\Target;

class Redirects extends \XLite\Controller\Admin\AAdmin
{
    protected function doActionUpdate()
    {
        $list = new \XLite\Module\NovaHorizons\Redirects\View\ItemList\Model\Redirect;
        $list->processQuick();
    }
    
    /**
     * doActionRestoreFromUploadedFile
     *
     * @return void
     * @throws
     */
    protected function doActionRedirectsImport()
    {
        // Check uploaded file with SQL data
        if (isset($_FILES['userfile']) && !empty($_FILES['userfile']['tmp_name'])) {
            $sqlFile = LC_DIR_TMP . sprintf('redirects.uploaded.%d.sql', \XLite\Core\Converter::time());

            $tmpFile = $_FILES['userfile']['tmp_name'];

            if (!move_uploaded_file($tmpFile, $sqlFile)) {
                throw new \Exception(static::t('Error of uploading file.'));
            }

            $repo = \XLite\Core\Database::getRepo('\XLite\Module\NovaHorizons\Redirects\Model\Redirect');

            if ($_POST['import_mode'] == 'replace') {
                $connection = \XLite\Core\Database::getEM()->getConnection();
                $dbPlatform = $connection->getDatabasePlatform();
                $q = $dbPlatform->getTruncateTableSql($repo->getTableName());
                $connection->executeQuery($q);
            }

            $skipped = array();
            $redirects = array();
            $totalRedirects = 0;
            if (($handle = fopen($sqlFile, "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    if (empty($data[0]) || empty($data[1])) {
                        $skipped[] = $data;
                        continue;
                    }

                    try {
                        $validator = new \XLite\Core\Validator\String\RegExp(true, Target::VALID_REGEX);
                        $validator->validate($data[0]);
                        $validator->validate($data[1]);
                    } catch (\Exception $e) {
                        $skipped[] = $data;
                        continue;
                    }

                    $r = new \XLite\Module\NovaHorizons\Redirects\Model\Redirect;
                    $r->setTarget($data[0]);
                    $r->setPath($data[1]);

                    $redirects[] = $r;

                    if (count($redirects) % 100 == 0) {
                        $totalRedirects += count($redirects);
                        $repo->insertInBatch($redirects);
                        $redirects = array();
                    }
                }
                fclose($handle);
            } else {
                \XLite\Core\TopMessage::addError('Error opening CSV');
            }

            if (!empty($redirects)) {
                $totalRedirects += count($redirects);
                $repo->insertInBatch($redirects);
            }

            \XLite\Core\TopMessage::addInfo("$totalRedirects redirects added, ".count($skipped)." skipped due to errors");

            $this->redirect();
            exit(0);
        }
    }

    /**
     * File size limit
     *
     * @return string
     */
    public function getUploadMaxFilesize()
    {
        return ini_get('upload_max_filesize');
    }
}
