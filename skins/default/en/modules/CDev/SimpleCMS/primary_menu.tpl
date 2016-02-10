{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Top menu
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="navbar navbar-inverse mobile-hidden" role="navigation">
  <div class="collapse navbar-collapse">
    <ul id="top-main-menu" class="nav navbar-nav">
    <list name="header.flycategories" />
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
        <a href="{item.url}" {if:item.active}class="active"{end:}><span>{item.label}</span></a>
        {else:}
        <span class="primary-title">{item.label}</span>
        {end:}
    {end:}
      </li>
    {closeMenuList():h}
    </ul>
  </div>
</div>

<ul class="desctop-hidden desktop-hidden">
<list name="header.mobile_flycategories" />    
{foreach:getItems(),i,item}
  {if:isLevelUp(item.depth)}
    <ul>
  {else:}
    {if:!isFirstElement()}
    </li>
    {end:}
  {end:}

  {closeMenuList(item.depth):h}
  <li {displayItemClass(i,item):h}><a href="{item.url}" {if:item.active}class="active"{end:}>{item.label}</a>
{end:}
</li>
{closeMenuList():h}
</ul>
