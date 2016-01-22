{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Next product links
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 * @ListChild (list="next_previous.product.body", weight="100")
 *}

{if:next}
    <a href="{getItemURL(item)}">{t(#Next product#):h}</a><span class="fa fa-arrow-right arrow"></span>
{else:}
    <span class="fa fa-arrow-left arrow"></span><a href="{getItemURL(item)}" class="previous-link">{t(#Previous product#):h}</a>
{end:}
