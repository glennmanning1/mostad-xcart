{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Dropdown button
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

<div class="btn-group dropup items-export">

  {if:isMultipleOptions()}
    <button type="button" class="btn regular-button toggle-list-action dropdown-toggle always-enabled" data-toggle="dropdown">
      <span>{t(getButtonLabel())}</span>
      <span class="caret"></span>
      <span class="sr-only"></span>
    </button>

    {if:getAdditionalButtons()}
    <ul class="dropdown-menu" role="menu">
      <li FOREACH="getAdditionalButtons(),button">{button.display():h}</li>
    </ul>
    {end:}

  {else:}
    <button type="button" class="btn regular-button always-enabled ">
      <span>{t(getButtonLabel())}</span>: <span>{getFirstProviderLabel()}</span>
    </button>
    <div class='hidden'>
      {foreach:getAdditionalButtons(),button}
        {button.display():h}
      {end:}
    </div>
  {end:}
</div>
