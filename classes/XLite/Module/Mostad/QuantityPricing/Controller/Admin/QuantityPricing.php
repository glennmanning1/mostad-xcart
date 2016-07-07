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
 * @copyright Copyright (c) 2011-2014 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\Mostad\QuantityPricing\Controller\Admin;

use XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice;
use XLite\Module\Mostad\QuantityPricing\Model\WholesaleClassPricingSet;

/**
 * Quantity pricing controller
 */
class QuantityPricing extends \XLite\Controller\Admin\AAdmin
{
    public function doActionImport()
    {
        // Check uploaded file with SQL data
        if (isset($_FILES['userfile']) && !empty($_FILES['userfile']['tmp_name'])) {

            $sqlFile = LC_DIR_TMP . sprintf('quantity.pricing.uploaded.%d.sql', \XLite\Core\Converter::time());

            $tmpFile = $_FILES['userfile']['tmp_name'];

            if (!move_uploaded_file($tmpFile, $sqlFile)) {
                throw new \Exception(static::t('Error of uploading file.'));
            }

            $repo = \XLite\Core\Database::getRepo('\XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice');

            if ($_POST['import_mode'] == 'replace') {
                $connection = \XLite\Core\Database::getEM()->getConnection();
                $dbPlatform = $connection->getDatabasePlatform();
                $q          = $dbPlatform->getTruncateTableSql($repo->getTableName());
                $connection->executeQuery($q);
            }

            $skipped     = [];
            $prices      = [];
            $totalPrices = 0;
            $processed   = [];
            if (($handle = fopen($sqlFile, "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, "|")) !== false) {

                    if (count($data) != 6 || empty($data[0]) || empty($data[1])) {
                        $skipped[] = $data;
                        continue;
                    }

                    // Check for a product by sku
                    $model = \XLite\Core\Database::getRepo('XLite\Model\Product')->findOneBySku($data[0]);

                    // check for a variant by sku
                    if (!$model) {
                        $model = \XLite\Core\Database::getRepo('XLite\Module\XC\ProductVariants\Model\ProductVariant')
                            ->findOneBySku($data[0]);
                    }

                    // check for a product class by name
                    if (!$model) {
                        $model = \XLite\Core\Database::getRepo('XLite\Module\NovaHorizons\WholesaleClasses\Model\WholesaleClassPricingSet')
                            ->findOneByName($data[0]);
                    }

                    if (empty($model)) {
                        $skipped[] = $data;
                        continue;
                    }

                    $priceData = (explode(',', $data[1]));

                    if (count($priceData) < 2) {
                        continue;
                    }

                    if (isset($processed[ $data[0] ])) {
                        continue;
                    } else {
                        $processed[ $data[0] ] = true;
                    }

                    foreach ($priceData as $key => $item) {
                        $priceParts = explode(':', $item);
                        $price      = new QuantityPrice();
                        $price->setModel($model);
                        $price->setQuantity($priceParts[0]);
                        $price->setPrice(floor($priceParts[0] * $priceParts[1]));

                        $prices[] = $price;

                        if (count($prices) % 100 == 0) {
                            $totalPrices += count($prices);
                            $repo->insertInBatch($prices);
                            $prices = [];
                        }
                    }
                }
                fclose($handle);
            } else {
                \XLite\Core\TopMessage::addError('Error opening CSV');
            }

            if (!empty($prices)) {
                $totalPrices += count($prices);
                $repo->insertInBatch($prices);
            }

            \XLite\Core\TopMessage::addInfo("$totalPrices prices added, " . count($skipped) . " skipped due to errors");

            $this->redirect();
            exit (0);
        }
    }

    public function doActionExport()
    {
        $prices    = \XLite\Core\Database::getRepo('\XLite\Module\Mostad\QuantityPricing\Model\QuantityPrice')
            ->findAll();
        $priceRows = [];

        /** @var QuantityPrice $price */
        foreach ($prices as $price) {
            $model = \XLite\Core\Database::getRepo($price->getModelType())->find($price->getModelId());

            if ($model instanceof \XLite\Module\Mostad\QuantityPricing\Model\WholesaleClassPricingSet) {
                $sku = $model->getName();
            } else {
                $sku = $model->getSku();
            }

            if (!isset($priceRows[ $sku ])) {
                $priceRows[ $sku ] = [];
            }

            $priceRows[ $sku ][] = $price->getQuantity().":".number_format($price->getPrice()/$price->getQuantity(), 4);

        }
        
        $name = 'quantity-prices-' . microtime() . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $name);
        header('Pragma: no-cache');
        header("Expires: 0");

        $outstream = fopen("php://output", "w");

        foreach ($priceRows as $sku => $row) {
            $result = [
                $sku,
                implode(',', $row),
            ];
            fputcsv($outstream, $result, "|");
        }

        fclose($outstream);
        exit (0);
        
    }
}