{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Inline text field view
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<span class="value">
  {foreach:getTransactionData(),item}
  <div class="{item.css_class} payment-data-field-view">
    <span class="param-title{if:!item.value} force-display{end:}">{t(item.title)}:</span>
    <span IF="item.value" class="param-value">{item.value}</span>
    <span IF="!item.value" class="param-value">{t(#none#)}</span>
  </div>
  {end:}
</span>
