{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Automate shipping routine landing page
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

{if:!getShippingModules()}
  <widget
    template="automate_shipping_routine/parts/no_modules.tpl" />
{else:}
  <div class="automate-shipping-routine-wrapper">
    <p class='description'>{t(#Automate your shipping process with the services of our partners: print shipping labels, grab shipping orders info from eBay, ETSY, Amazon and other marketplaces; integrate with several shipping carriers in one spot and more.#)}</p>
    <table class="shipping-list-table">
      <thead>
        <tr>
          <th></th>
          <th FOREACH="getShippingModules(),module">
            <div class="logo-image-container">
              <img class="logo-image" src="{getImageURL(module)}" alt="{module.getModuleName()}">
            </div>
          </th>
        </tr>
      </thead>
      <tbody foreach="getShippingModuleProperties(),type,propertyGroup" class="{type}">
        <tr IF="{getGroupLabel(type)}" class="group-label">
          <th>
            <div class="property-label">{getGroupLabel(type)}</div>
          </th>
        </tr>
        <tr foreach="propertyGroup,propertyKey,propertyName">
          <th>
            <div class="property-label">{propertyName}</div>
          </th>
          <td foreach="getShippingModules(),module">
            <widget
              template="{getPropertyTemplate(getShippingModulePropertyValue(module,type,propertyKey))}"
              value="{getShippingModulePropertyValue(module,type,propertyKey)}" />
          </td>
        </tr>
      </tbody>
      <tbody class="buttons">
        <tr>
          <td></td>
          <td FOREACH="getShippingModules(),module">
            <widget
                IF="module.isInstalled()&hasSetting(module.getModuleInstalled())"
                class="XLite\View\Button\Link"
                location="{getSettingsForm(module)}"
                label="{t(#Settings#)}"
                style="regular-button" />
            <widget
                IF="!module.isInstalled()"
                class="XLite\View\Button\Link"
                location="{getMarketplaceURL(module)}"
                label="{t(#Install#)}"
                style="regular-main-button" />
            <div IF="module.isInstalled()&!hasSetting(module.getModuleInstalled())" class="installed-placeholder">
              <span>{t(#Installed#)}</span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="description bottom-description">
    <p>{t(#Haven't found what you're looking for? View more shipping modules#,_ARRAY_(#href#^getShippingModulesLink())):h}</p>
  </div>
{end:}
<hr>
<div class="bottom-actions">
  <a href="{buildURL(#shipping_methods#)}">{t(#Back to shipping methods#)}</a>
</div>
