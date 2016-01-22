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

namespace XLite\Module\XC\PitneyBowes\Logic\FileExchange;

use XLite\Module\XC\PitneyBowes;

/**
 * API documentation: https://wiki.ecommerce.pb.com/display/TECH4/Pitney+Bowes+Ecommerce+-+Technical+Wiki
 *
 */
class Processor
{
    /**
     * @var array Configuration array
     */
    protected $config;

    /**
     * @var boolean Libraries are included
     */
    protected $includesLoaded;

    /**
     * Constructor
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->includesLoaded = false;
    }

    /**
     * Transfer generated catalog to PB server
     * 
     * @param array $files Catalog files
     * @param boolean $isDifferential Differential export (default: false)
     *
     * @return boolean
     */
    public function submitCatalog($files, $isDifferential = false)
    {
        $result = false;
        if (is_array($files) && count($files) > 0) {
            ob_start();

            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
                $this->config->sftp_username
            );

            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
                array_map(
                    function($info){
                        return $info->getRealPath();
                    },
                    $files
                )
            );

            $sftp = $this->loginToSFTP();

            if ($sftp) {
                $sftp->chdir('tmp');
                foreach ($files as $filename => $info) {
                    $sftp->put($filename, $info->getRealPath(), \phpseclib\Net\SFTP::SOURCE_LOCAL_FILE);
                    $sftp->rename($filename, '../inbound/'. $filename);

                    $export = new PitneyBowes\Model\PBExport;
                    $export->setFilename($filename);
                    $export->setDifferential($isDifferential);
                    \XLite\Core\Database::getRepo('XLite\Module\XC\PitneyBowes\Model\PBExport')->insert($export);
                    \XLite\Logger::logCustom("PitneyBowes", 'Export was successfully submitted to PB SFTP (file: ' . $filename . ')', false);
                }

                $result = true;
            }

            $buffer = ob_get_contents();
            ob_end_clean();

            if ($buffer) {
                \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug($buffer);
            }
        }

        return $result;
    }

    /**
     * Check PB server for notifications
     *
     * @return boolean
     */
    public function checkNotifications()
    {
        ob_start();

        $sftp = $this->loginToSFTP();

        if ($sftp) {
            $sftp->chdir('outbound');
            $raw = $sftp->rawlist();
            $files = array_filter(array_map(function ($file) {
                return ($file['type'] == NET_SFTP_TYPE_REGULAR) ? $file : false;
            }, $raw));

            $this->processNotifications($files, $sftp);
        }

        $buffer = ob_get_contents();
        ob_end_clean();

        if ($buffer) {
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug( $buffer);
        }
    }

    protected function processNotifications($files, $sftp)
    {
        $responses = array_filter($files, function ($file) {
            return in_array(pathinfo($file['filename'], \PATHINFO_EXTENSION), array('ok', 'log', 'err'), true);
        });

        if (!empty($responses)) {
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug( 'Found notifications');
            $this->processExportResponses($responses, $sftp);
        }

        $eligibility = array_filter($files, function ($file) {
            return (pathinfo($file['filename'], \PATHINFO_EXTENSION) === 'csv' && strpos(pathinfo($file['filename'], \PATHINFO_FILENAME), 'commodity-eligibility') !== false);
        });

        if (!empty($eligibility)) {
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug( 'Found commodity-eligibility files');
            $this->processCommodityEligibility($eligibility, $sftp);
        }

        \XLite\Core\Database::getEM()->flush();
    }

    protected function processExportResponses($files, $sftp)
    {
        // get export responses
        $exports = \XLite\Core\Database::getRepo('XLite\Module\XC\PitneyBowes\Model\PBExport')->findBy(
            array(
                'status' => PitneyBowes\Model\PBExport::STATUS_PENDING
            )
        );

        foreach ($files as $filename => $info) {
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug( 'Notification file ' . $filename);
            foreach ($exports as $export) {
                if (pathinfo($export->getFilename(), \PATHINFO_FILENAME) == pathinfo($filename, \PATHINFO_FILENAME)) {
                    switch (pathinfo($filename, \PATHINFO_EXTENSION)) {
                        case 'ok':
                            $export->setStatus(PitneyBowes\Model\PBExport::STATUS_APPROVED);
                            \XLite\Logger::logCustom("PitneyBowes", 'Approved catalog export (file: ' . $filename . ')', false);
                            break;

                        case 'err':
                            $export->setStatus(PitneyBowes\Model\PBExport::STATUS_FAILED);
                            $export->setErrors($sftp->get($filename));
                            \XLite\Logger::logCustom("PitneyBowes", 'Failed to approve catalog export (file: ' . $filename . ')', false);
                            break;

                        default:
                            break;
                    }

                    $sftp->delete($filename);
                    break;
                }
            }
        }
    }

    protected function processCommodityEligibility($files, $sftp)
    {
        $importer = new \XLite\Logic\Import\Importer(
            \XLite\Logic\Import\Importer::assembleImportOptions()
            + array('warningsAccepted' => true)
        );

        $importer->deleteAllFiles();

        \XLite\Logic\Import\Importer::run(
            \XLite\Logic\Import\Importer::assembleImportOptions()
            + array('warningsAccepted' => true)
        );

        $importDir = \XLite\Logic\Import\Importer::getImportDir();
        $filesToImport = array();
        foreach ($files as $filename => $info) {
            $downloaded = $sftp->get($filename, $importDir . LC_DS . $filename);
            if ($downloaded) {
                $sftp->delete($filename);
            }
        }

        \XLite\Logic\Import\Importer::runHeadless();
        \XLite\Logger::logCustom("PitneyBowes", 'Commodity-eligibility files were processed', false);
    }

    protected function loginToSFTP()
    {
        $this->includeLibrary();

        $result = true;
        $sftpClient = new \phpseclib\Net\SFTP(str_replace('sftp://', '', $this->config->sftp_endpoint));
        if (!$sftpClient->login($this->config->sftp_username, $this->config->sftp_password)) {
            $result = false;
            \XLite\Logger::logCustom("PitneyBowes", 'Error: Cound not start SFTP connection.', false);
        } else {
            $sftpClient->chdir($this->config->sftp_catalog_directory);
        }

        return $result ? $sftpClient : $result;
    }

    /**
     * Include sftp libraries
     *
     */
    protected function includeLibrary()
    {
        if (!$this->includesLoaded) {
            require_once LC_DIR_MODULES . 'XC' . LC_DS . 'PitneyBowes' . LC_DS . 'lib' . LC_DS . 'phpseclib' . LC_DS . 'Autoloader.php';

            $this->includesLoaded = true;
        }
    }
}