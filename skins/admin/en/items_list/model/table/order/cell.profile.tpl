{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Profile cell
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}


<div IF="entity.origProfile.anonymous" class="profile-anonymous-icon" title="{t(#Anonymous Customer#)}">
  {getSVGImage(#images/anonymous.svg#):h}
</div>
<div IF="!entity.origProfile.anonymous" class="profile-icon">&nbsp;</div>

<div class="profile-box">
  {if:isProfileRemoved(entity)}
    <span class="removed-profile-name">{getColumnValue(column,entity)}</span>
  {else:}
    <a href="{buildURL(#profile#,##,_ARRAY_(#profile_id#^entity.origProfile.getProfileId()))}">{getColumnValue(column,entity)}</a>
  {end:}
  <span class="profile-email" IF="entity.profile"><a href="mailto:{entity.profile.getLogin()}">{entity.profile.getLogin()}</a></span>
  <img IF="column.noWrap" src="images/spacer.gif" class="right-fade" alt="" />
</div>
