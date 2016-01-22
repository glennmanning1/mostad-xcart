{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Online shipping carriers
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<ul class="online-carriers">
  <li FOREACH="getMethods(),method">
    <a href="{getSettingsURL(method)}" title="{method.name}">
      <div class="image">
        <img IF="{method.getAdminIconURL()}" src="{method.getAdminIconURL()}" alt="{method.name}" />
      </div>
      {method.name}
    </a>
  </li>
</ul>