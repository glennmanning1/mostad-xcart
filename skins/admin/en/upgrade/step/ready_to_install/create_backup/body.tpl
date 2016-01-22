{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Create backup warnings
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}

 <div class="create-backup-section">
  <div class="create-backup-section-frame">

  {if:isForce()}
    <div class="header">{t(#Restore links#)}!</div>

    <div class="description safe-mode-description">
      {t(#If your store is crashed after upgrade, you can recover it#,_ARRAY_(#article#^getArticleURL())):h}
      {t(#For any emergency you can use the hard, soft and restore-state links#)}
    </div>
  {else:}
    <div class="header">{t(#Create a backup#)}!</div>

    <div class="description safe-mode-description">
      {t(#If your store is crashed after upgrade, you can recover it#,_ARRAY_(#article#^getArticleURL())):h}
      {t(#For any emergency you can use the hard, soft and restore-state links#)}
      {t(#These links were already provided to you after this store was installed and will be emailed to you again after you start the upgrade process#)}
    </div>
  {end:}

  <list name="actions" type="inherited" />

  {if:isForce()}
    <widget class="\XLite\View\Button\ProgressState" style="email-links regular-button" label="Email me the links" jsCode="" />
  {end:}

  </div>
 </div>
