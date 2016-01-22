{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Template
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="tabs.items", zone="admin", weight="5")
*}
{if:isPaymentMethodsPage()}
<li class="tab">
  <a href="{getModuleSettingsURL()}">{t(#Pay with Amazon#)}</a>
</li>
{end:}
