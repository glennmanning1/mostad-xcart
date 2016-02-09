{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Payment method
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<widget class="\XLite\View\Payment\MethodStatus" method="{getPaymentMethod()}" />

<widget class="\XLite\View\Form\Payment\Method\Admin\Settings" name="payment_settings_form" />

  {if:isWidgetSettings()}
    <widget class="{paymentMethod.processor.getSettingsWidget()}" paymentMethod="{getPaymentMethod()}" />
  {else:}
    <widget template="{paymentMethod.processor.getSettingsWidget()}" />
  {end:}

  <widget IF="{paymentMethod.processor.useDefaultSettingsFormButton()}" class="\XLite\View\StickyPanel\Payment\Settings" />

<widget name="payment_settings_form" end />
