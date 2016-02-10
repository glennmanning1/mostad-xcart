{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * All In One solutions
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="all-in-one-solutions">
    <div class="small-head">{t(#No merchant account required. Simple onboarding for you and easy checkout for your customers.#)}</div>
    <widget class="XLite\View\Payment\MethodsPopupList" paymentType="{_ARRAY_(%\XLite\Model\Payment\Method::TYPE_ALLINONE%)}" />
</div>
