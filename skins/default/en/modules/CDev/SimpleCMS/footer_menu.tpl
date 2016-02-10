{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Top menu
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div id="secondary-menu" class="clearfix">
 <ul class="footer-menu">
    {foreach:getItems(),i,item}
      {if:isLevelUp(item.depth)}
        <ul>
      {else:}
        {if:!isFirstElement()}
        </li>
        {end:}
      {end:}

      {closeMenuList(item.depth):h}
      <li {displayItemClass(i,item):h}>
        {if:item.url}
        <a href="{item.url}" {if:item.active}class="active"{end:}>{item.label}</a>
        {else:}
        <span class="footer-title">{item.label}</span>
        {end:}
          
    {end:}
      </li>
    {closeMenuList():h}
 </ul>
</div>