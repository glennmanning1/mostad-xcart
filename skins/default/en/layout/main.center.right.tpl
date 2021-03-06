{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Right sidebar
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="layout.main.center", weight="300")
 *}

<div id="sidebar-second" class="column sidebar" IF="layout.isSidebarSecondVisible()">
  <div class="section">
    {if:layout.isSidebarSingle()}
      <list name="sidebar.single" />
    {else:}
      <list name="sidebar.second" />
    {end:}
  </div>
</div>
