{* vim: set ts=2 sw=2 sts=2 et: *}

{**
 * Product price value
 *
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 *
 *}

{if:getBlogData()}
<div class="blog-content">
    <h2>From Our Blog</h2>
    <ul>
        {foreach:getBlogData(),key,value}
        <li>
            <div class="blog-date-icon">{value.getMonth()} {value.getDay()}</div>
            <div class="blog-blurb">{value.getTitle()}</div>
            <div class="blog-link"><a href="{value.getLink()}">Read article</a></div>
        </li>
        {end:}
    </ul>
</div>
{end:}