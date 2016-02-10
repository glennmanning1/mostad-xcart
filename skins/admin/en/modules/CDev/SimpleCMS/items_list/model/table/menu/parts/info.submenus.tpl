{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Submenus count link 
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *}
{if:entity.getSubmenusCount()}
<a href="{buildURL(#menus#,##,_ARRAY_(#id#^entity.getMenuId(),#page#^entity.getType()))}" class="count-link">
	{entity.getSubmenusCount()} {t(#items#)}
</a>
{end:}
