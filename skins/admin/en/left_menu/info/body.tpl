{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Left side info menu
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
<div class="arr"></div>
<div {printTagAttributes(getContainerTagAttributes()):h}>
  <ul IF="getItems()" class="menu">
    {foreach:getItems(),item}
      {item.display()}
    {end:}
  </ul>
</div>
