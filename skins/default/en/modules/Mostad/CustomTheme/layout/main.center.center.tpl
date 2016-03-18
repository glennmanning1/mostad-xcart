{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Center box
 *
 * @author    Nova Horzions LLC <info@novahorizons.io>
 * @copyright Copyright (c) 2015 Nova Horzions LLC <info@novahorizons.io>. All rights reserved
 * @license   http://novahorizons.io/ License Agreement
 * @link      http://novahorizons.io/
 *
 * @ListChild (list="layout.main.center", weight="200")
 *}

<div id="content" class="column">
  <widget IF="{isTrialNoticeAutoDisplay()}" class="\XLite\View\ModulesManager\TrialNotice" />
  <div class="section">
    <a id="main-content"></a>
      {*<widget template="center.tpl" />*}
    <widget template="{getListingTemplate()}" />
  </div>
</div>
