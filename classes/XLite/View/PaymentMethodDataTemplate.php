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

namespace XLite\View;

/**
 * Payment method data template widget
 */
class PaymentMethodDataTemplate extends \XLite\View\AView
{
    /**
     * Cached processor
     *
     * @var \XLite\Model\Payment\Base\Processor
     */
    protected $processor = null;

    /**
     * Display template
     *
     * @param string $template Template path OPTIONAL
     *
     * @return void
     */
    public function display($template = NULL)
    {
        // Use customer layout to display template
        /** @var \XLite\Core\Layout $layout */
        $layout = \XLite\Core\Layout::getInstance();
        $skin = $layout->getSkin();
        $interface = $layout->getInterface();
        $layout->setCustomerSkin($interface);

        parent::display();

        // Restore admin layout
        $layout->setAdminSkin();
        $layout->setSkin($skin);
    }

    /**
     * Get payment processor
     *
     * @return \XLite\Model\Payment\Base\Processor
     */
    protected function getProcessor()
    {
        if (!isset($this->processor)) {
            $transactionId = \XLite\Core\Request::getInstance()->transaction_id;

            $transaction = $transactionId
                ? \XLite\Core\Database::getRepo('\XLite\Model\Payment\Transaction')->find($transactionId)
                : null;

            $this->processor = $transaction && $transaction->getPaymentMethod()
                ? $transaction->getPaymentMethod()->getProcessor()
                : null;

            if (!$this->processor) {
                $this->processor = false;
            }
        }

        return $this->processor;
    }

    /**
     * Get payment template
     *
     * @return string|void
     */
    protected function getDefaultTemplate()
    {
        return $this->getProcessor() ? $this->getProcessor()->getInputTemplate() : null;
    }
}
