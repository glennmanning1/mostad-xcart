{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Plain address block
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="address-box-content clearfix">
  <ul class="address-box">
    {foreach:getAddressFields(),fieldName,fieldData}
      <li class="address-text-cell address-text-{fieldName}" data-name="{fieldName}" IF="{getFieldValue(fieldName,address)}">
        <ul class="address-text">
          <li class="address-text-label address-text-label-{fieldName}">{fieldData.label}:</li>
          <li class="address-text-value">{getFieldValue(fieldName,address)}</li>
          <li class="address-text-comma address-text-comma-{fieldName}">,</li>
        </ul>
      </li>
    {end:}
  </ul>
</div>
