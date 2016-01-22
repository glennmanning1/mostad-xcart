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

namespace XLite\Module\XC\PitneyBowes\Controller\Admin;

/**
 * PitneyBowes settings page controller
 */
class Parcel extends \XLite\Controller\Admin\AAdmin
{
    /**
     * Check ACL permissions
     *
     * @return boolean
     */
    public function checkACL()
    {
        return parent::checkACL() && $this->getParcel();
    }

    /**
     * get title
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Edit parcel';
    }

    public static function defineFreeFormIdActions()
    {
        return array_merge(parent::defineFreeFormIdActions(), array('get_available_count', 'create_asn', 'draw_barcode'));
    }

    /**
     * getViewerTemplate
     *
     * @return string
     */
    protected function getViewerTemplate()
    {
        $result = parent::getViewerTemplate();

        if ('print_label' === \XLite\Core\Request::getInstance()->mode) {
            $result = 'modules/XC/PitneyBowes/asn/label/body.tpl';
        }

        return $result;
    }

    /**
     * Create asn request
     *
     * @return void
     */
    public function doActionCreateAsn()
    {
        $api = new \XLite\Module\XC\PitneyBowes\Model\Shipping\PitneyBowesApiFacade(
            \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::getProcessorConfiguration()
        );

        if ($this->getParcel()) {
            $inputData = array(
                'pbParcel'   => $this->getParcel(),
                'request'   => \XLite\Core\Request::getInstance(),
            );

            $inboundParcelResult = $api->createInboundParcelsRequest($inputData);
            if ($inboundParcelResult) {
                \XLite\Module\XC\PitneyBowes\Model\Shipping\Processor\PitneyBowes::logDebug(
                    $inboundParcelResult
                );

                foreach ($inboundParcelResult as $inboundParcel) {
                    $existedTrackingNumber = \XLite\Core\Database::getRepo('XLite\Model\OrderTrackingNumber')->findOneBy(
                        array(
                            'value' => $inboundParcel->parcelIdentifier,
                            'order' => $this->getOrder(),
                        )
                    );
                    if (!$existedTrackingNumber) {
                        $trackingNumber = new \XLite\Model\OrderTrackingNumber();
                        $trackingNumber->setOrder($this->getOrder());
                        $trackingNumber->setValue($inboundParcel->parcelIdentifier);

                        $this->getOrder()->addTrackingNumbers($trackingNumber);
                        \XLite\Core\Database::getEM()->persist($this->getOrder());
                        \XLite\Core\Database::getEM()->flush($this->getOrder());
                    }
                }
                $this->getParcel()->setCreateAsnCalled(true);
                \XLite\Core\Database::getEM()->persist($this->getParcel());
                \XLite\Core\Database::getEM()->flush($this->getParcel());
            } else {
                \XLite\Core\TopMessage::addWarning('Create ASN action failed, try again later');
            }
        }

        $this->setSilenceClose(true);
    }

    public function doActionDrawBarcode()
    {
        $printer = new \XLite\Module\XC\PitneyBowes\Logic\Barcode\Printer;
        $this->setPureAction();

        $this->suppressOutput = true;
        $this->silent = true;

        // Draw barcode to the screen
        // header('Content-Disposition: Attachment;filename=barcode.png');
        header('Content-type: image/png');

        print $printer->getBarcode(
            array(
                'text' => trim($this->getParcel()->getNumber())
            )
        );
    }

    /**
     * Update list
     *
     * @return void
     */
    protected function doActionEditParcel()
    {
        $this->getParcel()->setCreateAsnCalled(false);
        \XLite\Core\Database::getEM()->persist($this->getParcel());
        \XLite\Core\Database::getEM()->flush($this->getParcel());

        $list = new \XLite\Module\XC\PitneyBowes\View\ItemsList\Model\Parcel;
        $list->processQuick();

        $this->setHardRedirect(true);
        $this->setReturnURL(
            $this->buildURL('order', '', array(
                'page' => 'parcels',
                'order_number' => $this->getOrder()->getOrderNumber()
            ))
        );
    }

    /**
     * Update list
     *
     * @return void
     */
    protected function doActionGetAvailableCount()
    {
        $orderItem = \XLite\Core\Database::getRepo('XLite\Model\OrderItem')->find(
            \XLite\Core\Request::getInstance()->order_item_id
        );

        if ($orderItem) {

            $ajaxResponse = array(
                'amount' => $this->getOrder()->getPbOrder()->getAvailableAmount($orderItem)
            );
            $this->printAJAX($ajaxResponse);
        }
        $this->silent = true;
        $this->setSuppressOutput(true);
    }

    /**
     * Send specific headers and print AJAX data as JSON string
     *
     * @param array $data
     *
     * @return void
     */
    protected function printAJAX($data)
    {
        // Move top messages into headers since we print data and die()
        $this->translateTopMessagesToHTTPHeaders();

        $content = json_encode($data);

        header('Content-Type: application/json; charset=UTF-8');
        header('Content-Length: ' . strlen($content));
        header('ETag: ' . md5($content));

        print ($content);
    }

    /**
     * Get order
     *
     * @return \XLite\Model\Order
     */
    public function getOrder()
    {
        if (!isset($this->order) && $this->getParcel()) {
            $this->order = $this->getParcel()->getOrder()->getOrder();
        }

        return $this->order;
    }

    /**
     * Get parcel
     *
     * @return \XLite\Module\XC\PitneyBowes\Model\PBParcel
     */
    public function getParcel()
    {
        if (!isset($this->parcel)) {
            $parcel = null;
            if (\XLite\Core\Request::getInstance()->id) {
                $parcel = \XLite\Core\Database::getRepo('XLite\Module\XC\PitneyBowes\Model\PBParcel')
                    ->find(intval(\XLite\Core\Request::getInstance()->id));

            }

            $this->parcel = $parcel;
        }

        return $this->parcel;
    }
}
