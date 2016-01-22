{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Common node
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<li {printTagAttributes(getListContainerAttributes()):h}>

  {if:getLink()}
    <a href="{getLink()}" class="location-title"><span>{getName()}</span></a>
  {else:}
    <span class="location-text">{getName()}</span>
  {end:}

  <ul class="location-subnodes" IF="getSubnodes()">
    <li FOREACH="getSubnodes(),node">
      <a href="{node.getLink()}" IF="!node.getName()=getName()">{node.getName()}</a>
      <a href="{node.getLink()}" IF="node.getName()=getName()" class="current">{node.getName()}</a>
    </li>
    <li class='more-link' IF='moreLinkNeeded()&getLink()'>
        <a href="{getMoreLink()}" class="location-title"><span>{t(#More#)}...</span></a>
    </li>
  </ul>

</li>
